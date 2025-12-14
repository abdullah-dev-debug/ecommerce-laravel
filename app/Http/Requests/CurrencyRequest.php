<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CurrencyRequest extends FormRequest
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
            return $this->createCurrency();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateCurrency();
        }

        return [];
    }

    public function createCurrency(): array
    {
        return [
            "name" => "required|unique:currencies,name",
            "code" => "required|unique:currencies,code",
            "symbol" => "required|unique:currencies,symbol",
            "status" => "required|in:0,1"
        ];
    }
    public function updateCurrency(): array
    {
        return [
            "name" => "sometimes",
            "code" => "sometimes",
            "symbol" => "sometimes",
            "status" => "sometimes|in:0,1"
        ];
    }
}
