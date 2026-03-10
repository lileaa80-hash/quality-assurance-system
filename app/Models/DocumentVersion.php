<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    protected $fillable = [
        'document_id', 
        'version_number', 
        'file_path', 
        'change_description', 
        'is_current'
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    /**
     * Relasi balik ke Dokumen utamanya.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}