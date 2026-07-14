<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $table = 'tblbuku';
    protected $primaryKey = 'idbuku';
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = 'tgledit';

    protected $guarded = [];

    // Accessors & Mutators for compatibility with new web app
    public function getIdAttribute() { return $this->idbuku; }
    public function getTitleAttribute() { return $this->judul_buku; }
    public function setTitleAttribute($value) { $this->attributes['judul_buku'] = $value; }

    public function getAuthorAttribute() { return $this->pengarang; }
    public function setAuthorAttribute($value) { $this->attributes['pengarang'] = $value; }

    public function getPublisherAttribute() { 
        return $this->publisherRelation ? $this->publisherRelation->penerbit : $this->idpenerbit; 
    }
    public function setPublisherAttribute($value) { $this->attributes['idpenerbit'] = $value; }

    public function getSubjectAttribute() { return $this->subjek; }
    public function setSubjectAttribute($value) { $this->attributes['subjek'] = $value; }

    public function getPublishYearAttribute() { return $this->tahun; }
    public function setPublishYearAttribute($value) { $this->attributes['tahun'] = $value; }

    public function getEditionAttribute() { return $this->edisi; }
    public function setEditionAttribute($value) { $this->attributes['edisi'] = $value; }

    public function getLanguageAttribute() { 
        return $this->languageRelation ? $this->languageRelation->bahasa_dokumen : $this->idbahasa; 
    }
    public function setLanguageAttribute($value) { $this->attributes['idbahasa'] = $value; }

    public function getPublicationCityAttribute() { 
        return $this->cityRelation ? $this->cityRelation->tempat_terbit : ($this->attributes['publication_city'] ?? $this->idkota); 
    }
    public function setPublicationCityAttribute($value) { $this->attributes['idkota'] = $value; }

    public function getClassificationAttribute() { return $this->noklasifikasi; }
    public function setClassificationAttribute($value) { $this->attributes['noklasifikasi'] = $value; }

    public function getCallNumberAttribute() { return $this->nopanggil; }
    public function setCallNumberAttribute($value) { $this->attributes['nopanggil'] = $value; }

    public function getPhysicalDescriptionAttribute() { return $this->deskripsi; }
    public function setPhysicalDescriptionAttribute($value) { $this->attributes['deskripsi'] = $value; }

    public function getGeneralNoteAttribute() { return $this->catatan_umum; }
    public function setGeneralNoteAttribute($value) { $this->attributes['catatan_umum'] = $value; }

    /**
     * Get the physical copies (items) of the book.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'idmaster', 'idbuku');
    }

    /**
     * Get the locations where this book is stored through items.
     */
    public function locations()
    {
        return $this->hasManyThrough(Location::class, Item::class, 'idmaster', 'idlokasi', 'idbuku', 'kodelokasi');
    }

    /**
     * Get the additional images of the book.
     */
    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class, 'book_id', 'idbuku');
    }

    /**
     * Get the publisher of the book.
     */
    public function publisherRelation(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'idpenerbit', 'idpenerbit');
    }

    /**
     * Get the language of the book.
     */
    public function languageRelation(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'idbahasa', 'idbahasa_dokumen');
    }

    /**
     * Get the publication city of the book.
     */
    public function cityRelation(): BelongsTo
    {
        return $this->belongsTo(City::class, 'idkota', 'idtempat');
    }
}
