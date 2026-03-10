<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationQuestionnaire extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'year', 'semester', 
        'start_date', 'end_date', 'target_audience', 'target_units',
        'status', 'is_anonymous', 'allow_multiple_submissions',
        'summary_report', 'report_file', 'created_by'
    ];

    protected $casts = [
        'target_units' => 'array',
        'summary_report' => 'array',
        'is_anonymous' => 'boolean',
        'allow_multiple_submissions' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(EvaluationQuestion::class, 'questionnaire_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(EvaluationResponse::class, 'questionnaire_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}