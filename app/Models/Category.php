<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $table = "categories";
    protected $fillable = [
        'icon',
        'name',
        'slug',
        'status'
    ];
    public $timestamps = true;
}
