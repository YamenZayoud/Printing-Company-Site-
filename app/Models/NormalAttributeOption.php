<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NormalAttributeOption extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'normal_att_id',
        'name',
        'price_type',
        'flat_price',
        'formula_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function NormalAttribute(): BelongsTo
    {
        return $this->belongsTo(NormalAttribute::class, 'normal_att_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryNormalOptions(): HasMany
    {
        return $this->hasMany(CategoryNormalOption::class, 'normal_option_id');
    }

    public function CartProductNormalOptions(): HasMany
    {
        return $this->hasMany(CartProductNormalOption::class, 'normal_option_id');
    }

    /** @noinspection PhpUnused */
    public function QuoteNormalOptions(): HasMany
    {
        return $this->hasMany(QuoteNormalOption::class, 'normal_option_id');
    }
}
