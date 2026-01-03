<?php
namespace App\Services;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BaseService;
use App\Utils\AppUtils;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{

    public const MSG_NOT_FOUND = 'Order not found.';
    protected $orderItemModel, $customerInfoModel;
    protected AppUtils $appUtils;
    public function __construct(
        Order $orderModel,
        OrderItem $orderItemModel,
        CustomerAddress $customerInfoModel,
        AppUtils $appUtils
    ) {
        $this->customerInfoModel = $customerInfoModel;
        $this->appUtils = $appUtils;
        parent::__construct($orderModel, self::MSG_NOT_FOUND, $appUtils);
        $this->orderItemModel = $orderItemModel;
    }

    private function returnOrderData(array $orderData, int|string $customerId)
    {
        $completeOrderData = $this->appUtils->merge_items($orderData, [
            "customer_address_id" => $customerId
        ]);

        return $completeOrderData;
    }

    private function returnOrderItemData(array $orderItemData, int|string $orderId)
    {
        $completeOrderItemData = $this->appUtils->merge_items(
            $orderItemData,
            [
                "order_id" => $orderId
            ]
        );
        return $completeOrderItemData;
    }

    public function createOrderWithItems(
        array $customerInfoData,
        array $orderData,
        array $orderItemData
    ) {
        return DB::transaction(function () use ($customerInfoData, $orderData, $orderItemData) {
            $customerInfo = $this->customerInfoModel->create($customerInfoData);
            $completeOrderData = $this->returnOrderData($orderData, $customerInfo->id);
            $order = parent::create($completeOrderData);
            $completeOrderItemData = $this->returnOrderItemData($orderItemData, $order->id);
            $this->orderItemModel->insert($completeOrderItemData);
            return $order;
        });
    }

    public function updateOrderWithItems(
        int|string $id,
        array $customerInfoData,
        array $orderData,
        array $orderItemData
    ) {
        return DB::transaction(function () use ($id, $customerInfoData, $orderData, $orderItemData) {
            $order = parent::update($orderData, $id);
            $customerInfo = $this->customerInfoModel->findOrFail($order->customer_address_id);
            $customerInfo->update($customerInfoData);
            $completeOrderItemData = $this->returnOrderItemData($orderItemData, $order->id);
            foreach ($completeOrderItemData as $item) {
                $existingOrderItem = $this->orderItemModel->where(['order_id' => $id])->where([
                    "product_id" => $item['product_id']
                ])->first();
                $item['order_id'] = $id;
                if ($existingOrderItem) {
                    $existingOrderItem->update($completeOrderItemData);
                } else {
                    $existingOrderItem->create($completeOrderItemData);
                }
            }
            return $order;
        });
    }

    public function deleteOrderWithItems(int|string $id)
    {
        return DB::transaction(function () use ($id): bool|null {
            $currentOrder = parent::getSingleItem($id);
            $this->customerInfoModel->findOrFail($currentOrder->customer_address_id)->delete();
            $this->orderItemModel->where([
                "order_id" => $id
            ])->delete();
            return $currentOrder->delete();
        });
    }

}