<?php

namespace App\Models;
class Gallery extends BaseModel
{
    protected $table = "galleries";
    protected $fillable = [
        'product_id',
        'path'
    ];
    public $timestamps = true;

}
