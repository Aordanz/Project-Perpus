<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatCache extends Model
{
    protected $fillable = [
        'pertanyaan_hash',
        'pertanyaan',
        'jawaban'
    ];
}
