<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "user.register" => $this->register(),
            "user.login" => $this->login(),
            "admin.user.store" => $this->register(),
            "admin.user.update" => $this->updateUser(),
            default => []
        };
    }
    public function updateUser(): array
    {
        return [
            "name" => "sometimes|required|min:4",
            "email" => "sometimes|required",
            "password" => "nullable|min:8",
            "ip" => "sometimes|ip",
            "status" => "sometimes|in:1,0",
        ];
    }
    public function register(): array
    {
        return [
            "name" => "required|min:4",
            "email" => "required|unique:users,email",
            "password" => "required|min:8",
            "ip" => "nullable|ip",
            "status" => "required|in:1,0",
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
