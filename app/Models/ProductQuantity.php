<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductQuantity extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'range_from',
        'range_to',
        'price_per_unit',
    ];

    protected $hidden = [
        'product_id',
        'created_at',
        'updated_at',
    ];

    public function scopeOrder($query)
    {
        return $query->orderBy('range_from');
    }


    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function CartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'quantity_id');
    }

    public function Quotes(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'quantity_id');
    }

}
