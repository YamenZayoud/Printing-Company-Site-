<?php

namespace App\Models;

use App\Http\Resources\CategoryAttributes\BinderyOptionsResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProductBinderyOption extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cart_product_id',
        'bindery_option_id',
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
    public function BinderyOption(): BelongsTo
    {
        return $this->belongsTo(BinderyAttributeOption::class, 'bindery_option_id');
    }
}
