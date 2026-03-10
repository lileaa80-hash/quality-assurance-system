<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = ['code', 'title', 'type', 'category', 'description', 'status'];

    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class);
    }
}