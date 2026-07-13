# Dokumentasi Migrasi & Penyesuaian Database OPAC

Dokumen ini merangkum semua langkah, query, dan modifikasi kode yang telah dilakukan untuk menyelaraskan aplikasi OPAC berbasis Laravel yang baru agar beroperasi menggunakan database lawas (`perpustakaan_usu`), tanpa merusak struktur database lama.

## 1. Konfigurasi Awal (Environment)

Aplikasi diinstruksikan untuk menggunakan server Linux milik pengguna dengan database lama:
- **File diubah:** `.env`
- **Tindakan:** Mengubah `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, dan `DB_DATABASE` (dari `opac` ke `perpustakaan_usu`).

---

## 2. Modifikasi Struktur Database (Migration)

Agar fitur OPAC yang baru (seperti gambar cover, jenis koleksi, file PDF) dapat bekerja, kolom tambahan disuntikkan ke dalam tabel lawas. 

**Perintah yang dieksekusi:** `php artisan migrate` 
*(File: `2026_07_13_084034_adapt_old_database_tables.php`)*

**Query (Logika yang dijalankan di latar belakang):**
```sql
-- Penambahan ke tabel Buku
ALTER TABLE tblbuku 
ADD cover_image VARCHAR(255) NULL,
ADD pdf_file VARCHAR(255) NULL,
ADD category VARCHAR(255) NULL,
ADD jenis VARCHAR(255) NULL,
ADD golongan VARCHAR(255) NULL;

-- Penambahan ke tabel Eksemplar
ALTER TABLE tbleksemplar 
ADD status VARCHAR(50) DEFAULT 'Tersedia',
ADD type VARCHAR(50) DEFAULT 'Buku';

-- Penambahan ke tabel Lokasi
ALTER TABLE tbllokasi 
ADD icon VARCHAR(255) NULL;
```
*(Catatan: Proses ini tidak menghapus/mengubah satu pun kolom asli yang sudah ada di database).*

---

## 3. Penyelarasan Model Eloquent (Accessor, Mutator & Primary Key)

Berhubung sistem baru memanggil atribut berbahasa Inggris (seperti `title`), sedangkan database lama menggunakan bahasa Indonesia (seperti `judul_buku`), kita menggunakan fitur *Accessor* di Laravel sebagai "Jembatan Penerjemah".

### A. Model `Book.php`
- **Tabel:** `tblbuku`
- **Primary Key:** diubah menjadi `idbuku` (bukan default `id`)
- **Penyesuaian Atribut (Jembatan Data):**
  - `$book->id` $\rightarrow$ `idbuku`
  - `$book->title` $\rightarrow$ `judul_buku`
  - `$book->author` $\rightarrow$ `pengarang`
  - `$book->publisher` $\rightarrow$ `idpenerbit`
  - `$book->subject` $\rightarrow$ `subjek`
  - `$book->publish_year` $\rightarrow$ `tahun`
  - `$book->classification` $\rightarrow$ `noklasifikasi`
  - `$book->call_number` $\rightarrow$ `nopanggil`
  - `$book->physical_description` $\rightarrow$ `deskripsi`
  - `$book->general_note` $\rightarrow$ `catatan_umum`
  - `$book->edition` $\rightarrow$ `edisi`
  - `$book->language` $\rightarrow$ `idbahasa`
  - `$book->publication_city` $\rightarrow$ `idkota`

### B. Model `Item.php`
- **Tabel:** `tbleksemplar`
- **Primary Key:** diubah menjadi `nomor_eksemplar` (bukan default `id`)
- **Penyesuaian Atribut:**
  - `$item->id` $\rightarrow$ `ideksemplar`
  - `$item->barcode` $\rightarrow$ `nomor_eksemplar`
  - `$item->book_id` $\rightarrow$ `idmaster`
  - `$item->location_id` $\rightarrow$ `kodelokasi`
  - `$item->call_number` $\rightarrow$ `nopemesanan`

### C. Model `Location.php`
- **Tabel:** `tbllokasi`
- **Primary Key:** diubah menjadi `idlokasi`
- **Penyesuaian Atribut:**
  - `$location->id` $\rightarrow$ `idlokasi`
  - `$location->name` $\rightarrow$ `lokasi`
  - `$location->code` $\rightarrow$ `lokasi` (Kolom Code pada OPAC baru dialiaskan ke nama `lokasi` pada tabel lama).

---

## 4. Penyelarasan Relationship (Relasi Antar Tabel)

Karena tabel dan Primary Key berubah, Eloquent (ORM Laravel) sempat gagal melakukan *Join Table* karena mencoba menyambungkan nama kolom yang tidak ada (misalnya `book_id`). Kami mengubah deklarasi relasi secara eksplisit (paksa):

**Di `Book.php`:**
```php
public function items() {
    // Menyambungkan Item dengan Book lewat 'idmaster' dan 'idbuku'
    return $this->hasMany(Item::class, 'idmaster', 'idbuku');
}
public function images() {
    return $this->hasMany(BookImage::class, 'book_id', 'idbuku');
}
```

**Di `Item.php`:**
```php
public function book() {
    return $this->belongsTo(Book::class, 'idmaster', 'idbuku');
}
public function location() {
    // Menyambungkan Item dengan Lokasi lewat 'kodelokasi' dan 'idlokasi'
    return $this->belongsTo(Location::class, 'kodelokasi', 'idlokasi');
}
```

---

## 5. Modifikasi Query (Controller)

Kode pencarian dan pengolahan data pada OPAC lama melakukan filter pada kolom Inggris (misalnya `where('title')`). Ini disesuaikan menjadi:

**`BookController.php` (Fungsi Pencarian):**
- Diubah: `->where('title', ...)` menjadi `->where('judul_buku', ...)`
- Diubah: `->where('code', $locationCode)` menjadi `->where('lokasi', $locationCode)` (Disesuaikan agar fitur klik Fakultas pada Beranda dapat bekerja).
- Fitur Advanced Search (`applyAdvancedSearch`) dipastikan memanggil parameter array dengan nama kolom tabel yang benar (misalnya `['judul_buku']`, bukan `['title']`).

**`AdminController.php` (Pengolahan Buku dari Panel Admin):**
- Penyesuaian pengecekan eksemplar unik, dari yang tadinya mencari kolom `barcode` menjadi `nomor_eksemplar`.

---

## Ringkasan Eksekusi & Solusi Akhir
Hasil akhir dari semua perubahan di atas adalah aplikasi web bisa **mempertahankan struktur tabel aslinya (`tblbuku` dll)**, tetapi di saat yang bersamaan **kode Frontend/View OPAC tidak perlu diubah secara drastis**. Sistem secara otomatis menjembatani kolom bahasa Inggris (`$book->title`) agar membaca data dari kolom bahasa Indonesia (`judul_buku`). Semua error *Undefined Property* maupun *Missing Parameter* berhasil diselesaikan lewat pemetaan kolom yang tepat ini.
