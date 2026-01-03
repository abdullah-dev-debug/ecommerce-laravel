<?php

namespace App\Services;

use App\Models\Transactions;
use App\Models\Order;
use App\Utils\AppUtils;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class TransactionService extends BaseService
{
    protected Transactions $transactionsModel;

    public function __construct(Transactions $transactions, AppUtils $appUtils)
    {
        parent::__construct($transactions, "Transaction not found!", $appUtils); 
        $this->transactionsModel = $transactions;
    }

    /**
     * Create Stripe Hosted Checkout session and return redirect
     */
    public function createStripeCheckoutSession(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => config('services.stripe.currency'),
                    'product_data' => [
                        'name' => $item->product->name ?? 'Product #' . $item->product_id,
                    ],
                    'unit_amount' => intval($item->total_price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => $lineItems,
            'success_url' => route('stripe.success', ['order_id' => $order->id]),
            'cancel_url' => route('stripe.cancel', ['order_id' => $order->id]),
            'metadata' => [
                'order_id' => $order->id,
                'customer_id' => auth()->guard('web')->user()?->id ?? null,
            ],
        ]);

        return redirect($session->url);
    }

    /**
     * Handle Stripe payment success
     */
    public function handleStripeSuccess(string $orderId, ?string $sessionId = null)
    {
        $order = Order::findOrFail($orderId);

        $transactionData = [
            'order_id' => $order->id,
            'transaction_number' => '#TXN-' . strtoupper(Str::random(10)),
            'method' => 'stripe',
            'gateway_transaction_id' => $sessionId,
            'gateway_intent_id' => $sessionId,
            'gateway_response' => null,
            'amount' => $order->total_amount,
            'currency_id' => 1,
            'status' => 'paid',
        ];

        $transaction = $this->create($transactionData);

        $order->update(['status' => 'paid']);

        return $transaction;
    }

    /**
     * Handle Stripe payment cancel
     */
    public function handleStripeCancel(string $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'cancelled']);
        }
        return $order;
    }
}
