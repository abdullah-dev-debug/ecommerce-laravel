<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->createProduct();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateProduct();
        }

        return [];
    }

    /**
     * Validation rules for creating a product
     */
    public function createProduct(): array
    {
        return [
            "title" => "required|string|max:255",
            "sku" => "required|string|unique:products,sku",

            "description" => "required|string",

            "vendor_id" => "nullable|exists:vendors,id",
            "admin_id" => "nullable|exists:admins,id",

            "category_id" => "required|exists:categories,id",
            "sub_category_id" => "required|exists:sub_categories,id",
            "brand_id" => "required|exists:brands,id",

            "colors" => "nullable|array",
            "colors.*" => "exists:colors,id",

            "sizes" => "nullable|array",
            "sizes.*" => "exists:sizes,id",

            "unit_id" => "required|exists:units,id",

            "price" => "required|numeric|min:0",
            "cost_price" => "required|numeric|min:0",
            "discount_price" => "nullable|numeric|min:0",
            "discount_percentage" => "nullable|numeric|min:0|max:100",

            "quantity" => "required|numeric|min:0",
            "low_stock_threshold" => "required|numeric|min:0",
            "sold_count" => "nullable|numeric|min:0",
            "view_count" => "nullable|numeric|min:0",

            "thumbnail" => "required|file|mimes:jpg,png,webp,jpeg|max:5120",
            "gallery_photos" => "nullable|array",
            "gallery_photos.*" => "file|mimes:jpg,png,webp,jpeg|max:5120",

            "status" => "required|in:draft,active,inactive,out_of_stock",
            "is_featured" => "nullable|in:0,1",
            "is_trending" => "nullable|in:0,1",
            "is_bestseller" => "nullable|in:0,1",
            "manage_stock" => "nullable|in:0,1",

            "weight" => "nullable|numeric|min:0",
            "vat_tax" => "nullable|numeric|min:0",

            "meta_title" => "nullable|string|max:255",
            "meta_description" => "nullable|string|max:500",
            "meta_keywords" => "nullable|string|max:255",
        ];
    }

    /**
     * Validation rules for updating a product
     */
    public function updateProduct(): array
    {
        $productId = $this->route('product');

        return [
            "title" => "sometimes|string|max:255",
            "sku" => "sometimes|string|unique:products,sku," . $productId . ",id",
            "slug" => "sometimes|string|unique:products,slug," . $productId . ",id",
            "description" => "sometimes|string",

            "vendor_id" => "nullable|exists:vendors,id",
            "admin_id" => "nullable|exists:admins,id",

            "category_id" => "sometimes|exists:categories,id",
            "sub_category_id" => "sometimes|exists:sub_categories,id",
            "brand_id" => "sometimes|exists:brands,id",

            "colors" => "sometimes|array",
            "colors.*" => "exists:colors,id",

            "sizes" => "sometimes|array",
            "sizes.*" => "exists:sizes,id",

            "unit_id" => "sometimes|exists:units,id",

            "price" => "sometimes|numeric|min:0",
            "cost_price" => "sometimes|numeric|min:0",
            "discount_price" => "nullable|numeric|min:0",
            "discount_percentage" => "nullable|numeric|min:0|max:100",

            "quantity" => "sometimes|numeric|min:0",
            "low_stock_threshold" => "sometimes|numeric|min:0",
            "sold_count" => "nullable|numeric|min:0",
            "view_count" => "nullable|numeric|min:0",

            "thumbnail" => "sometimes|file|mimes:jpg,png,webp,jpeg|max:2048",
            "gallery_photos" => "nullable|array",
            "gallery_photos.*" => "file|mimes:jpg,png,webp,jpeg|max:2048",

            "status" => "sometimes|in:draft,active,inactive,out_of_stock",
            "is_featured" => "nullable|in:0,1",
            "is_trending" => "nullable|in:0,1",
            "is_bestseller" => "nullable|in:0,1",
            "manage_stock" => "nullable|in:0,1",

            "weight" => "nullable|numeric|min:0",
            "vat_tax" => "nullable|numeric|min:0",

            "meta_title" => "nullable|string|max:255",
            "meta_description" => "nullable|string|max:500",
            "meta_keywords" => "nullable|string|max:255",
        ];
    }
}
