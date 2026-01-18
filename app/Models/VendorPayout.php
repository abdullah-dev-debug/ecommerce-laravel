<?php

namespace App\Models;

class VendorPayout extends BaseModel
{
    protected $table = "vendor_payouts";
    protected $fillable = [
        'vendor_id',
        'amount',
        'method',
        'status',
        'request_at'
    ];
    public $timestamps = true;
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}