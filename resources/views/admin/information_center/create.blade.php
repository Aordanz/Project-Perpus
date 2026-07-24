@extends('admin.information_center.layout')

@section('title', 'Tambah Informasi Baru')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* ─── CATEGORY CHIPS ────────────────────────────────────────────── */
    .cat-chip-btn {
        position: relative; display: flex; flex-direction: column;
        align-items: center; gap: 10px; padding: 18px 12px 14px;
        border-radius: 14px; border: 2px solid #e2e8f0; background: white;
        cursor: pointer; transition: all 0.18s cubic-bezier(.4,0,.2,1);
        text-align: center; user-select: none; width: 100%;
    }
    .cat-chip-btn * { pointer-events: none; }
    .cat-chip-btn:hover {
        border-color: var(--chip-color, #106c38);
        background: var(--chip-bg, #f0fdf4);
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }
    .cat-chip-btn.selected {
        border-color: var(--chip-color, #106c38);
        background: var(--chip-bg, #f0fdf4);
        box-shadow: 0 0 0 4px var(--chip-ring, rgba(16,108,56,0.12));
        transform: translateY(-1px);
    }
    .chip-check {
        display: none; position: absolute; top: -7px; right: -7px;
        width: 20px; height: 20px;
        background: var(--chip-color, #106c38); border-radius: 50%;
        color: white; font-size: 10px; align-items: center; justify-content: center;
        border: 2.5px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .cat-chip-btn.selected .chip-check { display: flex; }
    .cat-chip-icon {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; transition: transform 0.18s ease;
    }
    .cat-chip-btn.selected .cat-chip-icon { transform: scale(1.08); }
    .cat-chip-label { font-size: 12px; font-weight: 800; color: #334155; line-height: 1.3; }
    .cat-chip-sub { font-size: 9.5px; color: #94a3b8; font-weight: 500; line-height: 1.3; margin-top: 2px; }

    /* ─── CARDS ─────────────────────────────────────────────────────── */
    .form-card {
        background: white; border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .form-card-header {
        padding: 18px 24px; border-bottom: 1px solid #f8fafc;
        display: flex; align-items: center; gap: 14px;
        background: linear-gradient(to bottom, #ffffff, #fafcff);
    }
    .form-card-icon {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .form-card-body { padding: 24px; }

    /* ─── SIDEBAR ───────────────────────────────────────────────────── */
    .sidebar-card {
        background: white; border-radius: 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04); overflow: hidden;
    }
    .sidebar-card-header {
        padding: 13px 18px; border-bottom: 1px solid #f8fafc;
        display: flex; align-items: center; gap: 8px;
    }
    .sidebar-card-body { padding: 16px 18px; }

    /* ─── INPUTS ────────────────────────────────────────────────────── */
    .fi {
        display: block; width: 100%; padding: 10px 14px;
        background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 13.5px; color: #1e293b; outline: none; line-height: 1.5;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .fi:focus { border-color: #106c38; background: white; box-shadow: 0 0 0 3px rgba(16,108,56,0.08); }
    .fi-sm { padding: 8px 12px; font-size: 12.5px; }
    .fl {
        display: block; font-size: 11px; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;
    }

    /* ─── TOGGLES ───────────────────────────────────────────────────── */
    .tog-opt {
        display: flex; align-items: flex-start; gap: 11px;
        padding: 12px 14px; border-radius: 10px;
        background: #f8fafc; border: 1.5px solid #e2e8f0;
        cursor: pointer; transition: all .15s ease;
    }
    .tog-opt:has(input:checked) { background: #f0fdf4; border-color: #bbf7d0; }
    .tog-opt input[type="checkbox"] {
        width: 15px; height: 15px; margin-top: 2px;
        flex-shrink: 0; accent-color: #106c38; cursor: pointer;
    }

    /* ─── IMAGE DROPZONE ────────────────────────────────────────────── */
    .img-drop {
        border: 2px dashed #cbd5e1; border-radius: 12px;
        padding: 22px 16px; text-align: center; cursor: pointer;
        transition: all .18s ease; background: #f8fafc;
    }
    .img-drop:hover { border-color: #106c38; background: #f0fdf4; }

    /* ─── SUBMIT BUTTON ─────────────────────────────────────────────── */
    .btn-pub {
        width: 100%; padding: 13px 20px;
        background: linear-gradient(135deg, #106c38 0%, #0d5a2f 100%);
        color: white; font-weight: 800; font-size: 14px;
        border-radius: 12px; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all .2s ease; letter-spacing: .01em;
        box-shadow: 0 4px 14px rgba(16,108,56,0.28);
    }
    .btn-pub:hover {
        background: linear-gradient(135deg, #0d5a2f 0%, #0a4826 100%);
        box-shadow: 0 6px 18px rgba(16,108,56,0.35); transform: translateY(-1px);
    }
    .btn-pub:active { transform: translateY(0); }

    .sec-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 50%;
        font-size: 11px; font-weight: 900; flex-shrink: 0;
    }
    @media (min-width: 1280px) {
        .xl-sticky { position: sticky; top: 24px; }
    }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="flex items-start sm:items-center gap-4 mb-6">
    <a href="{{ route('admin.information-center.index') }}"
       class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-slate-50 hover:text-slate-800 transition-all shadow-sm shrink-0 mt-0.5 sm:mt-0">
        <i class="ph ph-arrow-left text-lg"></i>
    </a>
    <div class="min-w-0 flex-1">
        <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-medium mb-1">
            <a href="{{ route('admin.information-center.index') }}" class="hover:text-slate-600 transition">Information Center</a>
            <i class="ph ph-caret-right text-[9px]"></i>
            <span class="text-slate-600 font-semibold">Buat Informasi Baru</span>
        </div>
        <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight leading-tight">Buat Informasi Baru</h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Publikasikan event, pengumuman, tips, koleksi baru, dan info lainnya untuk pengguna perpustakaan.</p>
    </div>
</div>

<form action="{{ route('admin.information-center.store') }}" method="POST" enctype="multipart/form-data" id="create-info-form" novalidate>
    @csrf

    {{-- ═══ STEP 1: PILIH KATEGORI ═══ --}}
    <div class="form-card mb-6">
        <div class="form-card-header">
            <span class="sec-num bg-[#106c38] text-white">1</span>
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-black text-slate-800">Pilih Kategori Informasi</h2>
                <p class="text-xs text-slate-400 mt-0.5">Tentukan jenis konten — tampilan form akan menyesuaikan secara otomatis</p>
            </div>
            <span class="text-[10px] font-bold text-red-400 shrink-0">Wajib ✱</span>
        </div>
        <div class="form-card-body">

            {{-- Hidden select — dipertahankan untuk kompatibilitas JS & form submission --}}
            <select name="category" id="category-select"
                    style="position:absolute;opacity:0;pointer-events:none;width:0;height:0;overflow:hidden;"
                    tabindex="-1" aria-hidden="true">
                <option value="">-- Pilih Kategori --</option>
                <option value="announcement"       {{ old('category') == 'announcement'       ? 'selected' : '' }}>Pengumuman</option>
                <option value="event"              {{ old('category') == 'event'              ? 'selected' : '' }}>Event / Kegiatan</option>
                <option value="book_recommendation"{{ old('category') == 'book_recommendation'? 'selected' : '' }}>Buku Rekomendasi</option>
                <option value="tips"               {{ old('category') == 'tips'               ? 'selected' : '' }}>Tips &amp; Trick</option>
                <option value="library_news"       {{ old('category') == 'library_news'       ? 'selected' : '' }}>Berita Perpustakaan</option>
            </select>

            {{-- Visual Category Chip Grid (5 Kategori Utama) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3" id="category-grid">

                {{-- 1. Pengumuman --}}
                <button type="button" class="cat-chip-btn" data-value="announcement"
                        style="--chip-color:#2563eb;--chip-bg:#eff6ff;--chip-ring:rgba(37,99,235,0.13)">
                    <div class="chip-check"><i class="ph ph-check text-[9px]"></i></div>
                    <div class="cat-chip-icon bg-blue-50"><i class="ph ph-megaphone-simple text-blue-600"></i></div>
                    <div><div class="cat-chip-label">Pengumuman</div><div class="cat-chip-sub">Pemberitahuan resmi</div></div>
                </button>

                {{-- 2. Event / Kegiatan --}}
                <button type="button" class="cat-chip-btn" data-value="event"
                        style="--chip-color:#106c38;--chip-bg:#f0fdf4;--chip-ring:rgba(16,108,56,0.14)">
                    <div class="chip-check"><i class="ph ph-check text-[9px]"></i></div>
                    <div class="cat-chip-icon bg-emerald-50"><i class="ph ph-calendar-check text-[#106c38]"></i></div>
                    <div><div class="cat-chip-label">Event</div><div class="cat-chip-sub">Kegiatan &amp; Workshop</div></div>
                </button>

                {{-- 3. Buku Rekomendasi --}}
                <button type="button" class="cat-chip-btn" data-value="book_recommendation"
                        style="--chip-color:#b45309;--chip-bg:#fefce8;--chip-ring:rgba(180,83,9,0.13)">
                    <div class="chip-check"><i class="ph ph-check text-[9px]"></i></div>
                    <div class="cat-chip-icon bg-yellow-50"><i class="ph ph-star text-yellow-600"></i></div>
                    <div><div class="cat-chip-label">Buku Rekomendasi</div><div class="cat-chip-sub">Pilihan terbaik</div></div>
                </button>
                
                {{-- 4. Berita Perpustakaan --}}
                <button type="button" class="cat-chip-btn" data-value="library_news"
                        style="--chip-color:#4f46e5;--chip-bg:#eef2ff;--chip-ring:rgba(79,70,229,0.13)">
                    <div class="chip-check"><i class="ph ph-check text-[9px]"></i></div>
                    <div class="cat-chip-icon bg-indigo-50"><i class="ph ph-newspaper text-indigo-600"></i></div>
                    <div><div class="cat-chip-label">Berita Perpustakaan</div><div class="cat-chip-sub">Info &amp; kabar terkini</div></div>
                </button>

                {{-- 5. Tips & Trick --}}
                <button type="button" class="cat-chip-btn" data-value="tips"
                        style="--chip-color:#d97706;--chip-bg:#fffbeb;--chip-ring:rgba(217,119,6,0.13)">
                    <div class="chip-check"><i class="ph ph-check text-[9px]"></i></div>
                    <div class="cat-chip-icon bg-amber-50"><i class="ph ph-lightbulb-filament text-amber-600"></i></div>
                    <div><div class="cat-chip-label">Tips &amp; Trick</div><div class="cat-chip-sub">Panduan bermanfaat</div></div>
                </button>

            </div>

            {{-- Selected Category Indicator --}}
            <div id="category-indicator" class="hidden mt-4">
                <div class="flex items-center gap-2.5 text-xs bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-2.5">
                    <i class="ph ph-check-circle-fill text-[#106c38] text-base shrink-0"></i>
                    <span class="text-emerald-800 font-medium">Kategori dipilih: <strong id="category-indicator-name" class="font-black"></strong></span>
                </div>
            </div>

            {{-- Category Helper Box --}}
            <div id="category-helper-box" class="hidden mt-3 bg-blue-50/50 border border-blue-100 rounded-xl px-4 py-3">
                <div class="flex items-start gap-2.5">
                    <i class="ph ph-info text-blue-500 text-lg mt-0.5 shrink-0"></i>
                    <div>
                        <h4 id="category-helper-title" class="text-xs font-bold text-blue-800 mb-1">Panduan Kategori</h4>
                        <p id="category-helper-desc" class="text-[11px] text-blue-700 leading-relaxed">Deskripsi panduan akan muncul di sini.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══ MAIN FORM AREA (2-Column) ═══ --}}
    <div id="main-form-area" class="hidden opacity-0 transform translate-y-4 transition-all duration-500">
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            {{-- ── LEFT COLUMN ─────────────────────────────────────────── --}}
            <div class="xl:col-span-8 space-y-5">

                {{-- SECTION 1: Informasi Utama --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon bg-emerald-50">
                            <i class="ph ph-text-aa text-[#106c38] text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm font-black text-slate-800">Informasi Utama</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Judul, ringkasan singkat, dan konten lengkap informasi</p>
                        </div>
                    </div>
                    <div class="form-card-body space-y-5">

                        <div>
                            <label class="fl" for="title">Judul Informasi / Kegiatan <span class="text-red-500 normal-case">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="fi" placeholder="Contoh: Workshop Mendeley untuk Mahasiswa USU...">
                        </div>

                        <div>
                            <label class="fl" for="summary">Ringkasan Singkat
                                <span class="normal-case font-medium text-slate-400 ml-1">(tampil di halaman depan)</span>
                            </label>
                            <textarea name="summary" id="summary" rows="3" class="fi resize-none"
                                      placeholder="Tulis 1–2 kalimat menarik yang menggambarkan isi informasi ini...">{{ old('summary') }}</textarea>
                        </div>

                        <div>
                            <label class="fl" for="content">Isi Informasi Lengkap <span class="text-red-500 normal-case">*</span></label>
                            <textarea name="content" id="content" rows="6" class="fi resize-none" placeholder="Tuliskan isi informasi lengkap di sini...">{{ old('content') }}</textarea>
                            @error('content') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        </div>
                </div>

                {{-- SECTION 2: Detail Spesifik Kategori --}}
                <div id="custom-category-fields-card" class="form-card hidden">
                    <div class="form-card-header">
                        <div class="form-card-icon bg-violet-50">
                            <i class="ph ph-sliders text-violet-600 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 id="custom-fields-title" class="text-sm font-black text-slate-800 flex items-center gap-2">
                                <i class="ph ph-gear text-[#106c38] text-base"></i> Detail Spesifik Kategori
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Field ini berubah otomatis sesuai kategori yang dipilih</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div id="dynamic-fields-container">

                            {{-- Event / Kegiatan Fields --}}
                            <div id="fields-event" class="category-fields-section hidden space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="fl" for="event_time">Waktu Kegiatan <span class="text-red-500">*</span></label>
                                        <input type="text" name="event_time" id="event_time" class="fi" placeholder="Contoh: 09.00 - 12.00 WIB" value="{{ old('event_time') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="event_location">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                                        <input type="text" name="event_location" id="event_location" class="fi" placeholder="Ruang Seminar Lantai 3" value="{{ old('event_location') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="fl" for="event_organizer">Penyelenggara</label>
                                        <input type="text" name="event_organizer" id="event_organizer" class="fi" placeholder="UPT Perpustakaan USU" value="{{ old('event_organizer') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="event_participants">Sasaran Peserta</label>
                                        <input type="text" name="event_participants" id="event_participants" class="fi" placeholder="Mahasiswa & Umum" value="{{ old('event_participants') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="event_facilities">Fasilitas Acara</label>
                                        <input type="text" name="event_facilities" id="event_facilities" class="fi" placeholder="E-Sertifikat, Snack" value="{{ old('event_facilities') }}">
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-slate-50">
                                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i class="ph ph-list-bullets text-slate-300 text-base"></i>
                                        Informasi Tambahan (Opsional)
                                    </p>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="fl text-[10px]" for="event_left_features">Fitur / Benefit Flyer <span class="normal-case font-medium text-slate-400">(1 poin/baris, maks 4)</span></label>
                                            <textarea name="event_left_features" id="event_left_features" rows="3" class="fi fi-sm resize-none" placeholder="Materi Praktis&#10;Studi Kasus Nyata&#10;E-Sertifikat">{{ old('event_left_features') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pengumuman Fields --}}
                            <div id="fields-announcement" class="category-fields-section hidden space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="fl" for="announcement_time">Jadwal / Waktu <span class="normal-case font-medium text-slate-400">(Opsional)</span></label>
                                        <input type="text" name="announcement_time" id="announcement_time" class="fi" placeholder="Contoh: 08.00 - Selesai" value="{{ old('announcement_time') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="announcement_location">Lokasi / Tempat <span class="normal-case font-medium text-slate-400">(Opsional)</span></label>
                                        <input type="text" name="announcement_location" id="announcement_location" class="fi" placeholder="Contoh: Gedung A" value="{{ old('announcement_location') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Berita Perpustakaan Fields --}}
                            <div id="fields-library_news" class="category-fields-section hidden space-y-5">
                                <div>
                                    <label class="fl" for="news_date">Tanggal Berita / Kegiatan <span class="normal-case font-medium text-slate-400">(Opsional)</span></label>
                                    <input type="text" name="news_date" id="news_date" class="fi" placeholder="Contoh: 17 Agustus 2026" value="{{ old('news_date') }}">
                                </div>
                            </div>

                            {{-- Buku / Koleksi Fields --}}
                            <div id="fields-book_recommendation" class="category-fields-section hidden space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="fl" for="book_title">Judul Buku / Koleksi <span class="text-red-500">*</span></label>
                                        <input type="text" name="book_title" id="book_title" class="fi" placeholder="Algoritma & Pemrograman" value="{{ old('book_title') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="book_author">Penulis / Pencipta <span class="text-red-500">*</span></label>
                                        <input type="text" name="book_author" id="book_author" class="fi" placeholder="Prof. Dr. Budi Luhur" value="{{ old('book_author') }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="fl" for="book_publisher">Penerbit &amp; Tahun Terbit</label>
                                        <input type="text" name="book_publisher" id="book_publisher" class="fi" placeholder="Erlangga, 2024" value="{{ old('book_publisher') }}">
                                    </div>
                                    <div>
                                        <label class="fl" for="shelf_location">Lokasi Rak / Klasifikasi</label>
                                        <input type="text" name="shelf_location" id="shelf_location" class="fi" placeholder="Rak 4B - Umum / DDC 005.1" value="{{ old('shelf_location') }}">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Tombol Aksi --}}
                <div id="card-tombol-aksi" class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon bg-blue-50">
                            <i class="ph ph-link-simple text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm font-black text-slate-800">Tombol Aksi &amp; Tautan <span class="font-bold text-slate-400 text-xs">(Opsional)</span></h2>
                            <p class="text-xs text-slate-400 mt-0.5">Tambahkan tombol menuju link eksternal — Google Form, Instagram, website, dll. (Opsional)</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div id="action-buttons-container" class="space-y-3">
                            {{-- Diisi dinamis oleh JS --}}
                        </div>
                        <button type="button" id="btn-add-action-button"
                                class="mt-3 flex items-center justify-center gap-2 w-full px-4 py-3 bg-slate-50 hover:bg-blue-50 border border-slate-200 border-dashed hover:border-blue-300 text-slate-500 hover:text-blue-600 text-xs font-bold rounded-xl transition-all">
                            <i class="ph ph-plus-circle text-base"></i> Tambah Tombol Baru
                        </button>
                    </div>
                </div>

                {{-- SECTION 4: Narahubung --}}
                <div id="card-narahubung" class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon bg-amber-50">
                            <i class="ph ph-user-circle text-amber-600 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm font-black text-slate-800">Narahubung (Contact Person) <span class="font-bold text-slate-400 text-xs">(Opsional)</span></h2>
                            <p class="text-xs text-slate-400 mt-0.5">Informasi kontak yang dapat dihubungi terkait kegiatan ini. (Opsional)</p>
                        </div>
                    </div>
                    <div class="form-card-body space-y-4">
                        <div>
                            <p class="fl" for="contact_name">Nama Kontak</p>
                            <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" class="fi" placeholder="Ibu Mawar Harahap">
                        </div>
                        <div>
                            <p class="fl" for="contact_phone">Nomor WhatsApp</p>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] text-slate-500 font-bold pointer-events-none">+62</span>
                                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}" class="fi !pl-[34px]" placeholder="8123456789">
                            </div>
                        </div>
                        <div>
                            <p class="fl" for="contact_email">Alamat Email</p>
                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" class="fi" placeholder="mawar@usu.ac.id">
                        </div>
                    </div>
                </div>

            </div>{{-- END LEFT COLUMN --}}


            {{-- ── RIGHT SIDEBAR ────────────────────────────────────────────── --}}
            <div class="xl:col-span-4">
                <div class="xl-sticky space-y-4">

                    {{-- Jadwal & Status --}}
                    <div id="card-jadwal-tampil" class="sidebar-card">
                        <div class="sidebar-card-header">
                            <i class="ph ph-calendar-check text-[#106c38] text-base"></i>
                            <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Jadwal &amp; Status</h3>
                        </div>
                        <div class="sidebar-card-body space-y-4">

                            <div>
                                <p class="fl text-[10px]">Status Publikasi <span class="text-red-500">*</span></p>
                                <select name="status" id="status_select" class="fi fi-sm">
                                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>🟢  Diterbitkan — Langsung tayang</option>
                                    <option value="draft"     {{ old('status') == 'draft'      ? 'selected' : '' }}>📝  Draf — Jadwalkan tayang nanti</option>
                                </select>
                            </div>

                            <div id="live_publish_badge" class="hidden p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-xs font-semibold flex items-center gap-2">
                                <i class="ph ph-check-circle text-base"></i> Ditayangkan langsung saat di-upload (Tanggal & Jam tayang otomatis saat ini).
                            </div>

                            <div id="publish-time-container" class="space-y-4 pt-3 border-t border-slate-50">
                                <div id="start_time_wrapper">
                                    <p class="fl text-[10px]">Mulai Tayang <span class="text-red-500">*</span></p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="block text-[10px] text-slate-400 mb-1.5">Tanggal</span>
                                            <input type="date" name="publish_start_date" id="publish_start_date_input"
                                                   value="{{ old('publish_start_date', date('Y-m-d')) }}"
                                                   class="fi fi-sm px-3 py-2">
                                        </div>
                                        <div>
                                            <span class="block text-[10px] text-slate-400 mb-1.5">Jam</span>
                                            <input type="time" name="publish_start_time" id="publish_start_time_input"
                                                   value="{{ old('publish_start_time', date('H:i')) }}"
                                                   class="fi fi-sm px-3 py-2">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="fl text-[10px]">Selesai Tayang
                                        <span class="normal-case font-medium text-slate-400 ml-1">(Opsional)</span>
                                    </p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="block text-[10px] text-slate-400 mb-1.5">Tanggal</span>
                                            <input type="date" name="publish_end_date"
                                                   value="{{ old('publish_end_date') }}"
                                                   class="fi fi-sm px-3 py-2">
                                        </div>
                                        <div>
                                            <span class="block text-[10px] text-slate-400 mb-1.5">Jam</span>
                                            <input type="time" name="publish_end_time"
                                                   value="{{ old('publish_end_time') }}"
                                                   class="fi fi-sm px-3 py-2">
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1.5 leading-relaxed">Biarkan kosong untuk tayang tanpa batas waktu.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Pengaturan Tampilan --}}
                    <div id="card-pengaturan-tampilan" class="sidebar-card">
                        <div class="sidebar-card-header">
                            <i class="ph ph-layout text-violet-500 text-base"></i>
                            <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Pengaturan Tampilan</h3>
                        </div>
                        <div class="sidebar-card-body space-y-3">
                            <input type="hidden" name="show_popup" value="1">
                            <input type="hidden" name="show_navbar" value="1">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="hidden" name="popup_priority" value="1">

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Sort Order)</label>
                                <input type="number" name="sort_order" min="1" max="{{ $maxSortOrder }}" value="{{ old('sort_order', $maxSortOrder) }}" class="fi fi-sm">
                                <p class="text-[9.5px] text-slate-400 mt-1">Angka kecil = tampil paling awal. Maksimal {{ $maxSortOrder }}.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Poster / Banner --}}
                    <div id="card-poster" class="sidebar-card">
                        <div class="sidebar-card-header flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="ph ph-image text-pink-500 text-base"></i>
                                <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Poster / Banner</h3>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold uppercase">Frame Editor</span>
                        </div>
                        <div class="sidebar-card-body space-y-4">
                            <!-- Dropzone Upload -->
                            <div id="dropzone-wrapper">
                                <label class="img-drop block cursor-pointer">
                                    <div class="flex flex-col items-center justify-center gap-2.5">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center shadow-sm">
                                            <i class="ph ph-upload-simple text-2xl text-slate-400"></i>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-xs font-bold text-slate-600 block">Klik untuk Pilih Gambar</span>
                                            <span class="text-[10px] text-slate-400 mt-1 block">JPG, PNG, WEBP — Maks. 5MB</span>
                                        </div>
                                    </div>
                                    <input type="file" name="images[]" id="image-input" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp" multiple>
                                </label>
                            </div>

                            <!-- Button Ganti Foto (Tampil saat foto sudah ada) -->
                            <button type="button" id="btn-change-image" class="hidden w-full py-2.5 px-4 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-[#106c38] border border-slate-200 hover:border-emerald-300 font-bold text-xs rounded-xl flex items-center justify-center gap-2 transition-all cursor-pointer">
                                <i class="ph ph-image text-base text-[#106c38]"></i> Ganti Foto / Unggah Ulang
                            </button>
                            
                            <div id="image-preview-container" class="grid grid-cols-3 gap-2 hidden">
                                <!-- Previews will be injected here -->
                            </div>

                            <!-- Hidden Inputs for Frame Customization -->
                            <input type="hidden" name="image_scale" id="image_scale_input" value="{{ old('image_scale', 100) }}">
                            <input type="hidden" name="image_x" id="image_x_input" value="{{ old('image_x', 50) }}">
                            <input type="hidden" name="image_y" id="image_y_input" value="{{ old('image_y', 50) }}">

                            <!-- Interactive Simulasi Frame Beranda -->
                            <div class="pt-3 border-t border-slate-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ph ph-crop text-emerald-600 text-sm"></i> Frame Banner Beranda
                                    </span>
                                    <span class="text-[9.5px] text-slate-400 font-medium">Klik & Drag / Scroll Zoom</span>
                                </div>

                                <!-- Box Simulasi Frame (Exact Ratio Frame Popup) -->
                                <div id="frame-simulator-container"
                                     class="relative w-full aspect-[376/500] max-h-[380px] rounded-2xl overflow-hidden bg-white border-2 border-emerald-500/40 shadow-inner group cursor-grab active:cursor-grabbing select-none"
                                     style="aspect-ratio: 376 / 500;"
                                     title="Klik & Drag untuk menggeser posisi foto | Scroll mouse untuk Zoom">

                                    <!-- Wavy Divider Overlay (Matching Homepage Popup 100%) -->
                                    <div class="absolute left-0 top-0 h-full z-20 pointer-events-none" style="width: 25%;">
                                        <svg class="h-full w-full" viewBox="0 0 100 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M 0,0 C 55,100 75,250 20,380 C -5,430 35,480 50,500 L 0,500 Z" fill="#0f172a" fill-opacity="0.85" />
                                            <path d="M 0,0 C 55,100 75,250 20,380 C -5,430 35,480 50,500" fill="none" stroke="#eab308" stroke-width="3.5" vector-effect="non-scaling-stroke" />
                                        </svg>
                                    </div>

                                    <!-- Target Image Element -->
                                    <img id="image-preview" src="{{ asset('perpustakaan_depan.webp') }}" alt="Pratinjau Frame"
                                         class="w-full h-full object-cover transition-transform duration-75 pointer-events-none"
                                         style="object-position: {{ old('image_x', 50) }}% {{ old('image_y', 50) }}%; transform: scale({{ old('image_scale', 100) / 100 }});">

                                    <!-- Bottom Info Overlay Badge -->
                                    <div class="absolute bottom-2 left-2 right-2 px-2.5 py-1 bg-black/70 backdrop-blur-md rounded-lg text-[9.5px] text-white/90 flex items-center justify-between pointer-events-none z-30">
                                        <span class="flex items-center gap-1 font-semibold">
                                            <i class="ph ph-hand-grabbing text-yellow-400 text-xs"></i> Drag &amp; Scroll Aktif
                                        </span>
                                        <span id="preview-fit-label" class="font-black text-emerald-400">Zoom: <span id="badge-scale-val">{{ old('image_scale', 100) }}%</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Interactive Sliders for Framing & Zoom -->
                            <div class="space-y-3 pt-2 border-t border-slate-100">
                                <!-- Zoom Slider -->
                                <div>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                                        <span class="flex items-center gap-1"><i class="ph ph-magnifying-glass-plus text-emerald-600"></i> Zoom / Perbesar-Kecilkan</span>
                                        <span id="zoom-slider-val" class="text-emerald-700 font-extrabold bg-emerald-50 px-2 py-0.5 rounded text-[10px]">{{ old('image_scale', 100) }}%</span>
                                    </div>
                                    <input type="range" id="zoom-slider" min="50" max="250" value="{{ old('image_scale', 100) }}" class="w-full accent-emerald-600 cursor-pointer h-1.5 bg-slate-200 rounded-lg">
                                </div>

                                <!-- X Position Slider -->
                                <div>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                                        <span class="flex items-center gap-1"><i class="ph ph-arrows-horizontal text-blue-600"></i> Posisi Horisontal (Kiri - Kanan)</span>
                                        <span id="posx-slider-val" class="text-blue-700 font-bold text-[10px]">{{ old('image_x', 50) }}%</span>
                                    </div>
                                    <input type="range" id="posx-slider" min="0" max="100" value="{{ old('image_x', 50) }}" class="w-full accent-blue-600 cursor-pointer h-1.5 bg-slate-200 rounded-lg">
                                </div>

                                <!-- Y Position Slider -->
                                <div>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                                        <span class="flex items-center gap-1"><i class="ph ph-arrows-vertical text-purple-600"></i> Posisi Vertikal (Atas - Bawah)</span>
                                        <span id="posy-slider-val" class="text-purple-700 font-bold text-[10px]">{{ old('image_y', 50) }}%</span>
                                    </div>
                                    <input type="range" id="posy-slider" min="0" max="100" value="{{ old('image_y', 50) }}" class="w-full accent-purple-600 cursor-pointer h-1.5 bg-slate-200 rounded-lg">
                                </div>

                                <!-- Controls & Preset Buttons -->
                                <div class="grid grid-cols-2 gap-2 pt-2">
                                    <select name="image_fit" id="image_fit_select" class="fi fi-sm text-xs">
                                        <option value="cover" {{ old('image_fit', 'cover') == 'cover' ? 'selected' : '' }}>🔳 Cover (Penuh)</option>
                                        <option value="contain" {{ old('image_fit') == 'contain' ? 'selected' : '' }}>🖼️ Contain (Utuh)</option>
                                        <option value="fill" {{ old('image_fit') == 'fill' ? 'selected' : '' }}>📐 Fill (Regang)</option>
                                    </select>

                                    <button type="button" id="btn-reset-frame" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 flex items-center justify-center gap-1 transition">
                                        <i class="ph ph-arrow-counter-clockwise"></i> Reset Frame
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="space-y-2.5">
                        <button type="submit" class="btn-pub"
                                onclick="this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i>&nbsp;Menyimpan...'; this.form.submit(); this.disabled=true;">
                            <i class="ph ph-floppy-disk text-lg"></i>
                            Simpan &amp; Terbitkan
                        </button>
                        <a href="{{ route('admin.information-center.index') }}"
                           class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-700 text-xs font-bold rounded-xl transition-colors">
                            <i class="ph ph-x text-sm"></i> Batal
                        </a>
                    </div>

                </div>
            </div>{{-- END RIGHT SIDEBAR --}}

        </div>
    </div>{{-- END main-form-area --}}

</form>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    if (typeof flatpickr !== 'undefined') {
        flatpickr("input[type=time], .timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    }
</script>
<script>
    // ─── Image Preview ────────────────────────────────────────────────────────
    const imageInput   = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => { imagePreview.src = e.target.result; imagePreview.classList.remove('hidden'); };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
                imagePreview.src = '#';
            }
        });
    }

    // ─── Dynamic Multi Action Buttons ────────────────────────────────────────
    const container = document.getElementById('action-buttons-container');
    const btnAdd    = document.getElementById('btn-add-action-button');
    let btnIndex    = 0;

    function addRow(name = '', url = '', newTab = false) {
        if (!container) return;
        const rowId = `row-btn-${btnIndex}`;
        const html  = `
            <div id="${rowId}" class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 relative pt-7 sm:pt-4">
                <button type="button" onclick="document.getElementById('${rowId}').remove()"
                        class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-500 flex items-center justify-center border border-rose-100 transition text-[10px]" title="Hapus">
                    <i class="ph ph-trash"></i>
                </button>
                <div class="flex-1">
                    <p class="fl text-[10px] mb-1">Label Tombol</p>
                    <input type="text" name="action_buttons[${btnIndex}][name]" value="${name}" required class="fi fi-sm" placeholder="Contoh: Daftar Lomba">
                </div>
                <div class="flex-1">
                    <p class="fl text-[10px] mb-1">Link (URL)</p>
                    <input type="url" name="action_buttons[${btnIndex}][url]" value="${url}" required class="fi fi-sm" placeholder="https://forms.google.com/...">
                </div>
                <div class="flex items-center gap-1.5 pt-2 sm:pt-4 shrink-0">
                    <input type="checkbox" name="action_buttons[${btnIndex}][new_tab]" value="1" ${newTab ? 'checked' : ''} id="new_tab_${btnIndex}" style="accent-color:#106c38">
                    <label for="new_tab_${btnIndex}" class="text-[10px] font-bold text-slate-500 cursor-pointer whitespace-nowrap">Tab Baru</label>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        btnIndex++;
    }
    if (btnAdd) {
        btnAdd.addEventListener('click', () => addRow());
    }

    // ─── Visual Category Chips & Elements ──────────────────────────────────────
    const categorySelect        = document.getElementById('category-select');
    const categoryChips         = document.querySelectorAll('.cat-chip-btn');
    const categoryGrid          = document.getElementById('category-grid');
    const categoryIndicator     = document.getElementById('category-indicator');
    const categoryIndicatorName = document.getElementById('category-indicator-name');
    const btnChangeCategory     = document.getElementById('btn-change-category');
    const categoryHelperBox     = document.getElementById('category-helper-box');
    const categoryHelperDesc    = document.getElementById('category-helper-desc');

    const mainFormArea          = document.getElementById('main-form-area');
    const customFieldsCard      = document.getElementById('custom-category-fields-card');
    const customFieldsTitle     = document.getElementById('custom-fields-title');
    const allSections           = document.querySelectorAll('.category-fields-section');
    const cardTombolAksi        = document.getElementById('card-tombol-aksi');
    const cardNarahubung        = document.getElementById('card-narahubung');
    const publishTimeContainer  = document.getElementById('publish-time-container');
    const popupOptionContainer  = document.getElementById('popup-option-container');
    const cardPoster            = document.getElementById('card-poster');
    const publishStartDateInput = document.getElementById('publish_start_date_input');
    const publishStartTimeInput = document.getElementById('publish_start_time_input');

    const catLabels = {
        announcement:       'Pengumuman',
        event:              'Event / Kegiatan',
        book_recommendation:'Buku Rekomendasi',
        library_news:       'Berita Perpustakaan',
        tips:               'Tips & Trick'
    };

    const catHelpers = {
        announcement: 'Digunakan untuk informasi resmi dari perpustakaan. Contoh: Perubahan Jam Operasional, Maintenance Sistem, Libur Nasional, Layanan Baru, dan Pengingat Pengembalian Buku.',
        event: 'Digunakan untuk menginformasikan kegiatan perpustakaan. Contoh: Workshop, Seminar, Pelatihan, Lomba, Bedah Buku, dan kegiatan lainnya.',
        book_recommendation: 'Digunakan untuk memberikan informasi atau rekomendasi mengenai koleksi buku. Contoh: Rekomendasi Buku Minggu Ini, Buku Pilihan Pustakawan, Buku Terpopuler, Buku Referensi Skripsi, dan Rekomendasi Bacaan berdasarkan tema.',
        library_news: 'Digunakan untuk berita dan dokumentasi kegiatan perpustakaan. Contoh: Dokumentasi Kegiatan, Prestasi, Kerja Sama, dan Peresmian Fasilitas Baru.',
        tips: 'Digunakan untuk memberikan panduan kepada pengguna. Contoh: Cara Meminjam Buku, Cara Menggunakan OPAC, Tips Mencari Jurnal, Panduan Akses Repository, serta FAQ.'
    };

    function handleCategoryChange() {
        if (!categorySelect || !mainFormArea) return;
        const val = categorySelect.value;
        if (!val) {
            mainFormArea.classList.add('hidden', 'opacity-0', 'translate-y-4');
            mainFormArea.classList.remove('opacity-100');
            mainFormArea.style.display = 'none';
            return;
        }
        mainFormArea.classList.remove('hidden', 'opacity-0', 'translate-y-4');
        mainFormArea.classList.add('opacity-100');
        mainFormArea.style.display = 'block';

        if (allSections) allSections.forEach(sec => sec.classList.add('hidden'));
        if (customFieldsCard) customFieldsCard.classList.add('hidden');
        if (cardTombolAksi) cardTombolAksi.classList.remove('hidden');
        if (cardNarahubung) cardNarahubung.classList.remove('hidden');
        if (publishTimeContainer) publishTimeContainer.classList.remove('hidden');
        if (popupOptionContainer) popupOptionContainer.classList.remove('hidden');
        if (cardPoster) cardPoster.classList.remove('hidden');
        if (publishStartDateInput) publishStartDateInput.required = true;
        if (publishStartTimeInput) publishStartTimeInput.required = true;

        if (val === 'event') {
            const fieldsEvent = document.getElementById('fields-event');
            if (fieldsEvent) fieldsEvent.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-calendar-check text-[#106c38] text-base"></i> Detail Event / Kegiatan';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
        } else if (val === 'announcement') {
            const fieldsAnnouncement = document.getElementById('fields-announcement');
            if (fieldsAnnouncement) fieldsAnnouncement.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-megaphone-simple text-blue-500 text-base"></i> Detail Tambahan Pengumuman';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        } else if (val === 'book_recommendation') {
            const fieldsBook = document.getElementById('fields-book_recommendation');
            if (fieldsBook) fieldsBook.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-star text-yellow-500 text-base"></i> Detail Buku Rekomendasi';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        } else if (val === 'tips') {
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        } else if (val === 'library_news') {
            const fieldsNews = document.getElementById('fields-library_news');
            if (fieldsNews) fieldsNews.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-newspaper text-indigo-500 text-base"></i> Detail Berita Perpustakaan';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        }
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', handleCategoryChange);
    }

    categoryChips.forEach(chip => {
        chip.addEventListener('click', (e) => {
            e.preventDefault();
            categoryChips.forEach(c => c.classList.remove('selected'));
            chip.classList.add('selected');
            if (categorySelect) categorySelect.value = chip.dataset.value;
            if (categoryIndicatorName) categoryIndicatorName.textContent = catLabels[chip.dataset.value] || chip.dataset.value;
            if (categoryIndicator) categoryIndicator.classList.remove('hidden');
            
            if (catHelpers[chip.dataset.value] && categoryHelperDesc && categoryHelperBox) {
                categoryHelperDesc.textContent = catHelpers[chip.dataset.value];
                categoryHelperBox.classList.remove('hidden');
            } else if (categoryHelperBox) {
                categoryHelperBox.classList.add('hidden');
            }

            handleCategoryChange();

            setTimeout(() => {
                if (mainFormArea) {
                    mainFormArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 50);
        });
    });



    // Restore chip from old() value on page load
    const _oldCat = '{{ old("category") }}';
    if (_oldCat) {
        const m = document.querySelector(`.cat-chip-btn[data-value="${_oldCat}"]`);
        if (m) { 
            m.classList.add('selected'); 
            if (categoryIndicatorName) categoryIndicatorName.textContent = catLabels[_oldCat] || _oldCat; 
            if (categoryIndicator) categoryIndicator.classList.remove('hidden'); 
            
            if (catHelpers[_oldCat] && categoryHelperDesc && categoryHelperBox) {
                categoryHelperDesc.textContent = catHelpers[_oldCat];
                categoryHelperBox.classList.remove('hidden');
            }
        }
    }

    handleCategoryChange();

    // ─── Status & Jadwal Tayang Logic ──────────────────────────────────────────
    const statusSelect = document.getElementById('status_select');
    const livePublishBadge = document.getElementById('live_publish_badge');
    const startTimeWrapper = document.getElementById('start_time_wrapper');

    function updateStatusScheduleState() {
        if (!statusSelect) return;

        if (statusSelect.value === 'published') {
            if (startTimeWrapper) startTimeWrapper.classList.add('hidden');
            if (livePublishBadge) livePublishBadge.classList.remove('hidden');
            if (publishStartDateInput) publishStartDateInput.required = false;
            if (publishStartTimeInput) publishStartTimeInput.required = false;
        } else {
            if (startTimeWrapper) startTimeWrapper.classList.remove('hidden');
            if (livePublishBadge) livePublishBadge.classList.add('hidden');
            if (publishStartDateInput) publishStartDateInput.required = true;
            if (publishStartTimeInput) publishStartTimeInput.required = true;

            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            if (publishStartDateInput) publishStartDateInput.min = `${year}-${month}-${day}`;
        }
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatusScheduleState);
        updateStatusScheduleState();
    }

    function validateDraftTime() {
        if (statusSelect && statusSelect.value === 'draft' && publishStartDateInput && publishStartTimeInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const currentDateStr = `${year}-${month}-${day}`;
            const currentTimeStr = `${hours}:${minutes}`;

            if (publishStartDateInput.value === currentDateStr && publishStartTimeInput.value < currentTimeStr) {
                publishStartTimeInput.value = currentTimeStr;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jam Tidak Valid',
                        text: 'Waktu mulai tayang untuk draf/jadwal tidak boleh sebelum jam saat ini!',
                        confirmButtonColor: '#106c38'
                    });
                }
            }
        }
    }

    if (publishStartDateInput && publishStartTimeInput) {
        publishStartDateInput.addEventListener('change', validateDraftTime);
        publishStartTimeInput.addEventListener('change', validateDraftTime);
    }

    // ─── Interactive Image Framing, Zoom & Drag Editor ───────────────────────
    const imageFitSelect    = document.getElementById('image_fit_select');
    const zoomSlider        = document.getElementById('zoom-slider');
    const posxSlider        = document.getElementById('posx-slider');
    const posySlider        = document.getElementById('posy-slider');
    const zoomSliderVal     = document.getElementById('zoom-slider-val');
    const posxSliderVal     = document.getElementById('posx-slider-val');
    const posySliderVal     = document.getElementById('posy-slider-val');
    const badgeScaleVal     = document.getElementById('badge-scale-val');
    
    const imageScaleInput   = document.getElementById('image_scale_input');
    const imageXInput       = document.getElementById('image_x_input');
    const imageYInput       = document.getElementById('image_y_input');
    
    const frameContainer    = document.getElementById('frame-simulator-container');
    const btnResetFrame     = document.getElementById('btn-reset-frame');

    function updateFrameStyling() {
        if (!imagePreview) return;

        const scaleVal = zoomSlider ? parseInt(zoomSlider.value) : 100;
        const posXVal  = posxSlider ? parseInt(posxSlider.value) : 50;
        const posYVal  = posySlider ? parseInt(posySlider.value) : 50;
        const fitVal   = imageFitSelect ? imageFitSelect.value : 'cover';

        if (imageScaleInput) imageScaleInput.value = scaleVal;
        if (imageXInput)     imageXInput.value     = posXVal;
        if (imageYInput)     imageYInput.value     = posYVal;

        if (zoomSliderVal) zoomSliderVal.textContent = `${scaleVal}%`;
        if (posxSliderVal) posxSliderVal.textContent = `${posXVal}%`;
        if (posySliderVal) posySliderVal.textContent = `${posYVal}%`;
        if (badgeScaleVal) badgeScaleVal.textContent = `${scaleVal}%`;

        imagePreview.style.objectFit = fitVal;
        imagePreview.style.objectPosition = `${posXVal}% ${posYVal}%`;
        imagePreview.style.transform = `scale(${scaleVal / 100})`;
    }

    if (zoomSlider) zoomSlider.addEventListener('input', updateFrameStyling);
    if (posxSlider) posxSlider.addEventListener('input', updateFrameStyling);
    if (posySlider) posySlider.addEventListener('input', updateFrameStyling);
    if (imageFitSelect) imageFitSelect.addEventListener('change', updateFrameStyling);

    if (btnResetFrame) {
        btnResetFrame.addEventListener('click', () => {
            if (zoomSlider) zoomSlider.value = 100;
            if (posxSlider) posxSlider.value = 50;
            if (posySlider) posySlider.value = 50;
            if (imageFitSelect) imageFitSelect.value = 'cover';
            updateFrameStyling();
        });
    }

    let isDragging = false;
    let startX = 0, startY = 0;
    let startPosX = 50, startPosY = 50;

    if (frameContainer) {
        frameContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            startPosX = posxSlider ? parseInt(posxSlider.value) : 50;
            startPosY = posySlider ? parseInt(posySlider.value) : 50;
            frameContainer.classList.add('cursor-grabbing');
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const rect = frameContainer.getBoundingClientRect();
            const deltaX = e.clientX - startX;
            const deltaY = e.clientY - startY;

            const movePercentX = (deltaX / rect.width) * 100;
            const movePercentY = (deltaY / rect.height) * 100;

            let newX = Math.round(startPosX - movePercentX);
            let newY = Math.round(startPosY - movePercentY);

            newX = Math.max(0, Math.min(100, newX));
            newY = Math.max(0, Math.min(100, newY));

            if (posxSlider) posxSlider.value = newX;
            if (posySlider) posySlider.value = newY;
            updateFrameStyling();
        });

        window.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                frameContainer.classList.remove('cursor-grabbing');
            }
        });

        frameContainer.addEventListener('wheel', (e) => {
            e.preventDefault();
            if (!zoomSlider) return;
            let currentZoom = parseInt(zoomSlider.value);
            if (e.deltaY < 0) {
                currentZoom = Math.min(250, currentZoom + 5);
            } else {
                currentZoom = Math.max(50, currentZoom - 5);
            }
            zoomSlider.value = currentZoom;
            updateFrameStyling();
        }, { passive: false });
    }

    const dropzoneWrapper = document.getElementById('dropzone-wrapper');
    const btnChangeImage   = document.getElementById('btn-change-image');
    const frameSimImage    = document.getElementById('frame-sim-image');

    if (btnChangeImage && imageInput) {
        btnChangeImage.addEventListener('click', () => {
            imageInput.click();
        });
    }

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                if (dropzoneWrapper) dropzoneWrapper.classList.add('hidden');
                if (btnChangeImage) btnChangeImage.classList.remove('hidden');

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (frameSimImage) frameSimImage.src = e.target.result;
                    updateFrameStyling();
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    updateFrameStyling();

    // ─── Form Validation ──────────────────────────────────────────────────────
    const createForm = document.getElementById('create-info-form');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            if (categorySelect && !categorySelect.value) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning', title: 'Kategori Belum Dipilih',
                        text: 'Silakan pilih salah satu kategori informasi terlebih dahulu.',
                        confirmButtonColor: '#106c38', confirmButtonText: 'Pilih Kategori'
                    }).then(() => {
                        if (categoryGrid) categoryGrid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                }
            }
        });
    }
</script>
@endpush