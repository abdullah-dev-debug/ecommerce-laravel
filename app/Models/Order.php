<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    protected $table = "orders";
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_address_id',
        'total_amount',
        'status'
    ];
    public $timestamps = true;
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'order_id');
    }
    public function latestTransactionStatus(): string
    {
        return $this->transactions()
            ->latest('id')
            ->value('status') ?? '';
    }

}
