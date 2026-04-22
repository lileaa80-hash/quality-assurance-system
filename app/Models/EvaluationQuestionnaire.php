<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationQuestionnaire extends Model
{
    use HasFactory;

    /**
     * Field yang dapat diisi secara massal.
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'year',
        'semester',
        'start_date',
        'end_date',
        'target_audience',
        'target_units',
        'status',
        'is_anonymous',
        'allow_multiple_submissions',
        'summary_report',
        'report_file',
        'created_by',
    ];

    /**
     * Casting tipe data agar otomatis dikonversi oleh Laravel.
     */
    protected $casts = [
        'target_units' => 'array',
        'summary_report' => 'array',
        'is_anonymous' => 'boolean',
        'allow_multiple_submissions' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'year' => 'integer',
    ];

    /**
     * Relasi ke EvaluationQuestion (Satu kuesioner punya banyak pertanyaan).
     */
    public function questions(): HasMany
    {
        return $this->hasMany(EvaluationQuestion::class, 'questionnaire_id')
                    ->orderBy('order', 'asc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isOpen(): bool
    {
        $today = now()->toDateString();
        return $this->status === 'active' 
               && $this->start_date <= $today 
               && $this->end_date >= $today;
    }
}