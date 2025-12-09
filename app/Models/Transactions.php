<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends BaseModel
{
    protected $table = "transactions";

    protected $fillable = [
        'method',
        'order_id',
        'currency_id',
        'transaction_id',
        'amount',
        'is_cod',
        'cod_collect_at',
        'card_last4',
        'card_brand',
        'status'
    ];
    public $timestamps = true;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function isComplete(): bool
    {
        return $this->status === 'paid';
    }
}
