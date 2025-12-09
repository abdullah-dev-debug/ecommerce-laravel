<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItems extends BaseModel
{
    protected $table = "cart_items";

    protected $fillable = [
        'cart_id',
        'vendor_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'item_subtotal',
        'item_total',
        'status',
    ];
    public $timestamps = true;

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variants(): BelongsTo
    {
        return $this->belongsTo(ProductVariants::class, 'product_variant_id');
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

}
