<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id','version_number','change_description','file_path','file_name','file_size','mime_type','status',      
        'created_by','approved_by','approved_at'
    ];

    protected $casts = [
        'version_number' => 'integer',
        'file_size'      => 'integer',
        'approved_at'    => 'datetime',
        'created_at'     => 'datetime',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeCurrent($query)
    {
        return $query->where('status', 'current');
    }
}