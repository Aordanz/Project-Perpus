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
        // Foreign key sudah tidak ada karena book_images dibuat tanpa FK cross-database.
        // Migration ini dibiarkan kosong agar urutan migration tetap terjaga.
        // Schema::table('galeri_buku', function (Blueprint $table) {
        //     $table->dropForeign('book_images_book_id_foreign');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeri_buku', function (Blueprint $table) {
            // Restore foreign key constraint pointing to books table
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
};
