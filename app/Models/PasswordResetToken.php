<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordResetToken extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'token_id'; 


    protected $fillable = [

        'user_id',
        'email',
        'token',
        'created_at',
    ];

/**
 * Get the user that owns the PasswordResetToken
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

}
