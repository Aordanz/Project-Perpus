<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InformationCenter;

class InformationCenterSeeder extends Seeder
{
    public function run(): void
    {
        InformationCenter::create([
            'title' => 'Pengumuman Uji Coba & Operasional Sistem OPAC Terbaru',
            'slug' => 'pengumuman-operasional-sistem-opac',
            'summary' => 'Layanan Perpustakaan USU menghadirkan sistem penelusuran katalog OPAC modern dan terintegrasi.',
            'content' => json_encode([
                'is_custom_announcement' => true,
                'time' => '08:00 - 20:00 WIB',
                'location' => 'Lantai 1, 2, & 3 Perpustakaan USU',
                'description' => 'Dalam rangka meningkatkan kualitas layanan informasi literasi, Perpustakaan Universitas Sumatera Utara resmi meluncurkan pembaruan sistem OPAC. Pemustaka dapat mencari koleksi buku, skripsi, tesis, dan jurnal secara real-time.'
            ]),
            'category' => 'announcement',
            'status' => 'published',
            'show_popup' => true,
            'show_navbar' => true,
            'is_featured' => true,
            'popup_priority' => 1,
            'sort_order' => 1,
            'publish_start_at' => now(),
            'images' => ['perpustakaan_depan.webp'],
            'image_path' => 'perpustakaan_depan.webp',
        ]);

        InformationCenter::create([
            'title' => 'Sosialisasi & Workshop Literasi Digital & Turnitin 2026',
            'slug' => 'workshop-literasi-digital-turnitin-2026',
            'summary' => 'Panduan pengunggahan mandiri karya ilmiah dan prosedur cek kemiripan (similarity check) via Turnitin.',
            'content' => json_encode([
                'is_custom_event' => true,
                'time' => '09:00 - 12:00 WIB',
                'location' => 'Ruang Discussion Room Lantai 3',
                'organizer' => 'UPT Perpustakaan USU',
                'participants' => 'Mahasiswa Akhir (S1, S2, S3)',
                'facilities' => 'Sertifikat, E-Booklet, Konsumsi',
                'left_badge' => 'WORKSHOP',
                'left_title' => 'Cek Plagiarisme & Turnitin',
                'left_subtitle' => 'Pelatihan bebas pustaka & pencegahan plagiarisme karya ilmiah.',
                'quota_tag' => 'Kuota 100 Peserta',
                'left_features' => ["Panduan Turnitin", "Prosedur Bebas Pustaka", "Tanya Jawab Petugas"],
                'description' => 'Ikuti sosialisasi penggunaan Turnitin dan alur bebas pustaka mandiri untuk persiapan sidang tugas akhir dan wisuda.'
            ]),
            'category' => 'event',
            'status' => 'published',
            'show_popup' => false,
            'show_navbar' => true,
            'is_featured' => false,
            'popup_priority' => 2,
            'sort_order' => 2,
            'publish_start_at' => now(),
            'images' => ['perpustakaan_depan.webp'],
            'image_path' => 'perpustakaan_depan.webp',
        ]);

        InformationCenter::create([
            'title' => 'Rekomendasi Buku: Sistem Informasi Manajemen Digital',
            'slug' => 'rekomendasi-buku-sistem-informasi-manajemen',
            'summary' => 'Koleksi buku terpilih bidang Manajemen Teknologi dan Digitalisasi Sistem Informasi.',
            'content' => json_encode([
                'is_custom_collection' => true,
                'book_title' => 'Sistem Informasi Manajemen: Mengelola Perusahaan Digital',
                'book_author' => 'Kenneth C. Laudon',
                'book_publisher' => 'Salemba Empat',
                'shelf_location' => 'Lantai 2 - Rak 658.4',
                'description' => 'Buku ini membahas konsep dasar sistem informasi modern, integrasi cloud computing, keamanan siber, dan analisis data dalam organisasi bisnis.'
            ]),
            'category' => 'book_recommendation',
            'status' => 'published',
            'show_popup' => false,
            'show_navbar' => false,
            'is_featured' => false,
            'popup_priority' => 3,
            'sort_order' => 3,
            'publish_start_at' => now(),
            'images' => ['perpustakaan_depan.webp'],
            'image_path' => 'perpustakaan_depan.webp',
        ]);
    }
}
