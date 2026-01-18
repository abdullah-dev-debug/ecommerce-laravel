<?php

namespace App\Models;

class CommissionSetting extends BaseModel
{
    protected $table = "commission_settings";
    protected $fillable = [
        'vendor_id',
        'category_id',
        'sub_category_id',
        'type',
        'value',
        'status'
    ];
    public $timestamps = true;
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
