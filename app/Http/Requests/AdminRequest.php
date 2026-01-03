<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            "admin.register" => $this->register(),
            "admin.login" => $this->login(),
            default => []
        };
    }
    public function register(): array
    {
        return [
            "name" => "required|min:4",
            "email" => "required|unique:admins,email",
            "password" => "required|min:8",
            "phone" => "nullable",
            "address" => "nullable",
            "ip" => "nullable|ip"

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
