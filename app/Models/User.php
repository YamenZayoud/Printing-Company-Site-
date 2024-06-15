<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'google_id',
        'f_name',
        'l_name',
        'company_name',
        'email',
        'phone',
        'password',
        'display_name',
        'is_active',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function State(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /** @noinspection PhpUnused */
    public function UserAddress(): HasOne
    {
        return $this->hasOne(UserAddress::class, 'user_id');
    }

    public function UserImage(): HasOne
    {
        return $this->hasOne(UserImage::class, 'user_id');
    }

    public function Contacts(): HasMany
    {
        return $this->hasMany(ContactUs::class, 'user_id');
    }

    public function Rates(): HasMany
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function Carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function Quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'user_id');
    }
}
