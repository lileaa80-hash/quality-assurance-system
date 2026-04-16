<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'document_number','title','type','status','description','parent_id','effective_date','created_by',
        'current_version','is_controlled','is_active',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'effective_date' => 'date',
        'is_controlled'  => 'boolean',
        'is_active'      => 'boolean',
        'current_version'=> 'integer',
    ];

    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class, 'document_id');
    }

    public function latestVersion(): HasOne
    {
        return $this->hasOne(DocumentVersion::class, 'document_id')->where('status', 'current');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Document::class, 'parent_id');
    }
}