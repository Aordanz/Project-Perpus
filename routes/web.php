<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EventController;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/koleksi-terbaru', [BookController::class, 'latest'])->name('koleksi.terbaru');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::get('/kontak', function () { return view('kontak'); })->name('kontak');
Route::get('/index-judul', function () { return view('index-judul'); })->name('index-judul');
Route::get('/index-judul/{initial}', [BookController::class, 'indexJudulShow'])->name('index-judul.show');
Route::get('/galeri', [BookController::class, 'galeri'])->name('galeri');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/kontak', [BookController::class, 'storeContact'])->name('kontak.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/tambah-cover', [AdminController::class, 'tambahCoverIndex'])->name('admin.tambah-cover');
Route::post('/admin/books', [AdminController::class, 'store'])->name('admin.books.store');
Route::get('/admin/books/{id}/edit', [AdminController::class, 'edit'])->name('admin.books.edit');
Route::put('/admin/books/{id}', [AdminController::class, 'update'])->name('admin.books.update');
Route::delete('/admin/books/{id}', [AdminController::class, 'destroy'])->name('admin.books.destroy');
Route::delete('/admin/books/images/{id}', [AdminController::class, 'deleteImage'])->name('admin.books.delete-image');

Route::get('admin/information-center/trash', [\App\Http\Controllers\Admin\InformationCenterController::class, 'trash'])->name('admin.information-center.trash');
Route::post('admin/information-center/{id}/restore', [\App\Http\Controllers\Admin\InformationCenterController::class, 'restore'])->name('admin.information-center.restore');
Route::delete('admin/information-center/{id}/force-delete', [\App\Http\Controllers\Admin\InformationCenterController::class, 'forceDelete'])->name('admin.information-center.force-delete');

Route::resource('admin/information-center', \App\Http\Controllers\Admin\InformationCenterController::class)->names('admin.information-center');


Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

// AI Chatbot Route with Rate Limiting (10 requests per minute)
Route::post('/api/chat', [ChatbotController::class, 'handleChat'])->middleware('throttle:10,1')->name('chat.api');

// Active Event API Route
Route::get('/api/events/active', [EventController::class, 'getActiveEvent'])->name('events.active');
