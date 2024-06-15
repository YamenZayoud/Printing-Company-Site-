<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function Quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'work_days_id');
    }

    public function CartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'work_days_id');
    }

}
