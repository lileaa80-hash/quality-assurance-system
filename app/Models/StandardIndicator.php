<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StandardIndicator extends Model
{
    protected $fillable = ['standard_id', 'code', 'indicator_text', 'target_value', 'weight'];

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }
}