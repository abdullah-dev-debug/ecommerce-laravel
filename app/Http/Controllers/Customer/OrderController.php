<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Constants\Messages;
use App\Http\Requests\OrderItemRequest;
use App\Http\Requests\OrderRequest;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\TransactionService;
use App\Utils\AppUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public const PAGE_KEY = 'order';
    public const MSG_CREATE_SUCCESS = self::PAGE_KEY . Messages::MSG_CREATE_SUCCESS;
    protected OrderService $orderService;
    protected TransactionService $transactionService;
    protected CustomerAddress $customerAddressModel;

    public function __construct(
        AppUtils $appUtils,
        OrderService $orderService,
        TransactionService $transactionService,
        CustomerAddress $customerAddressModel
    ) {
        parent::__construct($appUtils, new Order());
        $this->orderService = $orderService;
        $this->transactionService = $transactionService;
        $this->customerAddressModel = $customerAddressModel;
    }

    public function index()
    {
        return parent::executeWithTryCatch(function () {
            $orders = $this->model->with([
                'customer:id,name,email',
                'items.product:id,name',
                'transactions:id,order_id,status'
            ])
                ->latest()
                ->get();
            return view('admin.orders.list', [
                'orders' => $orders
            ]);
        });
    }

    public function storeAdminOrder(OrderRequest $orderRequest, OrderItemRequest $orderItemRequest)
    {
        return parent::handleOperation(function () use ($orderRequest, $orderItemRequest) {
            $this->createOrder($orderRequest, $orderItemRequest);
        }, self::MSG_CREATE_SUCCESS, false, 'admin.orders.list');
    }

    /**
     * Step 1: Customer submits order & goes to Stripe Hosted Checkout
     */
    public function stripeCheckout(OrderRequest $orderRequest, OrderItemRequest $orderItemRequest)
    {
        $order = $this->createOrder($orderRequest, $orderItemRequest);
        return $this->transactionService->createStripeCheckoutSession($order);
    }

    /**
     * Step 2: Payment success callback
     */
    public function stripeSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $sessionId = $request->query('session_id') ?? null;

        $transaction = $this->transactionService->handleStripeSuccess($orderId, $sessionId);

        return view('checkout.success', [
            'order' => $transaction->order
        ]);
    }

    /**
     * Step 3: Payment cancelled callback
     */
    public function stripeCancel(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = $this->transactionService->handleStripeCancel($orderId);

        return view('checkout.cancel', [
            'order' => $order
        ]);
    }



    /* -------------------- Helpers -------------------- */

    private function createOrder(OrderRequest $orderRequest, OrderItemRequest $orderItemRequest)
    {
        $customerData = $this->prepareOrderCustomerData($orderRequest);
        $orderData = $this->prepareOrderData($orderRequest);
        $orderItemData = $this->prepareOrderItemData($orderItemRequest);
        $order = $this->orderService->createOrderWithItems(
            $customerData,
            $orderData,
            [$orderItemData]
        );
        return $order;
    }

    private function generateUniqueSku($length = 8): string
    {
        return '#ORD-' . Str::upper(Str::random($length));
    }

    private function prepareOrderData(OrderRequest $orderRequest): array
    {
        $data = $orderRequest->validated();
        return [
            'customer_id' => Auth::user()->id ?? null,
            'order_number' => $this->generateUniqueSku(),
            'total_amount' => $data['total_amount'],
            'status' => 'pending',
        ];
    }

    private function prepareOrderCustomerData(OrderRequest $orderRequest): array
    {
        $data = $orderRequest->validated();
        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'country_id' => $data['country_id'],
            'city' => $data['city'],
            'state' => $data['state'],
            'pin_code' => $data['pin_code'],
        ];
    }

    private function prepareOrderItemData(OrderItemRequest $orderItemRequest): array
    {
        $data = $orderItemRequest->validated();
        return [
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'discounted_price' => $data['discounted_price'] ?? 0,
            'tax_amount' => $data['tax_amount'] ?? 0,
            'total_price' => $data['total_price'],
        ];
    }
}
