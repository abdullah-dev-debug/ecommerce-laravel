@php
    $product = $product ?? null;
    $variants = $product?->variants ?? collect();
@endphp
<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>Attributes Management</h3>
    </div>

    <div class="card-body">
        <div class="product-form-field-wrap">
            <!-- Category -->
            <div class="fm-group product-form-field-contain">
                <label>Category</label>
                <select name="category_id" class="form-select" id="category-select">
                    <option value="" disabled selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sub Category -->
            <div class="fm-group product-form-field-contain">
                <label>Sub Category</label>
                <select name="sub_category_id" class="form-select">
                    <option value="" disabled selected>Select Sub Category</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}"
                            @selected(old('sub_category_id', $product->sub_category_id ?? '') == $subCategory->id)>
                            {{ $subCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Brand -->
            <div class="fm-group product-form-field-contain">
                <label>Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="" disabled selected>Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            @selected(old('brand_id', $product->brand_id ?? '') == $brand->id)>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="product-form-field-wrap">
            <!-- Colors -->
            <div class="fm-group product-form-field-contain">
                <label>Color</label>
                <select name="colors[]" class="form-select multi-select" multiple>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}"
                            @selected(collect(old('colors', $variants?->pluck('color_id')->unique() ?? []))->contains($color->id))>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sizes -->
            <div class="fm-group product-form-field-contain">
                <label>Size</label>
                <select name="sizes[]" class="form-select multi-select" multiple>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}"
                            @selected(collect(old('sizes', $variants?->pluck('size_id')->unique() ?? []))->contains($size->id))>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit -->
            <div class="fm-group product-form-field-contain">
                <label>Unit</label>
                <select name="unit_id" class="form-select">
                    <option value="">Select Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"
                            @selected(old('unit_id', $product->unit_id ?? '') == $unit->id)>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
