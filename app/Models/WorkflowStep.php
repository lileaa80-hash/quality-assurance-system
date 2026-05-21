<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowStep extends Model
{
    protected $fillable = [
        'workflow_id','name','step_order','approver_type','approver_value','requires_approval','time_limit_days','conditions'
    ];

    protected $casts = [
        'step_order' => 'integer',
        'requires_approval' => 'boolean',
        'time_limit_days' => 'integer',
        'conditions' => 'array', 
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class, 'workflow_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'workflow_step_id');
    }
}