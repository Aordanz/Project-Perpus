<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;

    /** Gunakan database opac_katalog agar tidak mengganggu database OPAC utama server produksi. */
    protected $connection = 'opac_katalog';

    protected $table = 'galeri_buku';

    protected $fillable = [
        'book_id',
        'image_path',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'idmaster');
    }
}
