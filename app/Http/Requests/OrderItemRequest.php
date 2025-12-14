<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->createOrderItemRules();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateOrderItemRules();
        }
        return [];
    }
    public function createOrderItemRules(): array
    {
        return [
            "product_id" => "required|exists:products,id",
            "quantity" => "required|integer|min:1",
            "unit_price" => "required|numeric|min:0",
            "discounted_price" => "nullable|numeric|min:0",
            "tax_amount" => "nullable|numeric|min:0",
            "total_price" => "required|numeric|min:0",
        ];
    }

    public function updateOrderItemRules(): array
    {
        return [
            "product_id" => "sometimes|exists:products,id",
            "quantity" => "sometimes|integer|min:1",
            "unit_price" => "sometimes|numeric|min:0",
            "discounted_price" => "sometimes|nullable|numeric|min:0",
            "tax_amount" => "sometimes|nullable|numeric|min:0",
            "total_price" => "sometimes|numeric|min:0",
        ];
    }
}
