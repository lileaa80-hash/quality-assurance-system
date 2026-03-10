<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTeam extends Model
{
    protected $fillable = ['audit_schedule_id', 'user_id', 'role'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class, 'audit_schedule_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}