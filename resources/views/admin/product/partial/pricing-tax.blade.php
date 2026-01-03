<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>Pricing & Tax</h3>
    </div>

    <div class="card-body">
        <div class="product-form-field-wrap">
            <div class="fm-group product-form-field-contain">
                <label>Cost Price</label>
                <input type="number"
                       name="cost_price"
                       class="form-control"
                       value="{{ old('cost_price', $product->cost_price ?? 0) }}">
            </div>

            <div class="fm-group product-form-field-contain">
                <label>Selling Price</label>
                <input type="number"
                       name="price"
                       class="form-control"
                       value="{{ old('price', $product->price ?? 0) }}">
            </div>

            <div class="fm-group product-form-field-contain">
                <label>Discount Price</label>
                <input type="number"
                       name="discount_price"
                       class="form-control"
                       value="{{ old('discount_price', $product->discount_price ?? 0) }}">
            </div>

            <div class="fm-group product-form-field-contain">
                <label>VAT / TAX (%)</label>
                <input type="number"
                       name="vat_tax"
                       class="form-control"
                       value="{{ old('vat_tax', $product->vat_tax ?? 0) }}">
            </div>
        </div>
    </div>
</div>
