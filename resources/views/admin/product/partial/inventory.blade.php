<div class="card product-form-container">
    <div class="product-form-header card-header">
        <h3>Inventory Management</h3>
    </div>

    <div class="card-body">
        <div class="product-form-field-wrap">
            <div class="fm-group product-form-field-contain">
                <label>Quantity</label>
                <input type="number"
                       name="quantity"
                       class="form-control"
                       value="{{ old('quantity', $product->quantity ?? 0) }}">
            </div>

            <div class="fm-group product-form-field-contain">
                <label>Low Stock Alert</label>
                <input type="number"
                       name="low_stock_threshold"
                       class="form-control"
                       value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 0) }}">
            </div>

            <div class="fm-group product-form-field-contain">
                <label>Manage Stock</label>
                <select name="manage_stock" class="form-select">
                    <option value="1" @selected(old('manage_stock', $product->manage_stock ?? 1) == 1)>Yes</option>
                    <option value="0" @selected(old('manage_stock', $product->manage_stock ?? 1) == 0)>No</option>
                </select>
            </div>

            <div class="fm-group product-form-field-contain">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status', $product->status ?? '') == 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $product->status ?? '') == 'inactive')>Inactive</option>
                    <option value="draft" @selected(old('status', $product->status ?? '') == 'draft')>Draft</option>
                    <option value="out_of_stock" @selected(old('status', $product->status ?? '') == 'out_of_stock')>Out of Stock</option>
                </select>
            </div>
        </div>
    </div>
</div>
