<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Location extends Model
{
    protected $table = 'tbllokasi';
    protected $primaryKey = 'idlokasi';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = null;
    
    protected $guarded = [];

    // Accessors & Mutators
    public function getIdAttribute() { return $this->idlokasi; }
    public function getNameAttribute() { return $this->lokasi; }
    public function setNameAttribute($value) { $this->attributes['lokasi'] = $value; }

    public function getCodeAttribute() { return $this->lokasi; } // Map code to lokasi for now
    public function setCodeAttribute($value) { $this->attributes['lokasi'] = $value; }


    /**
     * Get the university that owns the location.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the physical book items in this location.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'kodelokasi', 'idlokasi');
    }

    /**
     * Get the books available in this location through items.
     */
    public function books(): HasManyThrough
    {
        return $this->hasManyThrough(Book::class, Item::class, 'kodelokasi', 'idbuku', 'idlokasi', 'idmaster');
    }
}
