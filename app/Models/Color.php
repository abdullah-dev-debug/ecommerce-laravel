<?php

namespace App\Models;

class Color extends BaseModel
{
    protected $table = "colors";
    protected $fillable = ['name', 'slug', 'code', 'status'];
    public $timestamps = true;
}
