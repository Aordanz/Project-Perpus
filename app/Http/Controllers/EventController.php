<?php

namespace App\Http\Controllers;

use App\Models\InformationCenter;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Get active events/competitions.
     */
    public function getActiveEvent(): JsonResponse
    {
        // Ambil data event aktif ATAU informasi apapun yang ditandai untuk Tampil di Popup
        $events = InformationCenter::where('status', 'published')
            ->where('publish_start_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            })
            ->where(function ($query) {
                $query->where('category', 'event')
                    ->orWhere('show_popup', true);
            })
            ->orderBy('sort_order', 'asc')
            ->latest('created_at')
            ->get();

        $formattedEvents = $events->map(function ($event) {
            $contentDecoded = json_decode($event->content, true);
            $isJson = is_array($contentDecoded) && isset($contentDecoded['is_custom_event']);
            
            // Bersihkan tag HTML untuk deskripsi slider
            $descriptionRaw = $isJson ? ($contentDecoded['description'] ?? '') : $event->content;
            $cleanDescription = strip_tags($descriptionRaw);
            if (empty($cleanDescription)) {
                $cleanDescription = $event->summary;
            }
            // Batasi panjang deskripsi agar pas di slider
            if (strlen($cleanDescription) > 250) {
                $cleanDescription = substr($cleanDescription, 0, 247) . '...';
            }

            // Ambil link utama untuk fallback input lama
            $actionButtons = $event->action_button_url; // array
            $primaryLink = 'https://library.usu.ac.id/id';
            if (is_array($actionButtons) && count($actionButtons) > 0) {
                $primaryLink = $actionButtons[0]['url'] ?? $primaryLink;
            }

            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $cleanDescription,
                'image_url' => $event->image_path ? asset($event->image_path) : asset('perpustakaan_samping.webp'),
                'link_url' => $primaryLink,
                'instagram_url' => 'https://www.instagram.com/usu.library/',
                'library_url' => $primaryLink,
                'action_buttons' => $event->action_button_url, // Kirimkan array tombol aksi secara utuh ke frontend
                'start_date' => $event->publish_start_at ? $event->publish_start_at->toIso8601String() : null,
                'end_date' => $event->publish_end_at ? $event->publish_end_at->toIso8601String() : null,
                'time' => $isJson ? ($contentDecoded['time'] ?? '08.00 - 16.00 WIB') : '08.00 - 16.00 WIB',
                'location' => $isJson ? ($contentDecoded['location'] ?? 'Gedung UPT Perpustakaan USU') : 'Gedung UPT Perpustakaan USU',
                'organizer' => $isJson ? ($contentDecoded['organizer'] ?? 'UPT Perpustakaan Universitas Sumatera Utara') : 'UPT Perpustakaan Universitas Sumatera Utara',
                'participants' => $isJson ? ($contentDecoded['participants'] ?? 'Civitas Akademika USU & Umum') : 'Civitas Akademika USU & Umum',
                'facilities' => $isJson ? ($contentDecoded['facilities'] ?? 'Ilmu Bermanfaat, E-Sertifikat') : 'Ilmu Bermanfaat, E-Sertifikat',
                'contact_whatsapp' => $event->contact_phone ?? '0812-3456-7890',
                'contact_whatsapp_name' => $event->contact_name ?? 'Humas Perpustakaan',
                'contact_email' => $event->contact_email ?? 'library@usu.ac.id',
                'contact_email_name' => 'Email Resmi',
                'left_title' => $isJson ? ($contentDecoded['left_title'] ?: $event->title) : $event->title,
                'left_subtitle' => $isJson ? ($contentDecoded['left_subtitle'] ?: ($event->summary ?: substr($cleanDescription, 0, 100))) : ($event->summary ?: substr($cleanDescription, 0, 100)),
                'left_badge' => $isJson ? ($contentDecoded['left_badge'] ?: 'EVENT PERPUSTAKAAN') : 'EVENT PERPUSTAKAAN',
                'left_features' => $isJson && !empty($contentDecoded['left_features']) ? $contentDecoded['left_features'] : ['Materi Praktis', 'Studi Kasus Nyata', 'E-Sertifikat', 'Doorprize Menarik'],
                'quota_tag' => $isJson ? ($contentDecoded['quota_tag'] ?? 'PENDAFTARAN DIBUKA!<br>Jangan sampai ketinggalan!') : 'PENDAFTARAN DIBUKA!<br>Jangan sampai ketinggalan!',
                'date_text' => $event->publish_start_at ? $event->publish_start_at->translatedFormat('d F Y') : 'Segera Hadir',
            ];
        })->toArray();

        // Jika kosong di database, sebagai fallback kita tampilkan Mendeley Workshop default agar UI tidak kosong
        if (empty($formattedEvents)) {
            $formattedEvents[] = [
                'id' => 98,
                'title' => 'Workshop Mendeley untuk Mahasiswa',
                'description' => 'Pelajari cara mengelola referensi, membuat sitasi otomatis, dan menyusun daftar pustaka dengan mudah menggunakan Mendeley Desktop.',
                'image_url' => asset('events/mendeley_laptop.png'),
                'link_url' => 'https://library.usu.ac.id/event/mendeley-workshop',
                'instagram_url' => 'https://www.instagram.com/p/C8kL4tQSSqK/',
                'library_url' => 'https://library.usu.ac.id/id',
                'action_buttons' => [
                    ['name' => 'Postingan Instagram', 'url' => 'https://www.instagram.com/p/C8kL4tQSSqK/', 'new_tab' => true],
                    ['name' => 'Link Library USU', 'url' => 'https://library.usu.ac.id/id', 'new_tab' => true],
                ],
                'start_date' => now()->subDays(1)->toIso8601String(),
                'end_date' => now()->addDays(15)->toIso8601String(),
                'date_text' => now()->translatedFormat('d F Y'),
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
                'left_subtitle' => 'Tingkatkan kualitas penulisan ilmiahmu dengan manajemen referensi yang lebih efektif dan profesional.',
                'left_badge' => 'EVENT PERPUSTAKAAN',
                'left_features' => ['Materi Praktis', 'Studi Kasus Nyata', 'E-Sertifikat Untuk Peserta', 'Doorprize Menarik'],
                'quota_tag' => 'KUOTA TERBATAS!<br>Daftar sekarang sebelum penuh!',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedEvents
        ]);
    }
}
