<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'audit_schedule_id','unit_id','standard_id','standard_indicator_id','result','score','objective_evidence','notes','auditor_id','checked_at',
        'evidence_files',
    ];

    protected $casts = [
        'evidence_files' => 'array', 
        'checked_at' => 'datetime',
        'score' => 'integer',
    ];

    public function auditSchedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function standardIndicator(): BelongsTo
    {
        return $this->belongsTo(StandardIndicator::class);
    }

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}