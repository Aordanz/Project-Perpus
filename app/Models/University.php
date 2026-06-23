<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $guarded = [];

    /**
     * Get the locations for the university.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
