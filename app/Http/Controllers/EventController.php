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
        // Ambil data informasi yang ditandai oleh admin untuk Tampil di Popup
        $events = InformationCenter::where('status', 'published')
            ->where('publish_start_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            })
            ->where('show_popup', true)
            ->orderBy('sort_order', 'asc')
            ->latest('publish_start_at')
            ->get();

        $formattedEvents = $events->map(function ($event) {
            $contentDecoded = json_decode($event->content, true);
            $isJson = is_array($contentDecoded);
            
            // Helper untuk mengekstrak deskripsi jika tersimpan sebagai JSON bertingkat
            $unwrapText = function ($raw) use (&$unwrapText) {
                if (empty($raw)) return '';
                if (is_string($raw) && (str_starts_with(trim($raw), '{') || str_starts_with(trim($raw), '['))) {
                    $decoded = json_decode($raw, true);
                    if (is_array($decoded)) {
                        if (isset($decoded['description'])) {
                            return $unwrapText($decoded['description']);
                        }
                    }
                }
                return is_string($raw) ? $raw : '';
            };

            $descriptionRaw = $unwrapText($event->content);
            if (empty($descriptionRaw) && $isJson && isset($contentDecoded['description'])) {
                $descriptionRaw = $unwrapText($contentDecoded['description']);
            }
            $cleanDescription = trim(strip_tags($descriptionRaw));
            if (empty($cleanDescription)) {
                $cleanDescription = trim(strip_tags($unwrapText($event->summary)));
            }

            // Parse tips menjadi array bullet untuk kategori tips
            $tipsBullets = [];
            if ($event->category === 'tips') {
                $rawLines = preg_split('/\n|<br\s*\/?>|<\/li>|<\/p>/i', $descriptionRaw);
                foreach ($rawLines as $line) {
                    $cleaned = trim(strip_tags($line));
                    if (strlen($cleaned) > 5) {
                        $tipsBullets[] = $cleaned;
                    }
                }
                if (empty($tipsBullets) && !empty($cleanDescription)) {
                    // Fallback: split by period or semicolon
                    $parts = preg_split('/[.;]\s+/', $cleanDescription);
                    foreach ($parts as $part) {
                        $p = trim($part);
                        if (strlen($p) > 8) $tipsBullets[] = $p;
                    }
                }
            }

            // Ambil link utama untuk fallback input lama
            $actionButtons = $event->action_button_url; // array
            $primaryLink = 'https://library.usu.ac.id/id';
            if (is_array($actionButtons) && count($actionButtons) > 0) {
                $primaryLink = $actionButtons[0]['url'] ?? $primaryLink;
            }

            // Robust image URL resolution with dynamic fallback images per event ID
            $fallbackImages = [
                'perpustakaan_depan.webp',
                'kolam_perpustakaan.webp',
                'perpustakaan_samping.webp',
                'slider1.jpg',
                'slider2.jpg',
            ];

            $resolveImageUrl = function ($path) use ($event, $fallbackImages) {
                if (!empty($path)) {
                    if (str_starts_with($path, 'http')) {
                        return $path;
                    }
                    $cleanPath = ltrim($path, '/');
                    if (file_exists(public_path($cleanPath))) {
                        return asset($cleanPath);
                    }
                }
                $fallbackIndex = ($event->id ?? 0) % count($fallbackImages);
                return asset($fallbackImages[$fallbackIndex]);
            };

            return [
                'id' => $event->id,
                'title' => $event->title,
                'category' => $event->category,
                'description' => $cleanDescription,
                'image_url' => $resolveImageUrl($event->image_path),
                'image_fit' => $event->image_fit ?? 'cover',
                'image_position' => $event->image_position ?? 'center',
                'image_scale' => $event->image_scale ?? 100,
                'image_x' => $event->image_x ?? 50,
                'image_y' => $event->image_y ?? 50,
                'images_url' => is_array($event->images) && count($event->images) > 0 
                    ? array_map(fn($img) => $resolveImageUrl($img), $event->images) 
                    : [$resolveImageUrl($event->image_path)],
                'link_url' => $primaryLink,
                'instagram_url' => 'https://www.instagram.com/usu.library/',
                'library_url' => $primaryLink,
                'action_buttons' => $event->action_button_url, // Kirimkan array tombol aksi secara utuh ke frontend
                'start_date' => $event->publish_start_at ? $event->publish_start_at->toIso8601String() : null,
                'end_date' => $event->publish_end_at ? $event->publish_end_at->toIso8601String() : null,
                
                // Fields Kategori Event
                'time' => $isJson ? ($contentDecoded['time'] ?? '08.00 - 16.00 WIB') : '08.00 - 16.00 WIB',
                'location' => $isJson ? ($contentDecoded['location'] ?? 'Gedung UPT Perpustakaan USU') : 'Gedung UPT Perpustakaan USU',
                'organizer' => $isJson ? ($contentDecoded['organizer'] ?? 'UPT Perpustakaan Universitas Sumatera Utara') : 'UPT Perpustakaan Universitas Sumatera Utara',
                'participants' => $isJson ? ($contentDecoded['participants'] ?? 'Civitas Akademika USU & Umum') : 'Civitas Akademika USU & Umum',
                'facilities' => $isJson ? ($contentDecoded['facilities'] ?? 'Ilmu Bermanfaat, E-Sertifikat') : 'Ilmu Bermanfaat, E-Sertifikat',
                'left_features' => ($isJson && is_array($contentDecoded['left_features'] ?? null)) ? $contentDecoded['left_features'] : [],
                
                // Fields Kategori Maintenance
                'affected_services' => $isJson ? ($contentDecoded['affected_services'] ?? null) : null,
                'estimated_downtime' => $isJson ? ($contentDecoded['estimated_downtime'] ?? null) : null,
                'alternative_link' => $isJson ? ($contentDecoded['alternative_link'] ?? null) : null,
                
                // Fields Kategori Koleksi Baru
                'book_title' => $isJson ? ($contentDecoded['book_title'] ?? null) : null,
                'book_author' => $isJson ? ($contentDecoded['book_author'] ?? null) : null,
                'book_publisher' => $isJson ? ($contentDecoded['book_publisher'] ?? null) : null,
                'shelf_location' => $isJson ? ($contentDecoded['shelf_location'] ?? null) : null,
                
                // Fields Kategori Tips
                'tips_bullets' => $tipsBullets,
                
                // Fields Kategori Promo
                'promo_period' => $isJson ? ($contentDecoded['promo_period'] ?? null) : null,
                'promo_benefit' => $isJson ? ($contentDecoded['promo_benefit'] ?? null) : null,
                
                // Fields Kategori Berita Perpustakaan
                'news_date' => $isJson ? ($contentDecoded['date'] ?? null) : null,
                
                'contact_whatsapp' => $event->contact_phone ?? '0812-3456-7890',
                'contact_whatsapp_name' => $event->contact_name ?? 'Humas Perpustakaan',
                'contact_email' => $event->contact_email ?? 'library@usu.ac.id',
                'contact_email_name' => 'Email Resmi',
                
                'date_text' => $event->publish_start_at ? $event->publish_start_at->translatedFormat('d F Y') : 'Segera Hadir',
            ];
        })->toArray();

        // Jika kosong di database, biarkan array tetap kosong
        if (empty($formattedEvents)) {
            $formattedEvents = [];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedEvents
        ]);
    }
}
