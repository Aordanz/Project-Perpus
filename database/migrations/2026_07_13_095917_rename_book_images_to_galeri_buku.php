<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Tabel ini masuk ke database opac_katalog, bukan database OPAC utama. */
    protected $connection = 'opac_katalog';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('book_images', 'galeri_buku');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('galeri_buku', 'book_images');
    }
};
