<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLinkes extends Model
{
    use HasFactory, HasUuids,SoftDeletes;

    protected $fillable = [
        'link',
        'social_id',
    ];

    /**
     * Get the Platform that owns the SocialLinkes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Social::class,'social_id');
    }
}
