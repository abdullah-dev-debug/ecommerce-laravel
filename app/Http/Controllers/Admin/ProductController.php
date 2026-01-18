<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Messages;
use App\Constants\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Utils\AppUtils;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public const PAGE_KEY = 'Product';
    public const VIEW_NAMESPACE = "admin.product.";
    public const MSG_ENABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_ENABLED_SUCCESS;
    public const MSG_DISABLED_SUCCESS = self::PAGE_KEY . Messages::MSG_DISABLED_SUCCESS;

    // Product approval
    public const PRODUCT_APPROVED = 'Product has been approved successfully.';
    public const PRODUCT_REJECTED = 'Product has been rejected successfully.';
    public const PRODUCTS_APPROVED = 'Products have been approved successfully.';

    // Errors
    public const UNAUTHORIZED = 'You are not authorized to perform this action.';
    public const INVALID_STATUS = 'Invalid product status.';


    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Product());
    }

    public function index()
    {
        return parent::executeWithTryCatch(function (): View {
            $view = $this->returnListView();
            $infoRelations = $this->returnInfoRelations();
            $products = parent::getAllResources([], $infoRelations);
            return parent::successView($view, [
                'products' => $products
            ]);
        });
    }

    public function pendingApprovals()
    {
        return parent::executeWithTryCatch(function () {
            $products = $this->getAllResources([
                'status' => ProductStatus::PENDING
            ]);
            return $this->successView('admin.product.pending-approval', ["products" => $products]);
        });
    }

    public function approvedProduct($product)
    {
        return parent::handleOperation(function () use ($product) {
            $admin = $this->getAdminUser();
            $data = $this->findOrRedirect($product);
            $this->authorize('approve', $product);
            $data->update([
                "status" => ProductStatus::APPROVED,
                "approved_by" => $admin->id,
                "approved_at" => Carbon::now()
            ]);
        }, true, self::PRODUCT_APPROVED, $this->returnListView());
    }


    public function rejectedProduct($product)
    {
        return parent::handleOperation(function () use ($product) {
            $admin = $this->getAdminUser();
            $data = $this->findOrRedirect($product);
            $this->authorize('rejected', $product);
            $data->update([
                "status" => ProductStatus::REJECTED,
                "approved_by" => $admin->id,
                "approved_at" => Carbon::now()
            ]);
        }, true, self::PRODUCT_REJECTED, $this->returnListView());
    }

    public function bulkApprove(array $ids = [])
    {
        return parent::handleOperation(function () use ($ids) {

            if (empty($ids)) return;

            $admin = $this->getAdminUser();
            $this->authorize('bulkApprove', Product::class);

            Product::whereIn('id', $ids)
                ->where('status', ProductStatus::PENDING)
                ->update([
                    'status' => ProductStatus::APPROVED,
                    'approved_by' => $admin->id,
                    'approved_at' => Carbon::now()
                ]);
        }, true, self::PRODUCTS_APPROVED, $this->returnListView());
    }

    public function toggleStatus(int|string $product)
    {
        return parent::executeWithTryCatch(function () use ($product) {
            $admin = $this->getAdminUser();
            $this->authorize('toggleStatus', $this->model);
            $status = $this->toggleResourceStatus($product, self::MSG_DISABLED_SUCCESS, self::MSG_ENABLED_SUCCESS);
            return parent::successRedirect($status['message']);
        });
    }

    public function vendorProducts()
    {
        return parent::executeWithTryCatch(function () {
            $this->authorize('vendorProducts');

            $products = $this->model
                ->query()
                ->whereNotNull('vendor_id')
                ->with(['vendor', 'category', 'brand'])
                ->latest()
                ->get();

            return $this->successView(
                $this->returnListView(),
                ['products' => $products]
            );
        });
    }

    public function inventory()
    {
        return parent::executeWithTryCatch(function () {
            $inventoryProducts = Product::lowStock()
                ->with(['vendor', 'category'])
                ->orderBy('quantity')
                ->get();
            return $this->successView($this->returnInventoryView(), [
                'products' => $inventoryProducts
            ]);
        });
    }
    
    private function returnInfoRelations(): array
    {
        return [
            'vendor',
            'admin',
        ];
    }
    private function returnListView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }

    private function returnInventoryView(): string
    {
        return "admin.catalog.inventory";
    }
    private function getAdminUser(): Admin
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin instanceof Admin) abort(403, self::UNAUTHORIZED);
        return $admin;
    }
}
