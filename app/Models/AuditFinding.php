<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditFinding extends Model
{
    use HasFactory;

    protected $fillable = [
        'finding_number','audit_schedule_id','unit_id','audit_checklist_id','category','type','finding_description','criteria_reference',
        'objective_evidence','status','risk_level','supporting_files','photo_evidence','auditor_id','finding_date',
    ];

    protected $casts = [
        'supporting_files' => 'array', 
        'finding_date' => 'datetime',
        'risk_level' => 'integer',
    ];

    public function auditSchedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function auditChecklist(): BelongsTo
    {
        return $this->belongsTo(AuditChecklist::class);
    }

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}