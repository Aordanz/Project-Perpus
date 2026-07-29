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
        Schema::create('chat_caches', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan_hash')->index();
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_caches');
    }
};
