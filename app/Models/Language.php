<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'tblbahasa_dokumen';
    protected $primaryKey = 'idbahasa_dokumen';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = null;
    
    protected $guarded = [];
}
