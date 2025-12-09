<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            $this->isMethod('post') => $this->createRoles(),
            $this->isMethod('patch') | $this->isMethod('put') => $this->updateRoles(),
            "default" => []
        ];
    }

    public function createRoles(): array
    {
        return [
            "name" => "required|min:3",
            "status" => "required|in:0,1"
        ];
    }
    public function updateRoles(): array
    {
        return [
            "name" => "sometimes|min:3",
            "status" => "sometimes|in:0,1"
        ];
    }
}
