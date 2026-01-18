<?php

namespace App\Models;

class VendorPackage extends BaseModel
{
    protected $table = "vendor_packages";
    protected $fillable = ['vendor_id', 'name', 'price', 'duration', 'status'];
    public $timestamps = true;
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
