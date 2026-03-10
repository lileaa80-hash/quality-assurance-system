<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    // Kolom yang bisa diisi (Mass Assignment) - Sama persis dengan Migration kamu
    protected $fillable = [
        'code',
        'name',
        'type',
        'parent_id',
        'level',
        'accreditation_status',
        'accreditation_expiry',
        'head_name',
        'head_nip',
        'address',
        'phone',
        'email',
        'metadata',
        'is_active'
    ];

    /**
     * Relasi ke Users (Many to Many lewat user_units)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_units')
                    ->withPivot('role_in_unit', 'start_date', 'end_date', 'is_active')
                    ->withTimestamps();
    }

    /**
     * Relasi ke Unit Induk (Self Join)
     */
    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    /**
     * Relasi ke Unit Bawahan
     */
    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    /**
     * Relasi ke Audit Schedules
     */
    public function audit_schedules()
    {
        return $this->hasMany(AuditSchedule::class, 'unit_id');
    }
}