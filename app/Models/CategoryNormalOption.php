<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryNormalOption extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'normal_option_id',
        'category_normal_att_id',
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

    /** @noinspection PhpUnused */
    public function NormalOption(): BelongsTo
    {
        return $this->belongsTo(NormalAttributeOption::class, 'normal_option_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryNormalAttribute(): BelongsTo
    {
        return $this->belongsTo(CategoryNormalAttribute::class, 'category_normal_att_id');
    }
}
