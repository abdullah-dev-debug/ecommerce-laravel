<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    protected $table = "products";
    protected $fillable = [
        'title',
        'sku',
        'slug',
        'description',
        'vendor_id',
        'admin_id',
        'category_id',
        'sub_category_id',
        'brand_id',
        'color_id',
        'size_id',
        'unit_id',
        'price',
        'cost_price',
        'discount_price',
        'discount_percentage',
        'low_stock_threshold',
        'sold_count',
        'view_count',
        'quantity',
        'thumbnail',
        'status',
        'is_featured',
        'is_trending',
        'is_bestseller',
        'manage_stock',
        'weight',
        'shipping_class',
        'vat_tax',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public $timestamps = true;

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(Sizes::class, 'size_id');
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariants::class, 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Reviews::class, 'product_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(CartItems::class, 'product_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(WishList::class, 'product_id');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}