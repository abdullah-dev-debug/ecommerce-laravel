<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();
        return match ($routeName) {
            "vendor.register" => $this->register(),
            "vendor.login" => $this->login(),
            default => []
        };
    }
    public function register(): array
    {
        return [
            "name" => "required|min:4",
            "email" => "required|unique:vendors,email",
            "password" => "required|min:8",
            "phone" => "required",
            "address" => "required",
            "ip" => "nullable|ip",
            "status" => "nullable",
        ];
    }
    public function login(): array
    {
        return [
            "email" => "required",
            "password" => "required|min:8",
            "ip" => "nullable|ip"


        ];
    }
}
