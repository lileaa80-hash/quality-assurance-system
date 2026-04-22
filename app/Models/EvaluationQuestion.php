<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationQuestion extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'questionnaire_id',
        'section',
        'question_text',
        'type',
        'options',
        'scale_labels',
        'weight',
        'order',
        'is_required',
    ];

    /**
     * Casting field agar otomatis dikonversi ke tipe data PHP yang sesuai.
     */
    protected $casts = [
        'options' => 'array',
        'scale_labels' => 'array',
        'is_required' => 'boolean',
        'weight' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Relasi ke kuesioner induk (EvaluationQuestionnaire).
     * Pastikan model EvaluationQuestionnaire sudah kamu buat juga ya.
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(EvaluationQuestionnaire::class, 'questionnaire_id');
    }

    /**
     * Helper untuk mendapatkan label tipe pertanyaan yang lebih rapi (opsional)
     */
    public function getTypeLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }
}