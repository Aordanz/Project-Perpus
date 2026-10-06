<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserInformationController;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/koleksi-terbaru', [BookController::class, 'latest'])->name('koleksi.terbaru');
Route::get('/informasi', [UserInformationController::class, 'index'])->name('informasi');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::get('/kontak', function () { return view('kontak'); })->name('kontak');
Route::get('/index-judul', function () { return view('index-judul'); })->name('index-judul');
Route::get('/index-judul/{initial}', [BookController::class, 'indexJudulShow'])->name('index-judul.show');
Route::get('/galeri', [BookController::class, 'galeri'])->name('galeri');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/tambah-cover', [AdminController::class, 'tambahCoverIndex'])->name('admin.tambah-cover');
Route::get('/admin/tambah-ringkasan', [AdminController::class, 'tambahRingkasanIndex'])->name('admin.tambah-ringkasan');
Route::post('/admin/books', [AdminController::class, 'store'])->name('admin.books.store');
Route::get('/admin/books/{id}/edit', [AdminController::class, 'edit'])->name('admin.books.edit');
Route::put('/admin/books/{id}', [AdminController::class, 'update'])->name('admin.books.update');

Route::put('/admin/books/{id}/ringkasan', [AdminController::class, 'updateRingkasan'])->name('admin.books.update-ringkasan');
Route::delete('/admin/books/{id}', [AdminController::class, 'destroy'])->name('admin.books.destroy');
Route::delete('/admin/books/images/{id}', [AdminController::class, 'deleteImage'])->name('admin.books.delete-image');

Route::post('admin/information-center/bulk-republish-history', [\App\Http\Controllers\Admin\InformationCenterController::class, 'bulkRepublishHistory'])->name('admin.information-center.bulk-republish-history');
Route::post('admin/information-center/bulk-delete-history', [\App\Http\Controllers\Admin\InformationCenterController::class, 'bulkDeleteHistory'])->name('admin.information-center.bulk-delete-history');
Route::post('admin/information-center/{id}/archive', [\App\Http\Controllers\Admin\InformationCenterController::class, 'archive'])->name('admin.information-center.archive');
Route::post('admin/information-center/{id}/republish', [\App\Http\Controllers\Admin\InformationCenterController::class, 'republish'])->name('admin.information-center.republish');

Route::resource('admin/information-center', \App\Http\Controllers\Admin\InformationCenterController::class)->names('admin.information-center');


Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

// AI Chatbot Route with Rate Limiting (10 requests per minute)
Route::post('/api/chat', [ChatbotController::class, 'handleChat'])->middleware('throttle:10,1')->name('chat.api');

// Admin: Kelola Data Referensi AI Chatbot
Route::get('/admin/chatbot-data', [AdminController::class, 'chatbotData'])->name('admin.chatbot-data');
Route::post('/admin/chatbot-data', [AdminController::class, 'chatbotDataUpdate'])->name('admin.chatbot-data.update');
Route::post('/admin/chatbot-data/clear-cache', [AdminController::class, 'chatbotCacheClear'])->name('admin.chatbot-cache.clear');
Route::post('/admin/chatbot-data/toggle-status', [AdminController::class, 'chatbotToggleStatus'])->name('admin.chatbot-status.toggle');

// Active Event API Route
Route::get('/api/events/active', [EventController::class, 'getActiveEvent'])->name('events.active');

// === TEMPORARY: Diagnostic Route untuk debug chatbot di hosting (HAPUS setelah selesai debug!) ===
Route::get('/chatbot-diagnose', function () {
    $results = [];

    // 1. Cek API Key
    $apiKey = config('services.gemini.key');
    $results['1_api_key'] = !empty($apiKey) ? 'OK (tersedia, ' . strlen($apiKey) . ' karakter)' : 'GAGAL: API Key kosong!';

    // 2. Cek file data_perpus.txt
    $dataPath = storage_path('app/private/data_perpus.txt');
    $results['2_data_file'] = file_exists($dataPath) ? 'OK (ada, ' . filesize($dataPath) . ' bytes)' : 'GAGAL: File tidak ditemukan';

    // 3. Cek koneksi keluar ke Google (basic connectivity)
    try {
        $testResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
            ->timeout(10)
            ->connectTimeout(5)
            ->get('https://generativelanguage.googleapis.com/');
        $results['3_outbound_https'] = 'OK (bisa konek ke Google API, status: ' . $testResponse->status() . ')';
    } catch (\Exception $e) {
        $results['3_outbound_https'] = 'GAGAL: ' . $e->getMessage();
    }

    // 4. Cek koneksi ke Gemini API (test semua model fallback)
    if (!empty($apiKey)) {
        $testModels = ['gemini-3.8-flash', 'gemini-3.6-flash'];
        foreach ($testModels as $model) {
            try {
                $geminiResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->timeout(15)
                    ->connectTimeout(5)
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                        'contents' => [
                            ['role' => 'user', 'parts' => [['text' => 'Halo, balas singkat saja.']]]
                        ],
                        'generationConfig' => ['maxOutputTokens' => 50],
                    ]);

                $status = $geminiResponse->status();
                if ($geminiResponse->successful()) {
                    $aiText = $geminiResponse->json('candidates.0.content.parts.0.text');
                    $results["4_{$model}"] = !empty($aiText)
                        ? "✅ OK (HTTP {$status}): \"{$aiText}\""
                        : "⚠️ HTTP {$status} tapi teks kosong. Body: " . \Illuminate\Support\Str::limit($geminiResponse->body(), 200);
                } else {
                    $results["4_{$model}"] = "❌ HTTP {$status}: " . \Illuminate\Support\Str::limit($geminiResponse->body(), 200);
                }
            } catch (\Exception $e) {
                $results["4_{$model}"] = '❌ EXCEPTION: ' . $e->getMessage();
            }
        }
    } else {
        $results['4_gemini_api'] = 'SKIP: API Key kosong, tidak bisa test';
    }

    // 5. Cek PHP extensions
    $results['5_php_curl'] = extension_loaded('curl') ? 'OK' : 'GAGAL: curl tidak aktif!';
    $results['5_php_openssl'] = extension_loaded('openssl') ? 'OK' : 'GAGAL: openssl tidak aktif!';
    $results['5_php_version'] = 'PHP ' . phpversion();

    // 6. Cek allow_url_fopen
    $results['6_allow_url_fopen'] = ini_get('allow_url_fopen') ? 'OK (enabled)' : 'WARNING: disabled';

    return response()->json($results, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});
