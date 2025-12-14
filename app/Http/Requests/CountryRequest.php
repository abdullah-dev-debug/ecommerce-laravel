<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CountryRequest extends FormRequest
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
            return $this->createCountry();
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return $this->updateCountry();
        }

        return [];
    }

    public function createCountry(): array
    {
        return [
            "name" => "required|unique:countries,name",
            "flag" => "required|file|mimes:jpg,jpeg,png,webp|max:2048",
            "code" => "required|unique:countries,code",
            "status" => "required|in:0,1"
        ];
    }
    public function updateCountry(): array
    {
        return [
            "name" => "sometimes|unique:countries,name" . $this->route('country'),
            "flag" => "sometimes|file|mimes:jpg,jpeg,png,webp|max:2048",
            "code" => "sometimes|unique:countries,code" . $this->route('country'),
            "status" => "sometimes|in:0,1"
        ];
    }
}
