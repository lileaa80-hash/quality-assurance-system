<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $fillable = [
        'code', 'name', 'type', 'parent_id', 'level',
        'accreditation_status', 'accreditation_expiry',
        'head_name', 'head_nip', 'address', 'phone',
        'email', 'metadata', 'is_active'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'accreditation_expiry' => 'date',
    ];

    // Relasi ke Atasan (Misal: Prodi ke Fakultas)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    // Relasi ke Bawahan (Misal: Fakultas punya banyak Prodi)
    public function children(): HasMany
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    // Relasi ke User yang ada di unit ini
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'unit_id');
    }
}