<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FileAttachment extends Model
{
    protected $fillable = [
        'attachable_type','attachable_id','filename','original_filename', 'file_path', 'disk', 
        'mime_type', 'file_size', 'metadata','version', 'is_current', 'uploaded_by'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_current' => 'boolean',
        'file_size' => 'integer',
        'version' => 'integer'
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}