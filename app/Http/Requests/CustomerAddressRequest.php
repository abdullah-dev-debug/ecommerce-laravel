<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerAddressRequest extends FormRequest
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
            return $this->createAddressRule();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateAddressRule();
        }

        return [];
    }

    public function createAddressRule(): array
    {
        return [
            "customer_id" => "nullable",
            "first_name" => "nullable|string|max:50",
            "last_name" => "nullable|string|max:50",
            "email" => "nullable|email|max:100",
            "phone" => "nullable|string|max:15",
            "address" => "required|string|max:255",
            "country_id" => "required|integer|exists:countries,id",
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "pin_code" => "required|string|max:10",
        ];
    }
    public function updateAddressRule(): array
    {
        return [
            "customer_id" => "nullable",
            "first_name" => "sometimes|required|string|max:50",
            "last_name" => "sometimes|required|string|max:50",
            "email" => "sometimes|required|email|max:100",
            "phone" => "sometimes|required|string|max:15",
            "address" => "sometimes|required|string|max:255",
            "country_id" => "sometimes|required|integer",
            "city" => "sometimes|required|string|max:100",
            "state" => "sometimes|required|string|max:100",
            "pin_code" => "sometimes|required|string|max:10",
        ];
    }
}
