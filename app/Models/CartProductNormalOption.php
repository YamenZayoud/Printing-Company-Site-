<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProductNormalOption extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cart_product_id',
        'normal_option_id',
        'value',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function CartProduct(): BelongsTo
    {
        return $this->belongsTo(CartProduct::class, 'cart_product_id');
    }

    /** @noinspection PhpUnused */
    public function NormalOption(): BelongsTo
    {
        return $this->belongsTo(NormalAttributeOption::class, 'normal_option_id');
    }
}
