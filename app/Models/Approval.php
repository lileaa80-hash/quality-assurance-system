<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Approval extends Model
{
    protected $fillable = [
        'approvable_type','approvable_id','workflow_step_id','approver_id','status','notes','action_at'
    ];

    protected $casts = [
        'approvable_id' => 'integer',
        'workflow_step_id' => 'integer',
        'approver_id' => 'integer',
        'action_at' => 'datetime', 
    ];

    public function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    public function workflowStep(): BelongsTo
    {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}