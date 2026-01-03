<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariants extends BaseModel
{
    protected $table = "product_variants";
    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'color_id', 'size_id'];
    public $timestamps = true;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Sizes::class, 'size_id');
    }
}

