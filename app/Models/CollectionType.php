<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionType extends Model
{
    protected $table = 'tbljenis_koleksi';
    protected $primaryKey = 'idjns_koleksi';
    public $timestamps = false;
    protected $guarded = [];
}
