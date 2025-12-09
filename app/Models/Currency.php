<?php

namespace App\Models;

class Currency extends BaseModel
{
    protected $table = "currencies";
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'status'
    ];
    public $timestamps = true;
}
