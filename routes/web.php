<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/koleksi-terbaru', [BookController::class, 'latest'])->name('koleksi.terbaru');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::get('/kontak', function () { return view('kontak'); })->name('kontak');
Route::get('/index-judul', function () { return view('index-judul'); })->name('index-judul');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});
