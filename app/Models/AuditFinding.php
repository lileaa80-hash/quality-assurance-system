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

    /**
     * Casting field agar otomatis menjadi tipe data yang sesuai
     */
    protected $casts = [
        'supporting_files' => 'array', // Supaya otomatis jadi array saat diakses
        'finding_date' => 'datetime',
        'risk_level' => 'integer',
    ];

    /**
     * Relasi ke Jadwal Audit
     */
    public function auditSchedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class);
    }

    /**
     * Relasi ke Unit Kerja
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke Checklist Audit (Nullable)
     */
    public function auditChecklist(): BelongsTo
    {
        return $this->belongsTo(AuditChecklist::class);
    }

    /**
     * Relasi ke Auditor (User)
     */
    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}