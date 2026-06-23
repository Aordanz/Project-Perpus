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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('subject')->nullable();
            $table->integer('publish_year')->nullable();
            $table->string('isbn')->nullable();
            $table->string('classification')->nullable();
            $table->string('category')->nullable();
            $table->string('language')->default('Indonesia');
            $table->string('physical_description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('type')->default('buku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
