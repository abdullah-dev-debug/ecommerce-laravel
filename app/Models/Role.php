<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $table = "roles";
    protected $fillable = ['name','status'];
    public $timestamps = true;
}
