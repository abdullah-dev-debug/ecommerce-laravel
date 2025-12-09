<?php

namespace App\Models;
class Sizes extends BaseModel
{
    protected $table = "sizes";
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
    public $timestamps = true;

}
