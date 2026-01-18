<?php

namespace App\Http\Controllers\Customer;

use App\Constants\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utils\AppUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public const VIEW_NAMESPACE = 'customer.product.';

    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Product());
    }

    /**
     * 📦 Product Listing
     */
    public function index()
    {
        return parent::executeWithTryCatch(function () {

            $products = $this->baseProductQuery()
                ->with(['category', 'brand', 'gallery'])
                ->latest()
                ->paginate(12);

            return view($this->returnIndexView(), compact('products'));
        });
    }

    /**
     * 🔍 Product Details
     */
    public function show(string $slug)
    {
        return parent::executeWithTryCatch(function () use ($slug) {

            $product = $this->baseProductQuery()
                ->where('slug', $slug)
                ->with(['gallery', 'variants', 'reviews'])
                ->firstOrFail();

            return view($this->returnShowView(), compact('product'));
        });
    }

    /**
     * ⭐ Featured Products
     */
    public function featured()
    {
        return parent::executeWithTryCatch(function () {

            $products = $this->baseProductQuery()
                ->featured()
                ->with('gallery')
                ->latest()
                ->get();

            return view($this->returnFeaturedView(), compact('products'));
        });
    }

    /**
     * 🔥 Trending Products
     */
    public function trending()
    {
        return parent::executeWithTryCatch(function () {

            $products = $this->baseProductQuery()
                ->trending()
                ->with('gallery')
                ->get();

            return view($this->returnTrendingView(), compact('products'));
        });
    }

    /**
     * 🏆 Best Seller Products
     */
    public function bestSeller()
    {
        return parent::executeWithTryCatch(function () {

            $products = $this->baseProductQuery()
                ->bestSeller()
                ->with('gallery')
                ->get();

            return view($this->returnBestSellerView(), compact('products'));
        });
    }

    /**
     * ⚖ Product Comparison
     */
    public function compare(Request $request)
    {
        return parent::executeWithTryCatch(function () use ($request) {

            $products = $this->baseProductQuery()
                ->whereIn('id', $request->input('products', []))
                ->get();

            return view($this->returnCompareView(), compact('products'));
        });
    }

    /**
     * 🔎 Base Product Query (Customer Side)
     */
    private function baseProductQuery(): Builder
    {
        return $this->model->query()->customerVisible();
    }

    /**
     * 📄 View Resolvers (YOUR STYLE)
     */
    private function returnIndexView(): string
    {
        return self::VIEW_NAMESPACE . 'index';
    }

    private function returnShowView(): string
    {
        return self::VIEW_NAMESPACE . 'show';
    }

    private function returnFeaturedView(): string
    {
        return self::VIEW_NAMESPACE . 'featured';
    }

    private function returnTrendingView(): string
    {
        return self::VIEW_NAMESPACE . 'trending';
    }

    private function returnBestSellerView(): string
    {
        return self::VIEW_NAMESPACE . 'bestseller';
    }

    private function returnCompareView(): string
    {
        return self::VIEW_NAMESPACE . 'compare';
    }
}
