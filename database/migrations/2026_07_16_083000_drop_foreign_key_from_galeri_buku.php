<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galeri_buku', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign('book_images_book_id_foreign');
        });
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
