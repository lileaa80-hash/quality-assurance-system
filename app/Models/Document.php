<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number','title','type','status','description','parent_id','effective_date',
        'created_by','current_version','is_controlled','is_active'
    ];

    // Relasi ke User (Pembuat)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}