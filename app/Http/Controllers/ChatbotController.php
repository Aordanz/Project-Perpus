<?php

namespace App\Http\Controllers;

use App\Models\ChatCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->input('message');
        $normalizedMessage = strtolower(trim($userMessage));
        $messageHash = hash('sha256', $normalizedMessage);

        // 1. Optimasi 1: Cek Cache di Database
        $cache = ChatCache::where('pertanyaan_hash', $messageHash)->first();
        if ($cache) {
            return response()->json([
                'jawaban' => $cache->jawaban,
                'source' => 'cache'
            ]);
        }

        // 2. Ambil data referensi perpustakaan
        $referenceData = '';
        if (Storage::disk('local')->exists('private/data_perpus.txt')) {
            $referenceData = Storage::disk('local')->get('private/data_perpus.txt');
        }

        // 3. Konfigurasi Prompt
        $systemPrompt = "Kamu adalah USU Library AI, asisten virtual resmi Perpustakaan USU. Tugasmu HANYA menjawab pertanyaan seputar operasional, aturan, dan fasilitas Perpustakaan USU berdasarkan data referensi teks yang diberikan. Jika pengguna bertanya di luar topik Perpustakaan USU (seperti coding, matematika, game, atau obrolan umum), kamu WAJIB menolak dengan sopan dan katakan bahwa kamu hanya asisten perpustakaan.\n\nData Referensi Perpustakaan:\n" . $referenceData;

        try {
            // 4. Tembak API Groq
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . config('services.groq.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'temperature' => 0.5,
                'max_tokens' => 512,
            ]);

            // Tangani Error 429 Rate Limit Groq
            if ($response->status() === 429) {
                return response()->json([
                    'jawaban' => "Maaf, asisten AI sedang sibuk melayani banyak mahasiswa saat ini. Silakan coba kirim pertanyaanmu kembali dalam 1 menit."
                ], 429);
            }

            if (!$response->successful()) {
                Log::error('Groq API Error: ' . $response->body());
                return response()->json([
                    'jawaban' => "Maaf, terjadi kesalahan saat menghubungi server AI. Silakan coba lagi nanti."
                ], 500);
            }

            $aiResponse = $response->json('choices.0.message.content');

            // 5. Simpan Hasil ke Database Cache
            ChatCache::create([
                'pertanyaan_hash' => $messageHash,
                'pertanyaan' => $normalizedMessage,
                'jawaban' => $aiResponse
            ]);

            return response()->json([
                'jawaban' => $aiResponse,
                'source' => 'api'
            ]);

        } catch (\Exception $e) {
            Log::error('Groq Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'jawaban' => "Maaf, asisten AI sedang sibuk melayani banyak mahasiswa saat ini. Silakan coba kirim pertanyaanmu kembali dalam 1 menit."
            ], 500);
        }
    }
}
