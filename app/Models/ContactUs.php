<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory, HasUuids,SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'message',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function User():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }
}