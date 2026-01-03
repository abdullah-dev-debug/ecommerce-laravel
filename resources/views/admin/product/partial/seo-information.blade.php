<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>SEO Information</h3>
    </div>

    <div class="card-body">

        <div class="product-form-field-wrap">
            {{-- Meta Title --}}
            <div class="fm-group product-form-field-contain">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control"
                    value="{{ old('meta_title', $product->meta_title ?? '') }}">
            </div>

            {{-- Meta Keywords --}}
            <div class="fm-group product-form-field-contain">
                <label>Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control"
                    value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}">
            </div>
        </div>

        {{-- Meta Description --}}
        <div class="fm-group product-form-field-contain">
            <label>Meta Description</label>
            <textarea name="meta_description" class="form-control"
                rows="4">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
        </div>

    </div>
</div>