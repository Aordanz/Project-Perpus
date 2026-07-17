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
                'image_url' => $event->image_path ? asset($event->image_path) : asset('kolam_perpustakaan.webp'),
                'link_url' => $event->link_url,
                'start_date' => $event->start_date ? $event->start_date->toIso8601String() : null,
                'end_date' => $event->end_date ? $event->end_date->toIso8601String() : null,
                'time' => '08:00 - 16:00 WIB',
                'location' => 'Gedung UPT Perpustakaan USU, Lantai 1',
                'organizer' => 'UPT Perpustakaan Universitas Sumatera Utara',
                'contact_name' => 'Humas Perpustakaan USU',
                'contact_info' => 'library@usu.ac.id / +62 812-3456-7890',
            ];
        })->toArray();

        // Add a second mock event to demonstrate the carousel/slider functionality
        if (count($formattedEvents) <= 1) {
            $formattedEvents[] = [
                'id' => 99,
                'title' => 'Webinar Nasional: Pemanfaatan AI untuk Riset Akademik',
                'description' => 'Ikuti webinar eksklusif perpustakaan USU bersama pakar AI nasional. Temukan cara cerdas memanfaatkan teknologi kecerdasan buatan untuk riset, penulisan artikel ilmiah, dan analisis data akademik yang kredibel dan etis. Dapatkan e-sertifikat gratis dan doorprize menarik!',
                'image_url' => asset('perpustakaan_samping.webp'),
                'link_url' => 'https://library.usu.ac.id/event/webinar-ai-2026',
                'start_date' => now()->addDays(2)->toIso8601String(),
                'end_date' => now()->addDays(3)->toIso8601String(),
                'time' => '09:00 - 12:00 WIB',
                'location' => 'Daring via Zoom Meeting',
                'organizer' => 'Unit Pelaksana Teknis Perpustakaan USU',
                'contact_name' => 'Kak Sarah (Moderator)',
                'contact_info' => 'sarah.library@usu.ac.id / +62 898-7654-3210',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedEvents
        ]);
    }
}
