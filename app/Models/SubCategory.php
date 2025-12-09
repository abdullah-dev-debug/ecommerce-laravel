<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends BaseModel
{
    protected $table = "sub_categories";
    protected $fillable = [
        'icon',
        'category_id',
        'name',
        'slug',
        'status'
    ];
    public $timestamps = true;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
