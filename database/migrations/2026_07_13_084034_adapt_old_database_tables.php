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
        Schema::table('tblbuku', function (Blueprint $table) {
            // Add columns that exist in new DB but not in old DB
            if (!Schema::hasColumn('tblbuku', 'cover_image')) {
                $table->string('cover_image')->nullable();
            }
            if (!Schema::hasColumn('tblbuku', 'pdf_file')) {
                $table->string('pdf_file')->nullable();
            }
            if (!Schema::hasColumn('tblbuku', 'category')) {
                $table->string('category')->default('Umum');
            }
            if (!Schema::hasColumn('tblbuku', 'jenis')) {
                $table->string('jenis')->default('buku');
            }
            if (!Schema::hasColumn('tblbuku', 'golongan')) {
                $table->string('golongan')->nullable();
            }
            if (!Schema::hasColumn('tblbuku', 'publication_city')) {
                $table->string('publication_city')->nullable();
            }
        });

        Schema::table('tbleksemplar', function (Blueprint $table) {
            // Add missing item columns
            if (!Schema::hasColumn('tbleksemplar', 'status')) {
                $table->string('status')->default('Tersedia');
            }
            if (!Schema::hasColumn('tbleksemplar', 'type')) {
                $table->string('type')->default('STD');
            }
        });
        
        Schema::table('tbllokasi', function (Blueprint $table) {
            // Add missing location columns
            if (!Schema::hasColumn('tbllokasi', 'icon')) {
                $table->string('icon')->default('ph-map-pin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tblbuku', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'pdf_file', 'category', 'jenis', 'golongan', 'publication_city']);
        });

        Schema::table('tbleksemplar', function (Blueprint $table) {
            $table->dropColumn(['status', 'type']);
        });
        
        Schema::table('tbllokasi', function (Blueprint $table) {
            $table->dropColumn(['icon']);
        });
    }
};
