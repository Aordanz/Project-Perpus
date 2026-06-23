<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Location extends Model
{
    protected $guarded = [];

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
        return $this->hasMany(Item::class);
    }

    /**
     * Get the books available in this location through items.
     */
    public function books(): HasManyThrough
    {
        return $this->hasManyThrough(Book::class, Item::class, 'location_id', 'id', 'id', 'book_id');
    }
}
