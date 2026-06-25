<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/koleksi-terbaru', [BookController::class, 'latest'])->name('koleksi.terbaru');
Route::get('/bantuan', function () { return view('bantuan'); })->name('bantuan');
Route::get('/kontak', function () { return view('kontak'); })->name('kontak');
Route::get('/index-judul', function () { return view('index-judul'); })->name('index-judul');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/books', [AdminController::class, 'store'])->name('admin.books.store');
Route::get('/admin/books/{id}/edit', [AdminController::class, 'edit'])->name('admin.books.edit');
Route::put('/admin/books/{id}', [AdminController::class, 'update'])->name('admin.books.update');
Route::delete('/admin/books/{id}', [AdminController::class, 'destroy'])->name('admin.books.destroy');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
});
