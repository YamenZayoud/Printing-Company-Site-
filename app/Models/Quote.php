<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity_id',
        'work_days_id',
        'custom_quantity',
        'quote_price',
        'expected_price',
        'description',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /** @noinspection PhpUnused */
    public function ProductQuantity(): BelongsTo
    {
        return $this->belongsTo(ProductQuantity::class, 'quantity_id');
    }

    public function QuoteBinderyOptions(): HasMany
    {
        return $this->hasMany(QuoteBinderyOption::class, 'quote_id');
    }

    /** @noinspection PhpUnused */
    public function QuoteNormalOptions(): HasMany
    {
        return $this->hasMany(QuoteNormalOption::class, 'quote_id');
    }

    /** @noinspection PhpUnused */
    public function WorkDays(): BelongsTo
    {
        return $this->belongsTo(Setting::class, 'work_days_id');
    }
}
