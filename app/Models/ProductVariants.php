<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariants extends BaseModel
{
    protected $table = "product_variants";
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock'
    ];
    public $timestamps = true;

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
