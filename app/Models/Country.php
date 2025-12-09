<?php

namespace App\Models;

class Country extends BaseModel
{
    protected $table = "countries";
    protected $fillable = [
        'flag',
        'name',
        'code',
        'status'
    ];
    public $timestamps = true;
}
