<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    protected $fillable = [
        'user_id',
        'state_id',
        'address',
        'zip_code',
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
            // $model->setSuperAttribute();
        });

    }

    public function setSuperAttribute()
    {
        $this->attributes['user_id'] = \auth('User')->user()->id;
    }

    public function User():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }
}