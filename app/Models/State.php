<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, HasUuids,SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'is_active',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function User(): HasMany
    {
        return $this->hasMany(User::class, 'state_id');
    }
}
