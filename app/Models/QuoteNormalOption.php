<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteNormalOption extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'quote_id',
        'normal_option_id',
        'value',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function Quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    /** @noinspection PhpUnused */
    public function NormalOption(): BelongsTo
    {
        return $this->belongsTo(NormalAttributeOption::class, 'normal_option_id');
    }

}
