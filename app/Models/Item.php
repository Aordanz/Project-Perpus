<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $table = 'tbleksemplar';
    protected $primaryKey = 'nomor_eksemplar';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = null; // No updated_at in old DB for this table
    protected $guarded = [];

    // Accessors & Mutators
    public function getIdAttribute() { return $this->ideksemplar; }
    public function getBarcodeAttribute() { return $this->nomor_eksemplar; }
    public function setBarcodeAttribute($value) { $this->attributes['nomor_eksemplar'] = $value; }

    public function getBookIdAttribute() { return $this->idmaster; }
    public function setBookIdAttribute($value) { $this->attributes['idmaster'] = $value; }

    public function getLocationIdAttribute() { return $this->kodelokasi; }
    public function setLocationIdAttribute($value) { $this->attributes['kodelokasi'] = $value; }

    public function getCallNumberAttribute() { return $this->nopemesanan; }
    public function setCallNumberAttribute($value) { $this->attributes['nopemesanan'] = $value; }

    /**
     * Override kolom 'status' dari database karena isinya semua 'Tersedia'.
     * Gunakan 'kodestatus_eksemplar' untuk menentukan status aktual.
     */
    public function getStatusAttribute()
    {
        $kode = trim($this->kodestatus_eksemplar ?? '');
        
        switch (strtoupper($kode)) {
            case 'TSD':
                return 'Tersedia';
            case 'PJM':
                return 'Dipinjam';
            case 'MIS':
                return 'Hilang (Missing)';
            case 'RSK':
                return 'Rusak';
            case 'WED':
                return 'Ditarik (Weeded)';
            case 'JLD':
                return 'Sedang Dijilid';
            case 'R':
            case 'NL':
                return 'Baca di Tempat';
            default:
                return 'Tidak Tersedia';
        }
    }


    /**
     * Get the book associated with this item copy.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'idmaster', 'idmaster');
    }

    /**
     * Get the location of this item copy.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'kodelokasi', 'idlokasi');
    }
}
