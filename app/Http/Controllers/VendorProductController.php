<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utils\AppUtils;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public const VENDOR_ID = 2;
    public function __construct(AppUtils $appUtils, Product $product)
    {
        parent::__construct($appUtils, $product);
    }

    public function index()
    {
        return parent::executeWithTryCatch(function () {
            $vendorProducts = $this->model->where('vendor_id', self::VENDOR_ID)->get();
            return view('admin.catalog.vendor-products', compact('vendorProducts'));
        });
    }

}
