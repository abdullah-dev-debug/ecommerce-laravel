<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishList extends BaseModel
{
    protected $table = "wishlists";
    protected $fillable = [
        'customer_id',
        'product_id'
    ];
    public $timestamps = true;

    public function customers(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
