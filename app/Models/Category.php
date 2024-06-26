<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'name',
        'image',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function ($model) {
            $model->setSuperAttribute();
        });

    }

    public function setSuperAttribute()
    {
        $this->attributes['admin_id'] = \auth('Admin')->user()->id;
    }

    public function Admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryBinderyAttributes(): HasMany
    {
        return $this->hasMany(CategoryBinderyAttribute::class, 'category_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryNormalAttributes(): HasMany
    {
        return $this->hasMany(CategoryNormalAttribute::class, 'category_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryBinderyOptions(): HasMany
    {
        return $this->hasMany(CategoryBinderyOption::class, 'category_id');
    }

    /** @noinspection PhpUnused */
    public function CategoryNormalOptions(): HasMany
    {
        return $this->hasMany(CategoryNormalOption::class, 'category_id');
    }

    public function Products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
