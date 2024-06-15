<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryNormalAttribute extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'normal_att_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function NormalAttribute(): BelongsTo
    {
        return $this->belongsTo(NormalAttribute::class, 'normal_att_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryNormalOptions(): HasMany
    {
        return $this->hasMany(CategoryNormalOption::class, 'category_normal_att_id');
    }
}
