<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Book extends Model
{
    protected $guarded = [];

    /**
     * Get the physical copies (items) of the book.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the locations where this book is stored through items.
     */
    public function locations()
    {
        return $this->hasManyThrough(Location::class, Item::class, 'book_id', 'id', 'id', 'location_id');
    }

    /**
     * Get the additional images of the book.
     */
    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class);
    }
}
