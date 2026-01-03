<div class="card product-form-container">
    <div class="card-body">
        <div class="product-form-flag-wrap">

            {{-- Featured --}}
            <label class="form-check-label" style="user-select:none;cursor:pointer;">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" class="form-check-input" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? 0) ? 'checked' : '' }}>
                Featured
            </label>

            {{-- Trending --}}
            <label class="form-check-label" style="user-select:none;cursor:pointer;">
                <input type="hidden" name="is_trending" value="0">
                <input type="checkbox" class="form-check-input" name="is_trending" value="1" {{ old('is_trending', $product->is_trending ?? 0) ? 'checked' : '' }}>
                Trending
            </label>

            {{-- Best Seller --}}
            <label class="form-check-label" style="user-select:none;cursor:pointer;">
                <input type="hidden" name="is_bestseller" value="0">
                <input type="checkbox" class="form-check-input" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller ?? 0) ? 'checked' : '' }}>
                Best Seller
            </label>

        </div>
    </div>
</div>