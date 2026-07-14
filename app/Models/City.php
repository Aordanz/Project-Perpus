<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'tbltempat_terbit';
    protected $primaryKey = 'idtempat';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = null;
    
    protected $guarded = [];
}
