<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Standard extends Model
{
    protected $fillable = ['code', 'name', 'description', 'version', 'is_active'];

    public function indicators(): HasMany
    {
        return $this->hasMany(StandardIndicator::class);
    }
}