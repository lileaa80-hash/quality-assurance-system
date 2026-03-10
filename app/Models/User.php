<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang bisa diisi (Mass Assignment).
     * Pastikan kolom baru dari migration kamu ada di sini.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'position',
        'signature',
        'is_active',
        'unit_id', // Tambahkan ini jika kamu punya relasi ke tabel units
    ];

    /**
     * Kolom yang disembunyikan saat data ditampilkan (misal dalam API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Tabel Unit.
     * User bekerja di unit mana?
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}