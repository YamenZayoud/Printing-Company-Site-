<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialRecord extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'material_id',
        'quantity',
        'type',
    ];

    protected $hidden = [

        'deleted_at'
    ];

    public function Material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}