<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccreditationBorang extends Model
{
    use HasFactory;

    protected $fillable = [
        'accreditation_period_id', 'standard_id', 'standard_indicator_id','response', 'analysis', 'target', 'achievement',
        'supporting_documents', 'self_assessment_score', 'assessor_score','assessor_notes', 'status', 'filled_by', 'verified_by', 'verified_at'
    ];

    protected $casts = [
        'supporting_documents' => 'array',
        'verified_at' => 'datetime',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(AccreditationPeriod::class, 'accreditation_period_id');
    }

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(StandardIndicator::class, 'standard_indicator_id');
    }
}