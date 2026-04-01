<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditChecklist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'audit_schedule_id','unit_id','standard_id','standard_indicator_id','result','score','objective_evidence','notes','auditor_id','checked_at',
        'evidence_files',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'evidence_files' => 'array', // Automagically converts JSON to Array
        'checked_at' => 'datetime',
        'score' => 'integer',
    ];

    /**
     * Relationship to the Audit Schedule.
     */
    public function auditSchedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class);
    }

    /**
     * Relationship to the Unit being audited.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relationship to the Standard used for auditing.
     */
    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    /**
     * Relationship to the specific Standard Indicator.
     */
    public function standardIndicator(): BelongsTo
    {
        return $this->belongsTo(StandardIndicator::class);
    }

    /**
     * Relationship to the Auditor (User).
     */
    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}