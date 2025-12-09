<?php

namespace App\Models;

class Brand extends BaseModel
{
    protected $table = "brands";
    protected $fillable = [
        'icon',
        'name',
        'slug',
        'status'
    ];
    public $timestamps = true;
}
