<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BinderyAttributeOption extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'bindery_att_id',
        'name',
        'setup_price',
        'price_per_unit',
        'markup',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function BinderyAttribute(): BelongsTo
    {
        return $this->belongsTo(BinderyAttribute::class, 'bindery_att_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryBinderyOptions(): HasMany
    {
        return $this->hasMany(CategoryBinderyOption::class, 'bindery_option_id');
    }

    public function CartProductBinderyOption(): HasMany
    {
        return $this->hasMany(CartProductBinderyOption::class, 'bindery_option_id');
    }

    public function QuoteBinderyOptions(): HasMany
    {
        return $this->hasMany(QuoteBinderyOption::class, 'bindery_option_id');
    }
}
