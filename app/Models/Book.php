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
        '0' => 'Karya umum, komputer, informasi',
        '1' => 'Filsafat dan psikologi',
        '2' => 'Agama',
        '3' => 'Ilmu sosial',
        '4' => 'Bahasa',
        '5' => 'Ilmu murni (sains)',
        '6' => 'Teknologi (applied sciences)',
        '7' => 'Seni dan rekreasi',
        '8' => 'Sastra',
        '9' => 'Sejarah dan geografi',
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
     * Mendapatkan kunci DDC (digit pertama nopanggil) untuk buku ini.
     */
    public function getCategoryKeyAttribute(): ?string
    {
        $panggil = trim($this->nopanggil ?? '');
        if (empty($panggil)) {
            $panggil = trim($this->noklasifikasi ?? '');
        }
        if (empty($panggil)) {
            return null;
        }

        // Match first digit character (0-9) in the call number or classification
        if (preg_match('/[0-9]/', $panggil, $matches)) {
            $firstDigit = $matches[0];
            if (array_key_exists($firstDigit, self::DDC_CATEGORIES)) {
                return $firstDigit;
            }
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

    /**
     * Get the collection type relation from tbljenis_koleksi.
     */
    public function collectionTypeRelation(): BelongsTo
    {
        return $this->belongsTo(CollectionType::class, 'idjenis_koleksi', 'idjns_koleksi');
    }

    /**
     * Mendapatkan nama jenis koleksi yang sebenarnya dari relasi idjenis_koleksi atau kolom jenis.
     */
    public function getJenisNameAttribute(): string
    {
        if ($this->collectionTypeRelation && !empty($this->collectionTypeRelation->jenis_koleksi)) {
            $name = trim($this->collectionTypeRelation->jenis_koleksi);
            if (strtolower($name) !== 'belum diset') {
                return $name;
            }
        }

        $raw = trim($this->attributes['jenis'] ?? '');
        if (!empty($raw)) {
            return $raw;
        }

        return 'Buku';
    }

    /**
     * Mendapatkan class Tailwind CSS untuk warna badge jenis koleksi.
     */
    public function getJenisBadgeColorAttribute(): string
    {
        $jenis = strtolower(trim($this->jenis_name));

        return match (true) {
            str_contains($jenis, 'tesis') => 'bg-blue-600 text-white',
            str_contains($jenis, 'skripsi') => 'bg-purple-600 text-white',
            str_contains($jenis, 'disertasi') => 'bg-amber-500 text-white',
            str_contains($jenis, 'jurnal') => 'bg-orange-500 text-white',
            str_contains($jenis, 'laporan') => 'bg-emerald-600 text-white',
            str_contains($jenis, 'referensi') => 'bg-indigo-600 text-white',
            str_contains($jenis, 'makalah') => 'bg-cyan-600 text-white',
            str_contains($jenis, 'karya') => 'bg-teal-600 text-white',
            str_contains($jenis, 'panduan') => 'bg-fuchsia-600 text-white',
            str_contains($jenis, 'diktat') => 'bg-rose-600 text-white',
            str_contains($jenis, 'orasi') || str_contains($jenis, 'pidato') => 'bg-sky-600 text-white',
            str_contains($jenis, 'e-book') => 'bg-sky-500 text-white',
            str_contains($jenis, 'buku') => 'bg-[#ef4444] text-white',
            default => 'bg-slate-700 text-white',
        };
    }

    /**
     * Mendapatkan label jenis yang diformat dengan baik.
     */
    public function getJenisLabelAttribute(): string
    {
        return strtoupper(__($this->jenis_name));
    }
}
