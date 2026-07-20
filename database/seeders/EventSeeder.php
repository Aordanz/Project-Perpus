<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Lomba Karya Tulis Ilmiah Nasional (LKTIN) USU 2026',
                'description' => 'Perpustakaan Universitas Sumatera Utara mempersembahkan Lomba Karya Tulis Ilmiah Nasional (LKTIN) 2026 dengan tema "Inovasi Digital dan Akselerasi Literasi Menuju Indonesia Emas". Terbuka untuk seluruh mahasiswa aktif diploma dan sarjana di Indonesia. Segera daftarkan tim terbaikmu dan menangkan total hadiah belasan juta rupiah, trofi penghargaan, dan e-sertifikat nasional!',
                'image_path' => 'events/lktin_banner.png',
                'link_url' => 'https://library.usu.ac.id/event/lktin-2026',
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]
        );
    }
}
