<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Get active events/competitions.
     */
    public function getActiveEvent(): JsonResponse
    {
        $events = Event::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->latest('id')
            ->get();

        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'image_url' => $event->image_path ? asset($event->image_path) : asset('events/lktin_banner.png'),
                'link_url' => $event->link_url ?? 'https://library.usu.ac.id/event/lktin-2026',
                'instagram_url' => 'https://www.instagram.com/usu.library/',
                'library_url' => $event->link_url ?? 'https://library.usu.ac.id/event/lktin-2026',
                'start_date' => $event->start_date ? $event->start_date->toIso8601String() : null,
                'end_date' => $event->end_date ? $event->end_date->toIso8601String() : null,
                'time' => '08.00 - 16.00 WIB',
                'location' => 'Gedung UPT Perpustakaan USU, Lantai 1',
                'organizer' => 'UPT Perpustakaan Universitas Sumatera Utara',
                'participants' => 'Seluruh Mahasiswa Indonesia',
                'facilities' => 'Hadiah Jutaan, Trofi, E-Sertifikat',
                'contact_whatsapp' => '0812-3456-7890',
                'contact_whatsapp_name' => 'Humas Perpustakaan',
                'contact_email' => 'library@usu.ac.id',
                'contact_email_name' => 'Email Resmi',
                'left_title' => 'LOMBA KARYA TULIS ILMIAH NASIONAL (LKTIN) USU 2026',
                'left_subtitle' => 'Tema: Inovasi Digital dan Akselerasi Literasi Menuju Indonesia Emas.',
                'left_badge' => 'LOMBA NASIONAL',
                'left_features' => ['Trofi Bergengsi', 'Hadiah Uang Tunai', 'E-Sertifikat Nasional', 'Relasi Mahasiswa'],
                'quota_tag' => 'PENDAFTARAN DIBUKA!<br>Tunjukkan karya terbaikmu!',
            ];
        })->toArray();

        // 1. Mendeley Workshop (Slide 1)
        $mendeleyEvent = [
            'id' => 98,
            'title' => 'Workshop Mendeley untuk Mahasiswa',
            'description' => 'Pelajari cara mengelola referensi, membuat sitasi otomatis, dan menyusun daftar pustaka dengan mudah menggunakan Mendeley Desktop.',
            'image_url' => asset('events/mendeley_laptop.png'),
            'link_url' => 'https://library.usu.ac.id/event/mendeley-workshop',
            'instagram_url' => 'https://www.instagram.com/p/C8kL4tQSSqK/',
            'library_url' => 'https://library.usu.ac.id/id',
            'start_date' => now()->subDays(1)->toIso8601String(),
            'end_date' => now()->addDays(15)->toIso8601String(),
            'time' => '09.00 - 12.00 WIB',
            'location' => 'Ruang Seminar Perpustakaan USU',
            'organizer' => 'Perpustakaan USU',
            'participants' => 'Mahasiswa Aktif USU',
            'facilities' => 'Materi, E-Sertifikat, Doorprize',
            'contact_whatsapp' => '0812-3456-7890',
            'contact_whatsapp_name' => 'Admin Perpustakaan',
            'contact_email' => 'library@usu.ac.id',
            'contact_email_name' => 'Email Resmi',
            'left_title' => 'WORKSHOP MENDELEY UNTUK MAHASISWA',
            'left_subtitle' => 'Tingkatkan kualitas penulisan ilmiahmu dengan manajemen referensi yang lebih efektif and profesional.',
            'left_badge' => 'EVENT PERPUSTAKAAN',
            'left_features' => ['Materi Praktis', 'Studi Kasus Nyata', 'E-Sertifikat Untuk Peserta', 'Doorprize Menarik'],
            'quota_tag' => 'KUOTA TERBATAS!<br>Daftar sekarang sebelum penuh!',
        ];

        // 2. Webinar AI (Slide 3)
        $aiEvent = [
            'id' => 99,
            'title' => 'Webinar Nasional: Pemanfaatan AI untuk Riset Akademik',
            'description' => 'Ikuti webinar eksklusif perpustakaan USU bersama pakar AI nasional. Temukan cara cerdas memanfaatkan teknologi kecerdasan buatan untuk riset, penulisan artikel ilmiah, dan analisis data akademik yang kredibel dan etis. Dapatkan e-sertifikat gratis dan doorprize menarik!',
            'image_url' => asset('perpustakaan_samping.webp'),
            'link_url' => 'https://library.usu.ac.id/event/webinar-ai-2026',
            'instagram_url' => 'https://www.instagram.com/usu.library/',
            'library_url' => 'https://library.usu.ac.id/id/jurnal-elektronik',
            'start_date' => now()->addDays(2)->toIso8601String(),
            'end_date' => now()->addDays(3)->toIso8601String(),
            'time' => '09.00 - 12.00 WIB',
            'location' => 'Daring via Zoom Meeting',
            'organizer' => 'Unit Pelaksana Teknis Perpustakaan USU',
            'participants' => 'Umum / Civitas Akademika',
            'facilities' => 'Materi PDF, E-Sertifikat, Doorprize',
            'contact_whatsapp' => '0898-7654-3210',
            'contact_whatsapp_name' => 'Kak Sarah (Moderator)',
            'contact_email' => 'sarah.library@usu.ac.id',
            'contact_email_name' => 'Email Resmi',
            'left_title' => 'WEBINAR NASIONAL: AI UNTUK RISET AKADEMIK',
            'left_subtitle' => 'Temukan cara cerdas memanfaatkan teknologi kecerdasan buatan untuk riset yang kredibel dan etis.',
            'left_badge' => 'WEBINAR GRATIS',
            'left_features' => ['Ilmu Bermanfaat', 'Tips Riset Cerdas', 'E-Sertifikat Gratis', 'Doorprize Menarik'],
            'quota_tag' => 'TERBANYAK!<br>Terbuka untuk Umum!',
        ];

        // Combine events: Mendeley (Slide 1), then DB events (LKTIN), then AI Webinar
        $finalEvents = array_merge([$mendeleyEvent], $formattedEvents, [$aiEvent]);

        return response()->json([
            'success' => true,
            'data' => $finalEvents
        ]);
    }
}
