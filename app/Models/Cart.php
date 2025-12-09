<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends BaseModel
{
    protected $table = "carts";
    protected $fillable = [
        'customer_id',
        'session_id',
        'sub_total',
        'discount_total',
    ];
    public $timestamps = true;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
