<?php

namespace App\Http\Controllers;

use App\Models\InformationCenter;
use Illuminate\Http\Request;

class UserInformationController extends Controller
{
    /**
     * Display the User Information Center page (MLBB Festival Style).
     */
    public function index(Request $request)
    {
        // Ambil data informasi yang aktif dan dipublikasikan (terbaru di paling atas)
        $rawInfos = InformationCenter::where('status', 'published')
            ->where('publish_start_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            })
            ->orderBy('id', 'desc')
            ->get();

        // Standard 5 Categories definition
        $categoryConfigs = [
            'announcement' => [
                'key' => 'announcement',
                'title' => 'Pengumuman',
                'subtitle' => 'Pemberitahuan Resmi',
                'icon' => 'ph-megaphone-simple',
                'color' => 'blue',
                'bg_badge' => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
                'active_border' => 'border-blue-500',
                'glow_color' => 'rgba(59, 130, 246, 0.35)',
            ],
            'event' => [
                'key' => 'event',
                'title' => 'Event',
                'subtitle' => 'Kegiatan & Workshop',
                'icon' => 'ph-calendar-check',
                'color' => 'green',
                'bg_badge' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                'active_border' => 'border-emerald-500',
                'glow_color' => 'rgba(16, 108, 56, 0.4)',
            ],
            'book_recommendation' => [
                'key' => 'book_recommendation',
                'title' => 'Buku Rekomendasi',
                'subtitle' => 'Pilihan Terbaik',
                'icon' => 'ph-star',
                'color' => 'gold',
                'bg_badge' => 'bg-amber-500/10 text-amber-300 border-amber-500/30',
                'active_border' => 'border-amber-400',
                'glow_color' => 'rgba(245, 158, 11, 0.4)',
            ],
            'library_news' => [
                'key' => 'library_news',
                'title' => 'Berita Perpustakaan',
                'subtitle' => 'Info & Kabar Terkini',
                'icon' => 'ph-newspaper',
                'color' => 'indigo',
                'bg_badge' => 'bg-indigo-500/10 text-indigo-300 border-indigo-500/30',
                'active_border' => 'border-indigo-500',
                'glow_color' => 'rgba(99, 102, 241, 0.4)',
            ],
            'tips' => [
                'key' => 'tips',
                'title' => 'Tips & Trick',
                'subtitle' => 'Panduan Bermanfaat',
                'icon' => 'ph-lightbulb-filament',
                'color' => 'orange',
                'bg_badge' => 'bg-orange-500/10 text-orange-400 border-orange-500/30',
                'active_border' => 'border-orange-500',
                'glow_color' => 'rgba(249, 115, 22, 0.4)',
            ],
        ];

        // Helper untuk ekstrak teks deskripsi jika tersimpan JSON
        $unwrapText = function ($raw) use (&$unwrapText) {
            if (empty($raw)) return '';
            if (is_string($raw) && (str_starts_with(trim($raw), '{') || str_starts_with(trim($raw), '['))) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    if (!empty($decoded['description'])) {
                        return $unwrapText($decoded['description']);
                    }
                    return ''; // Returns empty string instead of raw JSON if description is null
                }
            }
            return is_string($raw) ? $raw : '';
        };

        // Fallback images array
        $fallbackImages = [
            'perpustakaan_depan.webp',
            'kolam_perpustakaan.webp',
            'perpustakaan_samping.webp',
            'lokasi/perpustakaan.webp',
        ];

        $resolveImageUrl = function ($path, $id) use ($fallbackImages) {
            if (!empty($path)) {
                if (str_starts_with($path, 'http')) {
                    return $path;
                }
                $cleanPath = ltrim($path, '/');
                if (file_exists(public_path($cleanPath))) {
                    return asset($cleanPath);
                }
            }
            $fallbackIndex = ($id ?? 0) % count($fallbackImages);
            return asset($fallbackImages[$fallbackIndex]);
        };

        // Map and format active items
        $formattedItems = $rawInfos->map(function ($item) use ($unwrapText, $resolveImageUrl, $fallbackImages) {
            $contentDecoded = json_decode($item->content, true);
            $isJson = is_array($contentDecoded);

            $descriptionRaw = $unwrapText($item->content);
            if (empty($descriptionRaw) && $isJson && array_key_exists('description', $contentDecoded)) {
                $descriptionRaw = $unwrapText($contentDecoded['description']);
            }
            $cleanDescription = trim(strip_tags($descriptionRaw));
            // NOTE: Do NOT set a fallback description here.
            // Poster items (image_only) intentionally have no description.

            // Parse tips bullets
            $tipsBullets = [];
            if ($item->category === 'tips') {
                $rawLines = preg_split('/\n|<br\s*\/?>|<\/li>|<\/p>/i', $descriptionRaw);
                foreach ($rawLines as $line) {
                    $cleaned = trim(strip_tags($line));
                    if (strlen($cleaned) > 5) {
                        $tipsBullets[] = $cleaned;
                    }
                }
                if (empty($tipsBullets) && !empty($cleanDescription)) {
                    $parts = preg_split('/[.;]\s+/', $cleanDescription);
                    foreach ($parts as $part) {
                        $p = trim($part);
                        if (strlen($p) > 8) $tipsBullets[] = $p;
                    }
                }
            }

            // Map category key to standard ones
            $categoryKey = $item->category;
            if (in_array($categoryKey, ['new_collection'])) {
                $categoryKey = 'book_recommendation';
            } elseif (in_array($categoryKey, ['maintenance', 'general'])) {
                $categoryKey = 'announcement';
            } elseif (in_array($categoryKey, ['promotion'])) {
                $categoryKey = 'event';
            }

            if (!in_array($categoryKey, ['announcement', 'event', 'book_recommendation', 'library_news', 'tips'])) {
                $categoryKey = 'announcement';
            }

            // Images gallery
            $imagesList = [];
            if (is_array($item->images) && count($item->images) > 0) {
                foreach ($item->images as $img) {
                    $imagesList[] = $resolveImageUrl($img, $item->id);
                }
            } else {
                $imagesList[] = $resolveImageUrl($item->image_path, $item->id);
            }

            $hasCustomImage = false;
            if (!empty($item->image_path)) {
                $cleanPath = ltrim($item->image_path, '/');
                if (str_starts_with($cleanPath, 'http')) {
                    // External URL, always treat as custom image
                    $hasCustomImage = true;
                } elseif (!in_array($cleanPath, $fallbackImages) && file_exists(public_path($cleanPath))) {
                    // Local file that actually exists on disk
                    $hasCustomImage = true;
                }
            }
            if (!$hasCustomImage && is_array($item->images) && count($item->images) > 0) {
                foreach ($item->images as $img) {
                    $cImg = ltrim($img, '/');
                    if (str_starts_with($cImg, 'http')) {
                        $hasCustomImage = true;
                        break;
                    } elseif (!in_array($cImg, $fallbackImages) && file_exists(public_path($cImg))) {
                        $hasCustomImage = true;
                        break;
                    }
                }
            }

            $hasRawDesc = !empty($descriptionRaw) && strlen(trim(strip_tags($descriptionRaw))) > 3;

            $displayMode = 'both';
            if (!$hasCustomImage && $hasRawDesc) {
                $displayMode = 'text_only';
            } elseif ($hasCustomImage && !$hasRawDesc) {
                $displayMode = 'image_only';
            }

            // Primary action button link (Only if provided by admin)
            $actionButtons = $item->action_button_url;
            $primaryLink = null;
            if (is_array($actionButtons) && count($actionButtons) > 0 && !empty($actionButtons[0]['url'])) {
                $primaryLink = $actionButtons[0]['url'];
            }

            // Specific meta fields
            $timeVal      = ($isJson && !empty($contentDecoded['time'])) ? $contentDecoded['time'] : null;
            $locationVal  = ($isJson && !empty($contentDecoded['location'])) ? $contentDecoded['location'] : null;
            $organizerVal = ($isJson && !empty($contentDecoded['organizer'])) ? $contentDecoded['organizer'] : null;
            $hasMeta      = !empty($timeVal) || !empty($locationVal) || !empty($organizerVal);

            return [
                'id' => $item->id,
                'type' => $item->type,
                'title' => $item->title,
                'category' => $categoryKey,
                'raw_category' => $item->category,
                'description' => $cleanDescription,
                'description_html' => $descriptionRaw ?: $cleanDescription,
                'has_custom_image' => $hasCustomImage,
                'has_raw_desc' => $hasRawDesc,
                'has_meta' => $hasMeta,
                'display_mode' => $displayMode,
                'image_url' => $resolveImageUrl($item->image_path, $item->id),
                'images' => $imagesList,
                'image_fit' => $item->image_fit ?? 'cover',
                'image_position' => $item->image_position ?? 'center',
                'image_scale' => $item->image_scale ?? 100,
                'action_buttons' => $actionButtons ?: [],
                'link_url' => $primaryLink,
                'start_date' => $item->publish_start_at ? $item->publish_start_at->translatedFormat('d F Y') : 'Segera Hadir',
                'end_date' => $item->publish_end_at ? $item->publish_end_at->translatedFormat('d F Y') : null,
                'is_featured' => (bool)$item->is_featured,
                
                // Specific fields
                'time' => $timeVal,
                'location' => $locationVal,
                'organizer' => $organizerVal,
                'participants' => ($isJson && !empty($contentDecoded['participants'])) ? $contentDecoded['participants'] : null,
                'facilities' => ($isJson && !empty($contentDecoded['facilities'])) ? $contentDecoded['facilities'] : null,
                'left_features' => ($isJson && is_array($contentDecoded['left_features'] ?? null)) ? $contentDecoded['left_features'] : [],
                'tips_bullets' => $tipsBullets,
                'book_author' => $isJson ? ($contentDecoded['book_author'] ?? null) : null,
                'shelf_location' => $isJson ? ($contentDecoded['shelf_location'] ?? null) : null,
                'contact_phone' => $item->contact_phone ?? null,
                'contact_email' => $item->contact_email ?? null,
            ];
        });

        // Compute counts per category
        $categoryCounts = [];
        foreach ($categoryConfigs as $key => $config) {
            $categoryCounts[$key] = $formattedItems->where('category', $key)->count();
        }

        // Active category selection (from request or first available category with items)
        $selectedCategory = $request->query('category');
        if (!$selectedCategory || !array_key_exists($selectedCategory, $categoryConfigs)) {
            // Pick first category that has items, or fallback to 'announcement'
            $selectedCategory = 'announcement';
            foreach ($categoryConfigs as $key => $conf) {
                if ($categoryCounts[$key] > 0) {
                    $selectedCategory = $key;
                    break;
                }
            }
        }

        // Active item selection (from request query `id` or first item in selected category)
        $selectedId = (int)$request->query('id');

        return view('informasi', [
            'categoryConfigs' => $categoryConfigs,
            'items' => $formattedItems,
            'categoryCounts' => $categoryCounts,
            'selectedCategory' => $selectedCategory,
            'selectedId' => $selectedId,
        ]);
    }
}
