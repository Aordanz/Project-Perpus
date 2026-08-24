<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;

    protected $table = 'galeri_buku';

    protected $fillable = [
        'book_id',
        'image_path',
        'is_cover',
        'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'idmaster');
    }
}

