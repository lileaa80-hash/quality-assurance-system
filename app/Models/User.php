<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke Units (Many to Many lewat user_units)
     */
    public function units()
    {
        // Menghubungkan User ke Unit melalui tabel user_units yang kamu buat
        return $this->belongsToMany(Unit::class, 'user_units')
                    ->withPivot('role_in_unit', 'start_date', 'end_date', 'is_active')
                    ->withTimestamps();
    }

    /* Catatan: Relasi di bawah ini saya beri komentar (/*) dulu 
       biar tidak MERAH di VS Code kamu sebelum kamu buat filenya.
    */

    /*
    public function documents() {
        return $this->hasMany(Document::class, 'created_by');
    }

    public function audit_schedules() {
        return $this->hasMany(AuditSchedule::class, 'created_by');
    }
    */
}