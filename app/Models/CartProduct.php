<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartProduct extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity_id',
        'work_days_id',
        'custom_quantity',
        'final_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /** @noinspection PhpUnused */
    public function ProductQuantity(): BelongsTo
    {
        return $this->belongsTo(ProductQuantity::class, 'quantity_id');
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function CartProductBinderyOptions(): HasMany
    {
        return $this->hasMany(CartProductBinderyOption::class, 'cart_product_id');
    }

    public function CartProductNormalOptions(): HasMany
    {
        return $this->hasMany(CartProductNormalOption::class, 'cart_product_id');
    }

    /** @noinspection PhpUnused */
    public function WorkDays(): BelongsTo
    {
        return $this->belongsTo(Setting::class, 'work_days_id');
    }

    public function Cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
