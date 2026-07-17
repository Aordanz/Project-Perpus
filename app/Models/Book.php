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

    /**
     * DDC (Dewey Decimal Classification) — Sistem klasifikasi standar internasional perpustakaan.
     * Digit pertama dari kolom `noklasifikasi` menentukan kategori utama buku.
     */
    const DDC_CATEGORIES = [
        '0' => 'Karya Umum & Informasi',
        '1' => 'Filsafat & Psikologi',
        '2' => 'Agama',
        '3' => 'Ilmu Sosial',
        '4' => 'Bahasa',
        '5' => 'Sains & Matematika',
        '6' => 'Teknologi & Kedokteran',
        '7' => 'Kesenian & Rekreasi',
        '8' => 'Sastra',
        '9' => 'Sejarah & Geografi',
        'R' => 'Referensi',
        'D' => 'Karya Ilmiah',
    ];

    const DDC_ICONS = [
        '0' => 'ph-desktop',
        '1' => 'ph-brain',
        '2' => 'ph-mosque',
        '3' => 'ph-users-three',
        '4' => 'ph-translate',
        '5' => 'ph-flask',
        '6' => 'ph-stethoscope',
        '7' => 'ph-palette',
        '8' => 'ph-book-open-text',
        '9' => 'ph-globe-hemisphere-west',
        'R' => 'ph-bookmarks',
        'D' => 'ph-scroll',
    ];

    /**
     * Mendapatkan daftar semua kategori DDC beserta icon-nya.
     */
    public static function getDdcCategories(): array
    {
        $categories = [];
        foreach (self::DDC_CATEGORIES as $key => $name) {
            $categories[$key] = [
                'name' => $name,
                'icon' => self::DDC_ICONS[$key] ?? 'ph-books',
            ];
        }
        return $categories;
    }

    /**
     * Mendapatkan kunci DDC (digit pertama noklasifikasi) untuk buku ini.
     */
    public function getCategoryKeyAttribute(): ?string
    {
        $klas = trim($this->noklasifikasi ?? '');
        if (empty($klas)) {
            return null;
        }
        $firstChar = strtoupper(substr($klas, 0, 1));
        if (array_key_exists($firstChar, self::DDC_CATEGORIES)) {
            return $firstChar;
        }
        return null;
    }

    /**
     * Override kolom `category` dari database.
     * Mengembalikan nama kategori berdasarkan DDC (digit pertama noklasifikasi).
     */
    public function getCategoryAttribute(): string
    {
        $key = $this->category_key;
        if ($key !== null && isset(self::DDC_CATEGORIES[$key])) {
            return self::DDC_CATEGORIES[$key];
        }
        return 'Umum';
    }

    // Accessors & Mutators for compatibility with new web app
    public function getIdAttribute() { return $this->idmaster; }
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
        return $this->hasMany(Item::class, 'idmaster', 'idmaster');
    }

    /**
     * Get the locations where this book is stored through items.
     */
    public function locations()
    {
        return $this->hasManyThrough(Location::class, Item::class, 'idmaster', 'idlokasi', 'idmaster', 'kodelokasi');
    }

    /**
     * Get the additional images of the book.
     */
    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class, 'book_id', 'idmaster');
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
