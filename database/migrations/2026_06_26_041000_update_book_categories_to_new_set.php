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
        // Map titles to new categories
        $mappings = [
            'Orang-orang yang disayangi Allah' => 'Agama',
            'Elements of chemical reaction engineering. 7th Ed.' => 'Teknik',
            'Membangun jembatan menuju kemandirian penyandang disabilitas' => 'Sosial & Humaniora',
            'Pengantar Ilmu Hukum dan Tata Hukum Indonesia' => 'Hukum',
            'Sistem Informasi Manajemen: Mengelola Perusahaan Digital' => 'Komputer & Informatika',
            'Metode Penelitian Hukum: Normatif dan Empiris' => 'Hukum',
            'Kalkulus Purcell Edisi 9 Jilid 1' => 'Matematika & IPA',
            'Prinsip-Prinsip Biokimia (Lehninger Principles of Biochemistry)' => 'Sains & Teknologi',
            'Pengantar Teknologi Informasi Modern' => 'Komputer & Informatika',
            'Struktur Data dan Algoritma dengan Python' => 'Komputer & Informatika',
            'Patologi Sosial 1: Masalah Sosial dan Penyimpangan' => 'Sastra & Bahasa',
            'Makroekonomi Teori Pengantar Edisi Ketiga' => 'Ekonomi & Bisnis',
            'Buku Ajar Fisiologi Kedokteran Guyton and Hall' => 'Kesehatan & Kedokteran',
            'Asuhan Keperawatan Jiwa dengan Pendekatan Klinis' => 'Kesehatan & Kedokteran',
            'Ilmu Kesehatan Masyarakat: Teori dan Aplikasi' => 'Seni & Desain',
            'Farmakologi Dasar dan Klinik Edisi 14' => 'Umum',
            'Dasar-Dasar Kehutanan Tropis' => 'Pertanian & Kehutanan',
            'Koleksi Emas Parada Harahap: Sejarah Pers Sumatera' => 'Sejarah & Geografi',
            'Pertanian Berkelanjutan di Lahan Kering Tropis' => 'Pertanian & Kehutanan',
            'Konservasi Gigi Terpadu: Teori dan Aplikasi Praktis' => 'Kesehatan & Kedokteran',
        ];

        foreach ($mappings as $title => $category) {
            DB::table('books')->where('title', $title)->update(['category' => $category]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed as this is a one-time data correction
    }
};
