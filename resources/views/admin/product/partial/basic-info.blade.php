<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>Basic Information</h3>
    </div>

    <div class="card-body">
        <div class="product-form-field-wrap">
            <div class="fm-group product-form-field-contain">
                <label>Product Title <span class="required">*</span></label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $product->title ?? '') }}"
                       required>
            </div>

            <div class="fm-group product-form-field-contain">
                <div class="product-form-sku-btn-wrap">
                    <a href="javascript:void(0)" class="generate-sku-btn">Generate SKU</a>
                </div>
                <label>SKU</label>
                <input type="text"
                       name="sku"
                       class="form-control"
                       value="{{ old('sku', $product->sku ?? '') }}">
            </div>
        </div>

        <div class="fm-group product-form-field-contain">
            <label>Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
    </div>
</div>
