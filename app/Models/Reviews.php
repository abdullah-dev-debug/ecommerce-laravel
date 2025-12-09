<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reviews extends BaseModel
{
    protected $table = "reviews";
    protected $fillable = [
        'customer_id',
        'product_id',
        'rating',
        'comment',
        'is_approved'
    ];
    
    public $timestamps = true;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}