<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\TransactionRequest;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\Transactions;
use App\Utils\AppUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OrderService;

class OrderController extends Controller
{
    public const MSG_ORDER_CREATED = 'Order has been created successfully.';
    public const MSG_ORDER_UPDATED = 'Order has been updated successfully.';
    public const MSG_ORDER_DELETED = 'Order has been deleted successfully.';
    protected OrderService $orderService;
    protected $transactionModel, $customerAddressModel;
    public function __construct(
        AppUtils $appUtils,
        OrderService $orderService,
        Transactions $transactionModel,
        CustomerAddress $customerAddressModel
    ) {
        parent::__construct($appUtils, new Order());
        $this->orderService = $orderService;
        $this->customerAddressModel = $customerAddressModel;
        $this->transactionModel = $transactionModel;
    }


    public function store(
        OrderRequest $orderRequest,
        OrderItemRequest $orderItemRequest,
        TransactionRequest $transactionRequest
    ) {
        return parent::executeWithTryCatch(function () use ($orderRequest, $orderItemRequest, $transactionRequest) {
            $orderCustomerData = $this->prepareOrderCustomerData($orderRequest);
            $orderData = $this->prepareOrderData($orderRequest);
            $orderItemData = $this->prepareOrderItemData($orderItemRequest);
            $transactionData = $this->prepareTransactionData($transactionRequest);
        });
    }

    private function generateUniqueSku(
        Model $model,
        $field = 'order_number',
        $prefix = '#ORD-',
        $length = 8

    ): string {
        do {
            $uniqueNumber = $prefix . strtoupper(Str::random($length));
        } while ($model->where($field, $uniqueNumber)->exists());
        return $uniqueNumber;
    }

    private function prepareOrderData(OrderRequest $orderRequest): array
    {
        $data = $orderRequest->validated();
        return [
            "customer_id" => Auth::check() ? Auth::user()->id : null,
            "order_number" => $this->generateUniqueSku($this->model),
            "total_amount" => $data['total_amount'],
            "status" => $data['status']
        ];
    }

    private function prepareOrderCustomerData(OrderRequest $orderRequest): array
    {
        $data = $orderRequest->validated();
        return [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "address" => $data['address'],
            "country_id" => $data['country_id'],
            "city" => $data['city'],
            "state" => $data['state'],
            "pin_code" => $data['pin_code'],
        ];
    }

    private function prepareOrderItemData(OrderItemRequest $orderItemRequest): array
    {
        $data = $orderItemRequest->validated();
        return [
            "product_id" => $data['product_id'],
            "quantity" => $data['quantity'],
            "unit_price" => $data['unit_price'],
            "discounted_price" => $data['discounted_price'],
            "tax_amount" => $data['tax_amount'],
            "total_price" => $data['total_price'],
        ];
    }

    private function prepareTransactionData(TransactionRequest $transactionRequest): array
    {
        $data = $transactionRequest->validated();
        return [
            "transaction_number" => $this->generateUniqueSku(
                $this->transactionModel,
                'transaction_id',
                '#TXN-',
                10
            ),
            "method" => $data['method'],
            "currency_id" => $data['currency_id'],
            "amount" => $data['amount'],
            "gateway_transaction_id" => null,
            "gateway_intent_id" => null,
            "gateway_response" => null,
            "status" => $data['status'],
        ];
    }
}