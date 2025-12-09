<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantAttributeValues extends BaseModel
{
    protected $table = "variant_attribute_values";
    protected $fillable = [
        'attribute_id',
        'value',
        'code'
    ];
    public $timestamps = true;

    public function attribute () : BelongsTo {
        return $this->belongsTo(VariantAttribute::class,'attribute_id');
    }
}
