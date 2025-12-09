<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends BaseModel
{
    protected $table = "vendors";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role_id',
        'ip',
        'status'
    ];

    public $timestamps = true;

    protected $hidden = [
        'password',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    protected function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
