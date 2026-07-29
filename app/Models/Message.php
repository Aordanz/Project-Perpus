<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /** Gunakan database opac_katalog agar tidak mengganggu database OPAC utama. */
    protected $connection = 'opac_katalog';

    protected $fillable = ['name', 'email', 'subject', 'message', 'attachments'];

    protected $casts = [
        'attachments' => 'array',
    ];
}
