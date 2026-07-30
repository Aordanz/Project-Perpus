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
        Schema::create('book_images', function (Blueprint $table) {
            $table->id();
            // Tidak menggunakan foreignId->constrained() karena tabel books (tblbuku)
            // ada di database OPAC utama, bukan di opac_katalog.
            // Gunakan unsignedBigInteger biasa untuk menyimpan referensi cross-database.
            $table->unsignedBigInteger('book_id')->index();
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_images');
    }
};
