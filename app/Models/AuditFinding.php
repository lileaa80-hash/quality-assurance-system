<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditFinding extends Model
{
    protected $fillable = [
        'audit_schedule_id', 'indicator_id', 'description', 
        'category', // misal: Observasi, Minor, Major
        'status' // open, closed
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(AuditSchedule::class, 'audit_schedule_id');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(CorrectiveAction::class);
    }
}