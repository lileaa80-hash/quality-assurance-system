<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccreditationPeriod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_id','period_name','type','status','start_date','submission_deadline','assesment_date','result_date','expiry_date','result_grade',
        'result_score','certificate_number','certificate_file','assessors','metadata',
    ];

    /**
     * The attributes that should be cast.
     * * Memastikan data JSON jadi array otomatis dan string tanggal jadi objek Carbon.
     */
    protected $casts = [
        'start_date' => 'date',
        'submission_deadline' => 'date',
        'assesment_date' => 'date',
        'result_date' => 'date',
        'expiry_date' => 'date',
        'result_score' => 'integer',
        'assessors' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Relationship to the Unit (Prodi/Jurusan).
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}