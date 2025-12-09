<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends BaseModel
{
    protected $table = "order_items";
    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'quantity',
        'unit_price',
        'discounted_price',
        'tax_amount',
        'total_price'
    ];
    public $timestamps = true;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
