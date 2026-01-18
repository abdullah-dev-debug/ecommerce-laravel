<?php

namespace App\Models;

class VendorVerification extends BaseModel
{
    protected $table = "vendor_verifications";
    protected $fillable = [
        'vendor_id',
        'type',
        'file',
        'status',
        'request_at'
    ];
    public $timestamps = true;
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
