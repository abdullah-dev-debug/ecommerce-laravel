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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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

    public function createProduct(): array
    {
        return [
            "title" => "required",
            "sku" => "required|unique:products,sku",
            "slug" => "required|unique:products,slug",
            "description" => "required",
            "vendor_id" => "nullable|exists:vendors,id",
            "admin_id" => "nullable|exists:admins,id",
            "category_id" => "required|exists:categories,id",
            "sub_category_id" => "required|exists:sub_categories,id",
            "brand_id" => "required|exists:brands,id",
            "color_id" => "required|exists:colors,id",
            "size_id" => "required|exists:sizes,id",
            "unit_id" => "required|exists:units,id",
            "price" => "required|numeric|min:0",
            "cost_price" => "required|numeric|min:0",
            "discount_price" => "required|numeric|min:0",
            "discount_percentage" => "required|numeric|min:0|max:100",
            "low_stock_threshold" => "required|numeric|min:0",
            "sold_count" => "nullable",
            "view_count" => "nullable",
            "quantity" => "required|numeric|min:0",
            "thumbnail" => "required|file|mimes:jpg,png,webp,jpeg|max:2048",
            "status" => "required|in:draft,active,inactive,out_of_stock",
            "is_featured" => "nullable|in:0,1",
            "is_trending" => "nullable|in:0,1",
            "is_bestseller" => "nullable|in:0,1",
            "manage_stock" => "nullable|in:0,1",
            "weight" => "nullable|numeric|min:0",
            "vat_tax" => "nullable|numeric|min:0",
            "meta_title" => "nullable",
            "meta_description" => "nullable",
            "meta_keywords" => "nullable",
            "gallery_photos"   => "nullable|array",
            "gallery_photos.*" => "file|mimes:jpg,png,webp,jpeg|max:2048"
        ];
    }
    public function updateProduct(): array
    {
        return [
            "title" => "sometimes",
            "sku" => "sometimes|unique:products,sku," . $this->route('product') . ",id",
            "slug" => "sometimes|unique:products,slug," . $this->route('product') . ",id",
            "description" => "sometimes",
            "vendor_id" => "nullable|exists:vendors,id",
            "admin_id" => "nullable|exists:admins,id",
            "category_id" => "sometimes|exists:categories,id",
            "sub_category_id" => "sometimes|exists:sub_categories,id",
            "brand_id" => "sometimes|exists:brands,id",
            "color_id" => "sometimes|exists:colors,id",
            "size_id" => "sometimes|exists:sizes,id",
            "unit_id" => "sometimes|exists:units,id",
            "price" => "sometimes|numeric|min:0",
            "cost_price" => "sometimes|numeric|min:0",
            "discount_price" => "sometimes|numeric|min:0",
            "discount_percentage" => "sometimes|numeric|min:0|max:100",
            "low_stock_threshold" => "sometimes|numeric|min:0",
            "sold_count" => "nullable",
            "view_count" => "nullable",
            "quantity" => "sometimes|numeric|min:0",
            "thumbnail" => "sometimes|file|mimes:jpg,png,webp,jpeg|max:2048",
            "status" => "sometimes|in:draft,active,inactive,out_of_stock",
            "is_featured" => "nullable|in:0,1",
            "is_trending" => "nullable|in:0,1",
            "is_bestseller" => "nullable|in:0,1",
            "manage_stock" => "nullable|in:0,1",
            "weight" => "nullable|numeric|min:0",
            "vat_tax" => "nullable|numeric|min:0",
            "meta_title" => "nullable",
            "meta_description" => "nullable",
            "meta_keywords" => "nullable",
            "gallery_photos"   => "nullable|array",
            "gallery_photos.*" => "file|mimes:jpg,png,webp,jpeg|max:2048"

        ];
    }
}
