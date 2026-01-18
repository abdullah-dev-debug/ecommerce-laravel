<?php

namespace App\Http\Controllers\Vendor;

use App\Constants\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Utils\AppUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public const VIEW_NAMESPACE = "vendor.product.";
    public const UNAUTHORIZED = 'You are not authorized to perform this action.';
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Product());
    }

    public function myProducts()
    {
        return parent::executeWithTryCatch(function () {
            $vendorProducts = $this->vendorProductsQuery()->get();
            return view($this->returnListView(), compact('vendorProducts'));
        });
    }
    public function draftProducts()
    {
        return parent::executeWithTryCatch(function () {
            $vendorProducts = $this->vendorProductsQuery()->where([
                "status" => ProductStatus::DRAFT
            ])->get();
            return view($this->returnDraftView(), compact('vendorProducts'));
        });
    }
    public function submitForApproval($id)
    {
        return parent::executeWithTryCatch(function () use ($id) {
            $product = $this->vendorProductsQuery()->findOrFail($id);

            if ($product->status !== ProductStatus::DRAFT) {
                abort(403, self::UNAUTHORIZED);
            }

            $product->update([
                'status' => ProductStatus::PENDING
            ]);



            return $this->successRedirect("Product sent for admin approval.");
        });
    }

    public function inventoryReport()
    {
        return parent::executeWithTryCatch(function () {
            $products = $this->vendorProductsQuery()
                ->select('id', 'title', 'sku', 'quantity', 'low_stock_threshold')
                ->get();

            return view($this->returnInventoryView(), compact('products'));
        });
    }

    public function lowStock()
    {
        return parent::executeWithTryCatch(function () {
            $products = $this->vendorProductsQuery()
                ->lowStock()
                ->get();

            return view($this->returnLowStockView(), compact('products'));
        });
    }

    private function vendorProductsQuery(): Builder
    {
        return $this->model->query()->forVendor($this->getVendorUser()->id);
    }

    private function getVendorUser(): Vendor
    {
        $vendor = Auth::guard('vendor')->user();
        if (!$vendor instanceof Vendor) abort(403, self::UNAUTHORIZED);
        return $vendor;
    }
    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . 'list';
    }

    private function returnDraftView(): string
    {
        return self::VIEW_NAMESPACE . 'draft';
    }
    private function returnInventoryView(): string
    {
        return self::VIEW_NAMESPACE . 'inventory-report';
    }
    private function returnLowStockView(): string
    {
        return self::VIEW_NAMESPACE . 'low-stock';
    }
}