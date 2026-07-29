<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    /** Gunakan database opac_katalog agar tidak mengganggu database OPAC utama server produksi. */
    protected $connection = 'opac_katalog';

    protected $guarded = [];

    /**
     * Get the locations for the university.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
