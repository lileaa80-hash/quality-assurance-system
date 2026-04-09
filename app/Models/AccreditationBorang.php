<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationBorang extends Model
{
    use HasFactory;

    protected $fillable = [
        'accreditation_period_id','standard_id','standard_indicator_id','response','analysis','target','achievement','supporting_documents',
        'self_assessment_score','assessor_score','assessor_notes','status','filled_by','verified_by','verified_at',
    ];

    // Mengubah JSON di database menjadi array PHP secara otomatis
    protected $casts = [
        'supporting_documents' => 'array',
        'verified_at' => 'datetime',
    ];

    /** * --- RELASI --- 
     */

    public function accreditationPeriod()
    {
        return $this->belongsTo(AccreditationPeriod::class);
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function standardIndicator()
    {
        return $this->belongsTo(StandardIndicator::class);
    }

    // User yang mengisi borang
    public function filler()
    {
        return $this->belongsTo(User::class, 'filled_by');
    }

    // User (Asesor/Admin) yang memverifikasi
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}