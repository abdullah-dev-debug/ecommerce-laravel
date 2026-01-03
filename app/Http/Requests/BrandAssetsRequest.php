<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BrandAssetsRequest extends FormRequest
{
    private $entityTableMap = [
        'category' => "categories",
        'subcategory' => "sub_categories",
        'color' => "colors",
        'size' => "sizes",
        'unit' => "units",
        'brand' => "brands"
    ];

    /**
     * Check if user is logged in as Admin or Vendor
     */
    public function authorize(): bool
    {
        return $this->getCurrentRole('admin') || $this->getCurrentRole('vendor');
    }

    private function getCurrentRole($name): bool
    {
        return Auth::guard($name)->check();
    }

    public function rules(): array
    {
        $route = $this->route()->getName();

        return match (true) {

            str_contains($route, 'attributes.size.store') =>
            $this->createSize(),

            str_contains($route, 'attributes.size.update') =>
            $this->updateSize(),

            str_contains($route, 'attributes.color.store') =>
            $this->createColor(),

            str_contains($route, 'attributes.color.update') =>
            $this->updateColor(),

            str_contains($route, 'attributes.unit.store') =>
            $this->createUnit(),

            str_contains($route, 'attributes.unit.update') =>
            $this->updateUnit(),

            str_contains($route, 'subcategory.store') =>
            $this->createSubCategory(),

            str_contains($route, 'subcategory.update') =>
            $this->updateSubCategory(),

            default => [],
        };
    }


    // category Rules
    public function createCategory(): array
    {
        return $this->createItemRules(true, true, $this->entityTableMap['category']);
    }

    public function updateCategory(): array
    {
        $id = $this->route('category'); // route parameter for update
        return $this->updateItemRules(true, $this->entityTableMap['category'], $id);
    }

    // Sub category Rules
    public function createSubCategory(): array
    {
        $commonData = $this->createItemRules(false, true, $this->entityTableMap['subcategory']);
        return [
            ...$commonData,
            "category_id" => "required|exists:" . $this->entityTableMap['category'] . ',id'
        ];
    }

    public function updateSubCategory(): array
    {
        $table = $this->entityTableMap['subcategory'];
        $id = $this->route('subcategory');
        $commonData = $this->updateItemRules(true, $table, $id);
        return [
            ...$commonData,
            "category_id" => "sometimes|exists:" . $table = $this->entityTableMap['category'] . ',id'
        ];
    }

    // create color rules is given 
    public function createColor(): array
    {
        $table = $this->entityTableMap['color'];
        $data = $this->createItemRules(false, true, $table);
        return [
            ...$data,
            "code" => "required|unique:$table,code"
        ];
    }
    public function updateColor(): array
    {
        $id = $this->route('color');
        $table = $this->entityTableMap['color'];
        $data = $this->updateItemRules(true, $table, $id);
        return [
            ...$data,
            "code" => "sometimes"
        ];
    }

    // Size Rule is given 

    public function createSize(): array
    {
        $table = $this->entityTableMap['size'];
        $data = $this->createItemRules(false, true, $table);
        return [
            ...$data,
            "code" => "nullable",
            "description" => "nullable",
        ];
    }

    public function updateSize(): array
    {
        $id = $this->route('size');
        $table = $this->entityTableMap['size'];
        $data = $this->updateItemRules(true, $table, $id);
        return [
            ...$data,
            "code" => "sometimes",
            "description" => "sometimes",
        ];
    }


    // unit Rule is given 

    public function createUnit(): array
    {
        $table = $this->entityTableMap['unit'];
        $data = $this->createItemRules(false, true, $table);
        return [
            ...$data,
            "symbol" => "nullable",
            "type" => "nullable",
        ];
    }

    public function updateUnit(): array
    {
        $id = $this->route('unit');
        $table = $this->entityTableMap['unit'];
        $data = $this->updateItemRules(true, $table, $id);
        return [
            ...$data,
            "symbol" => "sometimes",
            "type" => "sometimes",
        ];
    }

    // Brands Rule is given 

    public function createBrand(): array
    {
        $table = $this->entityTableMap['brand'];
        return $this->createItemRules(true, true, $table);

    }

    public function updateBrand(): array
    {
        $id = $this->route('brand');
        $table = $this->entityTableMap['brand'];
        return $this->updateItemRules(true, $table, $id);
    }


    public function createItemRules(bool $isRequired = true, bool $isUnique = true, string $table): array
    {
        return [
            'icon' => ($isRequired ? 'required' : 'nullable') . '|file|mimes:jpg,png,webp|max:2048',
            'name' => 'required' . ($isUnique ? "|unique:$table,name" : ''),
            'slug' => ($isRequired ? 'required' : 'nullable') . ($isUnique ? "|unique:$table,slug" : ''),
            'status' => 'required|in:0,1',

        ];
    }

    public function updateItemRules(bool $isUnique = true, string $table, $id = null): array
    {
        return [
            'icon' => 'sometimes|file|mimes:jpg,png,webp|max:2048',
            'name' => 'sometimes' . ($isUnique ? "|unique:$table,name,$id" : ''),
            'slug' => 'sometimes' . ($isUnique ? "|unique:$table,slug,$id" : ''),
            'status' => 'sometimes|in:0,1'
        ];
    }
}
