<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // INI BAGIAN PALING PENTING! 
    // Pastikan 'document_number' ada di dalam daftar ini.
    protected $fillable = [
        'document_number','title','type','status','description','parent_id','effective_date','created_by','current_version','is_controlled', 
        'is_active'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}