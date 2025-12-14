<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BrandAssetsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $admin = $this->getcurrentRole('admin');
        $vendor = $this->getcurrentRole('vendor');
        return $admin || $vendor;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    private function getcurrentRole($name): bool
    {
        return Auth::guard($name)->check();
    }

    private $entityTableMap = [
        'brand' => 'brands',
        'category' => 'categories',
        'subcategory' => 'sub_categories',
        'unit' => 'units',
        'color' => 'colors',
        'size' => 'sizes'
    ];


    public function rules()
    {
        $parts = explode('.', $this->route()->getName());
        $action = array_pop($parts);
        $entity = ucfirst(array_pop($parts));
        $method = $action . $entity;
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }
        return [];
    }

    public function createColor(): array
    {
        $table = $this->entityTableMap['color'];

        return [
            "name" => "required|min:3|exists:$table,name",
            "slug" => "required|exists:$table,slug",
            "code" => "required|exists:$table,code",
            "status" => "required|in:0,1",
        ];
    }

    public function updateColor(): array
    {
        return [
            "name" => "sometimes",
            "slug" => "sometimes",
            "code" => "sometimes",
            "status" => "sometimes|in:0,1",

        ];
    }

    public function createSize(): array
    {
        $table = $this->entityTableMap['size'];
        return $this->createSmItems($table);
    }

    public function updateSize(): array
    {
        return $this->updateSmItems();
    }

    public function createUnit(): array
    {
        $table = $this->entityTableMap['unit'];
        return $this->createSmItems($table);
    }

    public function updateUnit(): array
    {
        return $this->updateSmItems();
    }

    public function createBrand(): array
    {
        $table = $this->entityTableMap['brand'];
        return $this->createAsset($table);
    }

    public function updateBrand(): array
    {
        return $this->updateAssets();
    }

    public function createCategory(): array
    {
        $table = $this->entityTableMap['category'];
        return $this->createAsset($table, 'required');
    }
    public function updateCategory(): array
    {
        return $this->updateAssets();
    }

    public function createSubCategory(): array
    {
        $table = $this->entityTableMap['subcategory'];
        $fields = $this->createAsset($table);
        return [
            ...$fields,
            "category_id" => "required|exists:{$this->entityTableMap['category']},id"
        ];
    }

    public function updateSubCategory(): array
    {
        $fields = $this->updateAssets();
        return [
            ...$fields,
            "category_id" => "sometimes|exists:{$this->entityTableMap['category']},id"
        ];
    }

    private function createSmItems($table): array
    {
        return [
            "name" => "required|min:5|unique:$table,name",
            "status" => "required|in:0,1",
        ];
    }
    private function updateSmItems(): array
    {
        return [
            "name" => "sometimes",
            "status" => "sometimes|in:0,1",
        ];
    }

    private function createAsset($table, $isValid = "nullable"): array
    {
        return [
            "name" => "required|min:5|unique:$table,name",
            "icon" => "$isValid|file|mimes:jpg,png,jpeg,webp|max:2048",
            "slug" => "required",
            "status" => "required|in:0,1",
        ];
    }
    private function updateAssets(): array
    {
        return [
            "name" => "sometimes",
            "icon" => "sometimes|file|mimes:jpg,png,jpeg,webp|max:2048",
            "slug" => "sometimes",
            "status" => "sometimes|in:0,1",
        ];
    }
}