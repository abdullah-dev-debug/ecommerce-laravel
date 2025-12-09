<?php

namespace App\Models;

class Coupon extends BaseModel
{
    protected $table = "coupons";
    protected $fillable = [
        'code',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_to',
        'is_active'
     ];
    public $timestamps = true;
}
