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
        $basePath = "admin.vendor";
        return match ($routeName) {
            "vendor.register" => $this->register(),
            "vendor.login" => $this->login(),
            "$basePath.store" => $this->register(),
            "$basePath.update" => $this->updateVendor(),
            "$basePath.verification" => $this->vendorVerification(),
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

    public function updateVendor()
    {
        return [
            "name" => "sometimes|min:4",
            "email" => "sometimes",
            "password" => "nullable|min:8",
            "phone" => "sometimes",
            "address" => "sometimes",
            "ip" => "nullable|ip",
            "status" => "sometimes",
        ];
    }

    public function vendorVerification()
    {
        return [
            "vendor_id" => "required|exist:vendors,id",
            "type" => "required|in:link,file",
            "file" => "required|file|mimes:pdf,docx,csv,jpg,jpeg|max:5048|url",
            "status" => "in:pending,paid,rejected",
            "request_at" => "nullable"
        ];
    }
}
