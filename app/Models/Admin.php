<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends BaseModel
{
    protected $table = "admins";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role_id',
        'ip',
    ];
    public $timestamps = true;

    protected $hidden = [
        'password'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
