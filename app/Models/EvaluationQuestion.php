<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationQuestion extends Model
{
    protected $fillable = [
        'questionnaire_id', 'section', 'question_text', 'type',
        'options', 'scale_labels', 'weight', 'order', 'is_required'
    ];

    protected $casts = [
        'options' => 'array',
        'scale_labels' => 'array',
        'is_required' => 'boolean',
    ];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(EvaluationQuestionnaire::class, 'questionnaire_id');
    }
}