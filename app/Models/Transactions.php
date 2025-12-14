<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends BaseModel
{
    protected $table = "transactions";
    protected $fillable = [
        'order_id',
        'transaction_number',
        'method',
        'gateway_transaction_id',
        'gateway_intent_id',
        'amount',
        'currency_id',
        'status',
        'gateway_response',
    ];
    public $timestamps = true;
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
