<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditSchedule extends Model
{
    protected $fillable = [
        'unit_id','title','description','start_date','end_date','status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function findings(): HasMany
    {
        return $this->hasMany(AuditFinding::class, 'audit_schedule_id');
    }
}