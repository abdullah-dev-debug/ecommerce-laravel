<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
            return $this->createOrderRules();
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateOrderRules();
        }
        return [];
    }

    public function createOrderRules(): array
    {
        return [
            "first_name" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "email" => "required|email|max:100",
            "phone" => "required|string|max:15",
            "address" => "required|string|max:255",
            "country_id" => "required|integer|exists:countries,id",
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "pin_code" => "required|string|max:10",
            "total_amount" => "required|numeric|min:0",
            "status" => "required|string|in:pending,processing,shipped,delivered,cancelled",
        ];
    }
    public function updateOrderRules(): array
    {
        return [
            "first_name" => "sometimes|required|string|max:50",
            "last_name" => "sometimes|required|string|max:50",
            "email" => "sometimes|required|email|max:100",
            "phone" => "sometimes|required|string|max:15",
            "address" => "sometimes|required|string|max:255",
            "country_id" => "sometimes|required|integer|exists:countries,id",
            "city" => "sometimes|required|string|max:100",
            "state" => "sometimes|required|string|max:100",
            "pin_code" => "sometimes|required|string|max:10",
            "total_amount" => "sometimes|required|numeric|min:0",
            "status" => "sometimes|required|string|in:pending,processing,shipped,delivered,cancelled",
        ];
    }

}
