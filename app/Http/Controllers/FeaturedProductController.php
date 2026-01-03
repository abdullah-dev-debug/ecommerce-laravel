<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utils\AppUtils;

class FeaturedProductController extends Controller
{
    public function __construct(AppUtils $appUtils, Product $product)
    {
        parent::__construct($appUtils, $product);
    }

    public function index()
    {
        return parent::executeWithTryCatch(function () {
            $featuredProducts = $this->model->where('is_featured', 1)->get();
            return view('admin.catalog.featured-products', compact('featuredProducts'));
        });
    }


    public function trending()
    {
        return parent::executeWithTryCatch(function () {
            $trendingProducts = $this->model->with(['gallery','variants'])->where('is_featured', 1)->get();
            return view('customer.home.index', compact('trendingProducts'));
        });
    }

    public function bestSelling()
    {
        return parent::executeWithTryCatch(function () {
            $bestSellingProducts = $this->model->where('is_best_selling', 1)->get();
            return view('admin.catalog.best-selling-products', compact('bestSellingProducts'));
        });
    }
}
