<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ProductManageController extends Controller
{
    public const VIEW_NAMESPACE = "product.";
    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Product());
    }
    public function detail(int|string $product): View
    {
        return parent::executeWithTryCatch(function () use ($product): View {
            $relations = $this->returnDetailRelations();
            $view = $this->returnDetailView();
            $data = $this->findOrRedirect($product, $relations);
            return parent::successView($view, [
                "product" => $data
            ]);
        });
    }

    public function inventory()
    {
        return parent::executeWithTryCatch(function () {
            $inventoryProducts = $this->model
                ->with(['vendor', 'admin', 'category', 'subCategory', 'brand'])
                ->where('quantity', '<=', DB::raw('low_stock_threshold'))
                ->orderBy('quantity', 'asc')
                ->get();

            return $this->successView('admin.catalog.inventory', [
                'products' => $inventoryProducts
            ]);
        });
    }


    private function returnDetailView(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . "details";
    }

    private function returnDetailRelations(): array
    {
        return [
            'category',
            'subCategory',
            'brand',
            'gallery',
            'vendor',
            'admin',
            'color',
            'size',
            'unit',
        ];
    }

}