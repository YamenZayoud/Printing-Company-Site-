<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryBinderyOption extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'bindery_option_id',
        'category_bindery_att_id',
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
    public function BinderyOption(): BelongsTo
    {
        return $this->belongsTo(BinderyAttributeOption::class, 'bindery_option_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryBinderyAttribute(): BelongsTo
    {
        return $this->belongsTo(CategoryBinderyAttribute::class,'category_bindery_att_id');
    }

}
