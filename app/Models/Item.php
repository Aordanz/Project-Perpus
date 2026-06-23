<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $guarded = [];

    /**
     * Get the book associated with this item copy.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the location of this item copy.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
