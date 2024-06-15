<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function ProductImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /** @noinspection PhpUnused */
    public function ProductQuantities(): HasMany
    {
        return $this->hasMany(ProductQuantity::class, 'product_id');
    }

    public function Rates(): HasMany
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

    public function ProductTags(): HasMany
    {
        return $this->hasMany(ProductTag::class, 'tag_id');
    }

    public function CartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'product_id');
    }

    public function Quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'product_id');
    }
}
