<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $mappings = [
            // Invalid categories (Buku, Laporan Penelitian, Tesis) to valid categories
            210 => 'Komputer & Informatika',
            211 => 'Teknik',
            212 => 'Kesehatan & Kedokteran',
            213 => 'Sastra & Bahasa',
            214 => 'Hukum',
            215 => 'Kesehatan & Kedokteran',
            216 => 'Kesehatan & Kedokteran',
            217 => 'Sosial & Humaniora',
            218 => 'Kesehatan & Kedokteran',
            219 => 'Komputer & Informatika',
            220 => 'Komputer & Informatika',
            221 => 'Kesehatan & Kedokteran',
            222 => 'Kesehatan & Kedokteran',
            223 => 'Teknik',
            224 => 'Ekonomi & Bisnis',
            225 => 'Kesehatan & Kedokteran',
            226 => 'Hukum',
            227 => 'Agama',
            228 => 'Kesehatan & Kedokteran',
            229 => 'Sosial & Humaniora',

            // Specific updates for 'Umum' categories to be more descriptive
            16  => 'Kesehatan & Kedokteran',
            26  => 'Komputer & Informatika',
            84  => 'Komputer & Informatika',
            91  => 'Komputer & Informatika',
            119 => 'Pertanian & Kehutanan',
            132 => 'Komputer & Informatika',
            149 => 'Matematika & IPA',
            154 => 'Ekonomi & Bisnis',
        ];

        foreach ($mappings as $id => $category) {
            DB::table('books')->where('id', $id)->update(['category' => $category]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed
    }
};
