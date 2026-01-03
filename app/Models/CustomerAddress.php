<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends BaseModel
{
    protected $table = 'customer_addresses';
    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'address_type',
        'address',
        'phone',
        'country_id',
        'city',
        'state',
        'pin_code'
    ];
    public $timestamps = true;
    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_id'
        );
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }
}
