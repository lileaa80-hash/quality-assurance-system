<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationResponse extends Model
{
    protected $fillable = [
        'questionnaire_id', 'question_id', 'respondent_id',
        'respondent_type', 'respondent_unit', 'respondent_email',
        'answer', 'answer_value', 'answer_options',
        'session_id', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'answer_options' => 'array',
    ];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(EvaluationQuestionnaire::class, 'questionnaire_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'respondent_id');
    }
}