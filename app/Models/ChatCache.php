<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatCache extends Model
{
    /** Gunakan database opac_katalog agar tidak mengganggu database OPAC utama. */
    protected $connection = 'opac_katalog';

    protected $fillable = [
        'pertanyaan_hash',
        'pertanyaan',
        'jawaban'
    ];
}
