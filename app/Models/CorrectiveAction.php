<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectiveAction extends Model
{
    protected $fillable = [
        'audit_finding_id', 'action_plan', 'deadline', 
        'pic_id', 'status', 'completion_date'
    ];

    protected $casts = [
        'deadline' => 'date',
        'completion_date' => 'date',
    ];

    public function finding(): BelongsTo
    {
        return $this->belongsTo(AuditFinding::class, 'audit_finding_id');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}