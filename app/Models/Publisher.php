<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'tblpenerbit';
    protected $primaryKey = 'idpenerbit';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = null;
    
    protected $guarded = [];
}