<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransactionRequest extends FormRequest
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
            return $this->createTransactionRules();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateTransactionRules();
        }
        return [];
    }

    public function createTransactionRules(): array
    {
        return [
            "method" => "required|string|in:" . implode(',', config('payment.payment_methods')),
            "currency_id" => "required|exists:currencies,id",
            "amount" => "required|numeric|min:0",
            "status" => "required|string|in:" . implode(',', config('payment.payment_status')),
        ];
    }

    public function updateTransactionRules(): array
    {
        return [
            "status" => "sometimes|string|in:" . implode(',', config('payment.payment_status')),
        ];
    }
}
