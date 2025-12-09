<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantAttribute extends BaseModel
{
    protected $table = "variant_attributes";
    protected $fillable = [
        'product_varint_id',
        'name',
        'slug'
    ];
    public $timestamps = true;

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariants::class, 'product_varint_id');
    }
}
