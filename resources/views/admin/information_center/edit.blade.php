@extends('admin.information_center.layout')

@php
    $contentDecoded = json_decode($informationCenter->content, true);
    $isJson = is_array($contentDecoded);
@endphp

@section('title', 'Edit Informasi')

@push('styles')
<style>
</style>
@endpush

@section('content')
<!-- Header Area -->
<div class="flex items-center gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm mb-6">
    <a href="{{ route('admin.information-center.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors">
        <i class="ph ph-arrow-left text-xl"></i>
    </a>
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Edit Informasi</h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Perbarui data informasi "{{ $informationCenter->title }}".</p>
    </div>
</div>

<form action="{{ route('admin.information-center.update', $informationCenter->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- CARD 0: PILIH KATEGORI TERLEBIH DAHULU -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-6">
        <label class="block text-sm font-bold text-slate-800 uppercase mb-3 flex items-center gap-2">
            <i class="ph ph-tag text-usu-green text-xl"></i> Kategori Informasi <span class="text-red-500">*</span>
        </label>
        <select name="category" id="category-select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all cursor-pointer">
            <option value="">-- Silakan Pilih Kategori Informasi --</option>
            <option value="announcement" {{ old('category', $informationCenter->category) == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
            <option value="event" {{ old('category', $informationCenter->category) == 'event' ? 'selected' : '' }}>Event / Kegiatan</option>
            <option value="book_recommendation" {{ old('category', $informationCenter->category) == 'book_recommendation' ? 'selected' : '' }}>Buku Rekomendasi</option>
            <option value="library_news" {{ old('category', $informationCenter->category) == 'library_news' ? 'selected' : '' }}>Berita Perpustakaan</option>
            <option value="tips" {{ old('category', $informationCenter->category) == 'tips' ? 'selected' : '' }}>Tips & Trik</option>
        </select>

        {{-- Category Helper Box --}}
        <div id="category-helper-box" class="hidden mt-4 bg-blue-50/50 border border-blue-100 rounded-xl px-4 py-3">
            <div class="flex items-start gap-2.5">
                <i class="ph ph-info text-blue-500 text-lg mt-0.5 shrink-0"></i>
                <div>
                    <h4 id="category-helper-title" class="text-xs font-bold text-blue-800 mb-1">Panduan Kategori</h4>
                    <p id="category-helper-desc" class="text-[11px] text-blue-700 leading-relaxed">Deskripsi panduan akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- AREA FORM UTAMA -->
    <div id="main-form-area" class="hidden opacity-0 transform translate-y-4 transition-all duration-500 space-y-6">
        <!-- Grid Layout Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Konten Utama & Pengaturan Tambahan -->
            <div class="lg:col-span-2 space-y-6">
            
            <!-- CARD 1: KONTEN UTAMA -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <h2 class="text-base font-black text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-text-aa text-usu-green text-lg"></i> Konten Utama Informasi
                </h2>
                <div class="space-y-5">
                    <div>
                        <p class="block text-xs font-bold text-slate-700 uppercase mb-2">Judul Informasi / Kegiatan <span class="text-red-500">*</span></p>
                        <input type="text" name="title" value="{{ old('title', $informationCenter->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all" placeholder="Contoh: Pemeliharaan Server Web Perpustakaan...">
                    </div>

                    <div>
                        <p class="block text-xs font-bold text-slate-700 uppercase mb-2">Ringkasan Singkat (Penjelasan Singkat di Halaman Depan)</p>
                        <textarea name="summary" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all" placeholder="Tuliskan ringkasan 1-2 kalimat untuk mempermudah pembaca...">{{ old('summary', $informationCenter->summary) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2" for="content">Isi Informasi Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="content" id="content" rows="6" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all resize-none" placeholder="Tuliskan isi informasi lengkap di sini...">{{ old('content', $informationCenter->content) }}</textarea>
                        @error('content') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    </div>
                </div>
            </div>

            <!-- CARD BARU: DETAIL SPESIFIK KATEGORI -->
            <div id="custom-category-fields-card" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 hidden">
                <h2 id="custom-fields-title" class="text-base font-black text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-gear text-usu-green text-lg"></i> Detail Informasi Spesifik
                </h2>
                
                <!-- Section Form Dinamis berdasarkan Kategori -->
                <div id="dynamic-fields-container">
                    <!-- Event / Kegiatan Fields -->
                    <div id="fields-event" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Waktu Kegiatan <span class="text-red-500">*</span></p>
                                <input type="text" name="event_time" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 09.00 - 12.00 WIB" value="{{ old('event_time', $isJson ? ($contentDecoded['time'] ?? '09.00 - 12.00 WIB') : '09.00 - 12.00 WIB') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Lokasi Kegiatan <span class="text-red-500">*</span></p>
                                <input type="text" name="event_location" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Ruang Seminar Lantai 3" value="{{ old('event_location', $isJson ? ($contentDecoded['location'] ?? 'Gedung UPT Perpustakaan USU') : 'Gedung UPT Perpustakaan USU') }}">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Penyelenggara</p>
                                <input type="text" name="event_organizer" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: UPT Perpustakaan USU" value="{{ old('event_organizer', $isJson ? ($contentDecoded['organizer'] ?? 'UPT Perpustakaan Universitas Sumatera Utara') : 'UPT Perpustakaan Universitas Sumatera Utara') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Sasaran Peserta</p>
                                <input type="text" name="event_participants" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Mahasiswa & Umum" value="{{ old('event_participants', $isJson ? ($contentDecoded['participants'] ?? 'Civitas Akademika USU & Umum') : 'Civitas Akademika USU & Umum') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Fasilitas Acara</p>
                                <input type="text" name="event_facilities" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: E-Sertifikat, Snack" value="{{ old('event_facilities', $isJson ? ($contentDecoded['facilities'] ?? 'Ilmu Bermanfaat, E-Sertifikat') : 'Ilmu Bermanfaat, E-Sertifikat') }}">
                            </div>
                        </div>
                        <div class="border-t border-slate-100 pt-4 mt-2">
                            <h4 class="text-xs font-black text-slate-700 uppercase mb-3">Tampilan Brosur Kiri (Flyer Slider)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="block text-[10px] font-bold text-slate-500 mb-2">Label Badge Flyer</p>
                                    <input type="text" name="event_left_badge" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Contoh: EVENT PERPUSTAKAAN" value="{{ old('event_left_badge', $isJson ? ($contentDecoded['left_badge'] ?? 'EVENT PERPUSTAKAAN') : 'EVENT PERPUSTAKAAN') }}">
                                </div>
                                <div>
                                    <p class="block text-[10px] font-bold text-slate-500 mb-2">Judul Besar Flyer (Kiri)</p>
                                    <input type="text" name="event_left_title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Kosongkan untuk samakan judul" value="{{ old('event_left_title', $isJson ? ($contentDecoded['left_title'] ?? '') : '') }}">
                                </div>
                                <div>
                                    <p class="block text-[10px] font-bold text-slate-500 mb-2">Subjudul Flyer (Kiri)</p>
                                    <input type="text" name="event_left_subtitle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Teks singkat penarik minat" value="{{ old('event_left_subtitle', $isJson ? ($contentDecoded['left_subtitle'] ?? '') : '') }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <p class="block text-[10px] font-bold text-slate-500 mb-2">Stiker / Quota Tag</p>
                                    <input type="text" name="event_quota_tag" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Contoh: PENDAFTARAN DIBUKA!<br>Kuota Terbatas!" value="{{ old('event_quota_tag', $isJson ? ($contentDecoded['quota_tag'] ?? 'PENDAFTARAN DIBUKA!<br>Jangan sampai ketinggalan!') : 'PENDAFTARAN DIBUKA!<br>Jangan sampai ketinggalan!') }}">
                                </div>
                                <div>
                                    <p class="block text-[10px] font-bold text-slate-500 mb-2">Fitur / Benefit Flyer (Tulis 1 poin per baris, maks 4 baris)</p>
                                    <textarea name="event_left_features" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Materi Praktis&#10;Studi Kasus Nyata&#10;E-Sertifikat&#10;Doorprize Menarik">{{ old('event_left_features', $isJson && !empty($contentDecoded['left_features']) ? implode("\n", $contentDecoded['left_features']) : "Materi Praktis\nStudi Kasus Nyata\nE-Sertifikat\nDoorprize Menarik") }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengumuman Fields -->
                    <div id="fields-announcement" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Jadwal / Waktu <span class="font-normal text-slate-400">(Opsional)</span></p>
                                <input type="text" name="announcement_time" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 08.00 - Selesai" value="{{ old('announcement_time', $isJson && ($contentDecoded['is_custom_announcement'] ?? false) ? ($contentDecoded['time'] ?? '') : '') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Lokasi / Tempat <span class="font-normal text-slate-400">(Opsional)</span></p>
                                <input type="text" name="announcement_location" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Gedung A" value="{{ old('announcement_location', $isJson && ($contentDecoded['is_custom_announcement'] ?? false) ? ($contentDecoded['location'] ?? '') : '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Berita Perpustakaan Fields -->
                    <div id="fields-library_news" class="category-fields-section hidden space-y-4">
                        <div>
                            <p class="block text-xs font-bold text-slate-700 mb-2">Tanggal Berita / Kegiatan <span class="font-normal text-slate-400">(Opsional)</span></p>
                            <input type="text" name="news_date" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 17 Agustus 2026" value="{{ old('news_date', $isJson && ($contentDecoded['is_custom_news'] ?? false) ? ($contentDecoded['date'] ?? '') : '') }}">
                        </div>
                    </div>

                    <!-- Buku / Koleksi Baru Fields -->
                    <div id="fields-book_recommendation" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Judul Buku / Koleksi <span class="text-red-500">*</span></p>
                                <input type="text" name="book_title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Algoritma & Pemrograman" value="{{ old('book_title', $isJson && ($contentDecoded['is_custom_collection'] ?? false) ? ($contentDecoded['book_title'] ?? '') : '') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Penulis / Pencipta <span class="text-red-500">*</span></p>
                                <input type="text" name="book_author" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Prof. Dr. Budi Luhur" value="{{ old('book_author', $isJson && ($contentDecoded['is_custom_collection'] ?? false) ? ($contentDecoded['book_author'] ?? '') : '') }}">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Penerbit & Tahun Terbit</p>
                                <input type="text" name="book_publisher" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Erlangga, 2024" value="{{ old('book_publisher', $isJson && ($contentDecoded['is_custom_collection'] ?? false) ? ($contentDecoded['book_publisher'] ?? '') : '') }}">
                            </div>
                            <div>
                                <p class="block text-xs font-bold text-slate-700 mb-2">Lokasi Rak / Klasifikasi Buku</p>
                                <input type="text" name="shelf_location" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Rak 4B - Umum atau Klasifikasi DDC 005.1" value="{{ old('shelf_location', $isJson && ($contentDecoded['is_custom_collection'] ?? false) ? ($contentDecoded['shelf_location'] ?? '') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: TOMBOL AKSI (LINK / TAUTAN) -->
            <!-- CARD 2: TOMBOL AKSI (LINK / TAUTAN) -->
            <div id="card-tombol-aksi" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <h2 class="text-base font-black text-slate-800 mb-2 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span class="flex items-center gap-2"><i class="ph ph-link-simple text-usu-green text-lg"></i> Tombol Aksi / Tautan</span>
                </h2>
                <p class="text-xs text-slate-500 mb-4">Anda dapat membuat tombol khusus (seperti "Daftar Lomba", "Baca Selengkapnya") yang mengarah ke link eksternal (Google Form, Instagram, dll).</p>
                
                <div id="action-buttons-container" class="space-y-4">
                    <!-- Dinamis ditambah lewat JS -->
                </div>
                
                <button type="button" id="btn-add-action-button" class="mt-3 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition flex items-center gap-1">
                    <i class="ph ph-plus-circle text-base"></i> Tambah Tombol Baru
                </button>
            </div>

            <!-- CARD 3: NARAHUBUNG (CONTACT PERSON) -->
            <div id="card-narahubung" class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <h2 class="text-base font-black text-slate-800 mb-2 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-user-circle text-usu-green text-lg"></i> Narahubung / Kontak Informasi
                </h2>
                <p class="text-xs text-slate-500 mb-4">Cantumkan informasi kontak yang dapat dihubungi oleh pengunjung jika ada pertanyaan.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="block text-xs font-bold text-slate-700 mb-2">Nama Kontak</p>
                        <input type="text" name="contact_name" value="{{ old('contact_name', $informationCenter->contact_name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Ibu Mawar Harahap">
                    </div>
                    <div>
                        <p class="block text-xs font-bold text-slate-700 mb-2">Nomor WhatsApp</p>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] text-slate-500 font-bold pointer-events-none">+62</span>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $informationCenter->contact_phone) }}" class="w-full pl-[34px] pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="8123456789">
                        </div>
                    </div>
                    <div>
                        <p class="block text-xs font-bold text-slate-700 mb-2">Alamat Email</p>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $informationCenter->contact_email) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: mawar@usu.ac.id">
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Pengaturan Penerbitan & Tampilan -->
        <div class="space-y-6">
            
            <!-- CARD 4: PENGATURAN PUBLIKASI (STATUS & WAKTU TAYANG) -->
            <div id="card-jadwal-tampil" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-base font-black text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-calendar text-usu-green text-lg"></i> Jadwal Tampil & Status
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="block text-xs font-bold text-slate-700 mb-2">Status Publikasi <span class="text-red-500">*</span></p>
                        <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="draft" {{ old('status', $informationCenter->status) == 'draft' ? 'selected' : '' }}>Draf (Disimpan Dulu)</option>
                            <option value="published" {{ old('status', $informationCenter->status) == 'published' ? 'selected' : '' }}>Diterbitkan (Langsung Tayang)</option>
                            <option value="archived" {{ old('status', $informationCenter->status) == 'archived' ? 'selected' : '' }}>Diarsipkan (Dihilangkan Dari Web)</option>
                        </select>
                    </div>

                    <!-- Pemisahan Tanggal dan Jam agar Mudah Di-Klik Orang Tua -->
                    <div id="publish-time-container" class="space-y-4 border-t border-slate-100 pt-3">
                        <div>
                            <p class="block text-xs font-bold text-slate-700 mb-2">Waktu Mulai Tayang <span class="text-red-500">*</span></p>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Tanggal Mulai</span>
                                    <input type="date" name="publish_start_date" id="publish_start_date_input" value="{{ old('publish_start_date', $informationCenter->publish_start_at->format('Y-m-d')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Jam Mulai</span>
                                    <input type="time" name="publish_start_time" id="publish_start_time_input" value="{{ old('publish_start_time', $informationCenter->publish_start_at->format('H:i')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="block text-xs font-bold text-slate-700 mb-2">Waktu Selesai Tayang (Opsional)</p>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Tanggal Selesai</span>
                                    <input type="date" name="publish_end_date" value="{{ old('publish_end_date', $informationCenter->publish_end_at ? $informationCenter->publish_end_at->format('Y-m-d') : '') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Jam Selesai</span>
                                    <input type="time" name="publish_end_time" value="{{ old('publish_end_time', $informationCenter->publish_end_at ? $informationCenter->publish_end_at->format('H:i') : '') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                            </div>
                            <span class="text-[10px] text-slate-500 mt-2 block">Biarkan kosong jika informasi ini ingin ditayangkan selamanya tanpa batas waktu.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 5: PENGATURAN TAMPILAN (DENGAN PENJELASAN SEDERHANA) -->
            <div id="card-pengaturan-tampilan" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-base font-black text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-desktop-tower text-usu-green text-lg"></i> Pengaturan Tampilan
                </h3>
                
                <div class="space-y-4">
                    <!-- Popup -->
                    <div id="popup-option-container" class="p-3 bg-slate-50 rounded-2xl border border-slate-150">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_popup" value="1" {{ old('show_popup', $informationCenter->show_popup) ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Tampilkan Popup</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan langsung **muncul melayang** sebagai iklan/pengumuman di layar depan pengunjung saat pertama kali membuka website perpustakaan.</span>
                        
                        <div class="mt-2.5 pt-2.5 border-t border-slate-200/60">
                            <label class="block text-[10px] font-bold text-slate-700 mb-1 uppercase">Prioritas Popup (Urutan Keutamaan)</label>
                            <input type="number" name="popup_priority" value="{{ old('popup_priority', $informationCenter->popup_priority) }}" min="1" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs">
                            <span class="text-[9px] text-slate-400 mt-1 block">Angka lebih tinggi (misal: 5) akan diutamakan muncul di atas angka rendah (misal: 1) jika ada lebih dari satu popup aktif bersamaan.</span>
                        </div>
                    </div>

                    <!-- Navbar -->
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-150">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_navbar" value="1" {{ old('show_navbar', $informationCenter->show_navbar) ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Tampilkan di Navbar</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan muncul di menu **Pusat Informasi** pada bar navigasi atas website, memudahkan pengunjung mencarinya kembali.</span>
                    </div>

                    <!-- Featured -->
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-150">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $informationCenter->is_featured) ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Sorotan / Highlight</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan menjadi sorotan utama perpustakaan dan ditampilkan secara khusus.</span>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <p class="block text-xs font-bold text-slate-700 mb-1.5">Urutan Pengurutan (Sort Order)</p>
                        <input type="number" name="sort_order" min="1" max="{{ max(1, \App\Models\InformationCenter::count()) }}" value="{{ old('sort_order', $informationCenter->sort_order) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        <span class="text-[10px] text-slate-400 mt-1 block">Angka kecil (misal: 1) akan ditampilkan paling pertama dibandingkan angka yang lebih besar.</span>
                    </div>
                </div>
            </div>

            <!-- CARD 6: POSTER / BANNER (MEDIA PENDUKUNG) -->
            <div id="card-poster" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-base font-black text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="ph ph-image text-usu-green text-lg"></i> Poster / Banner Kegiatan
                </h3>
                
                <div class="text-center">
                    <img id="image-preview" src="{{ $informationCenter->image_path ? asset($informationCenter->image_path) : '#' }}" alt="Pratinjau Gambar" class="{{ $informationCenter->image_path ? '' : 'hidden' }} w-full h-auto rounded-xl object-cover border border-slate-200 mb-4">
                    
                    <label class="block w-full cursor-pointer bg-slate-50 border border-dashed border-slate-300 hover:border-usu-green p-4 rounded-xl transition-colors">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="ph ph-upload-simple text-2xl text-slate-400"></i>
                            <span class="text-xs text-slate-600 font-bold">Klik untuk Pilih Gambar</span>
                            <span class="text-[9px] text-slate-400">Maks. 5MB (JPG, JPEG, PNG, WEBP)</span>
                        </div>
                        <input type="file" name="images[]" id="image-input" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp" multiple>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="mt-6 pt-6 border-t border-slate-150 flex justify-end gap-4">
        <a href="{{ route('admin.information-center.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
        <button type="submit" class="btn-gold px-8 py-3 rounded-xl transition-all shadow-sm flex items-center gap-2" onclick="this.innerHTML = '<i class=\'ph ph-spinner animate-spin\'></i> Menyimpan...'; this.form.submit(); this.disabled = true;">
            <i class="ph ph-floppy-disk text-lg font-bold"></i> Perbarui Informasi
        </button>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
    // Image Preview
    const imageInput = document.getElementById('image-input');
    const previewContainer = document.getElementById('image-preview-container');

    if(imageInput) {
        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                previewContainer.classList.remove('hidden');
                
                if (this.files.length > 3) {
                    Swal.fire('Batas Upload', 'Maksimal 3 gambar yang dapat diunggah!', 'warning');
                    this.value = '';
                    previewContainer.classList.add('hidden');
                    return;
                }
                
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-24 object-cover rounded-lg border border-slate-200';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                @if($informationCenter->images)
                    let html = '';
                    @foreach($informationCenter->images as $img)
                        html += '<img src="{{ asset($img) }}" alt="Pratinjau Gambar" class="w-full h-24 object-cover rounded-lg border border-slate-200">';
                    @endforeach
                    previewContainer.innerHTML = html;
                    previewContainer.classList.remove('hidden');
                @elseif($informationCenter->image_path)
                    previewContainer.innerHTML = '<img src="{{ asset($informationCenter->image_path) }}" alt="Pratinjau Gambar" class="w-full h-24 object-cover rounded-lg border border-slate-200">';
                    previewContainer.classList.remove('hidden');
                @else
                    previewContainer.classList.add('hidden');
                @endif
            }
        });
    }



    // Dynamic Multi Action Buttons
    const container = document.getElementById('action-buttons-container');
    const btnAdd = document.getElementById('btn-add-action-button');
    let btnIndex = 0;

    function addRow(name = '', url = '', newTab = false) {
        const rowId = `row-btn-${btnIndex}`;
        const html = `
            <div id="${rowId}" class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 relative pt-7 sm:pt-4">
                <button type="button" onclick="document.getElementById('${rowId}').remove()" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rose-100 hover:bg-rose-200 text-rose-600 flex items-center justify-center border border-rose-200 text-[10px]" title="Hapus Tombol">
                    <i class="ph ph-trash"></i>
                </button>
                <div class="flex-1">
                    <p class="block text-[10px] font-black text-slate-500 mb-1">LABEL/NAMA TOMBOL</p>
                    <input type="text" name="action_buttons[${btnIndex}][name]" value="${name}" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs" placeholder="Contoh: Daftar Lomba">
                </div>
                <div class="flex-1">
                    <p class="block text-[10px] font-black text-slate-500 mb-1">LINK TAUTAN (URL)</p>
                    <input type="url" name="action_buttons[${btnIndex}][url]" value="${url}" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs" placeholder="https://google.form/...">
                </div>
                <div class="flex items-center gap-1.5 pt-2 sm:pt-4">
                    <input type="checkbox" name="action_buttons[${btnIndex}][new_tab]" value="1" ${newTab ? 'checked' : ''} id="new_tab_${btnIndex}" class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                    <label for="new_tab_${btnIndex}" class="text-[10px] font-bold text-slate-600 cursor-pointer">Buka di Tab Baru</label>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        btnIndex++;
    }

    btnAdd.addEventListener('click', () => addRow());

    // Render existing buttons from database
    @if(is_array($informationCenter->action_button_url) && count($informationCenter->action_button_url) > 0)
        @foreach($informationCenter->action_button_url as $btn)
            addRow('{!! addslashes($btn['name']) !!}', '{!! addslashes($btn['url']) !!}', {{ isset($btn['new_tab']) && $btn['new_tab'] ? 'true' : 'false' }});
        @endforeach
    @endif

    // Toggle Category Specific Fields
    const categorySelect = document.getElementById('category-select');
    const mainFormArea = document.getElementById('main-form-area');
    
    // Cards & Containers
    const customFieldsCard = document.getElementById('custom-category-fields-card');
    const customFieldsTitle = document.getElementById('custom-fields-title');
    const allSections = document.querySelectorAll('.category-fields-section');
    
    const cardTombolAksi = document.getElementById('card-tombol-aksi');
    const cardNarahubung = document.getElementById('card-narahubung');
    const publishTimeContainer = document.getElementById('publish-time-container');
    const popupOptionContainer = document.getElementById('popup-option-container');
    const cardPoster = document.getElementById('card-poster');

    // Inputs inside publish time container to toggle required attribute
    const publishStartDateInput = document.getElementById('publish_start_date_input');
    const publishStartTimeInput = document.getElementById('publish_start_time_input');

    function handleCategoryChange() {
        const val = categorySelect.value;
        
        if (!val) {
            // Sembunyikan seluruh form jika kategori kosong
            mainFormArea.classList.add('hidden');
            mainFormArea.classList.add('opacity-0');
            mainFormArea.classList.add('translate-y-4');
            return;
        }

        // Tampilkan form utama
        mainFormArea.classList.remove('hidden');
        // Trigger reflow for transition animation
        setTimeout(() => {
            mainFormArea.classList.remove('opacity-0');
            mainFormArea.classList.remove('translate-y-4');
            mainFormArea.classList.add('opacity-100');
        }, 50);
        
        // Sembunyikan semua dynamic custom fields section dulu
        if (allSections) allSections.forEach(sec => sec.classList.add('hidden'));
        if (customFieldsCard) customFieldsCard.classList.add('hidden');

        if (cardTombolAksi) cardTombolAksi.classList.remove('hidden');
        if (cardNarahubung) cardNarahubung.classList.remove('hidden');
        if (publishTimeContainer) publishTimeContainer.classList.remove('hidden');
        if (popupOptionContainer) popupOptionContainer.classList.remove('hidden');
        if (cardPoster) cardPoster.classList.remove('hidden');

        // Set inputs as required by default
        if (publishStartDateInput) publishStartDateInput.required = true;
        if (publishStartTimeInput) publishStartTimeInput.required = true;

        if (val === 'event') {
            const fieldsEvent = document.getElementById('fields-event');
            if (fieldsEvent) fieldsEvent.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-calendar text-usu-green text-lg"></i> Detail Event / Kegiatan';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
        } 
        else if (val === 'announcement') {
            // Pengumuman: form khusus pengumuman
            const fieldsAnnouncement = document.getElementById('fields-announcement');
            if (fieldsAnnouncement) fieldsAnnouncement.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-megaphone-simple text-blue-500 text-lg"></i> Detail Tambahan Pengumuman';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            
            if (cardTombolAksi) cardTombolAksi.classList.add('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        }
        else if (val === 'book_recommendation') {
            const fieldsBook = document.getElementById('fields-book_recommendation');
            if (fieldsBook) fieldsBook.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-book-open text-yellow-500 text-lg"></i> Detail Buku Rekomendasi';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            
            // Rekomendasi buku tidak butuh narahubung dan tombol aksi
            if (cardTombolAksi) cardTombolAksi.classList.add('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        }
        else if (val === 'library_news') {
            const fieldsNews = document.getElementById('fields-library_news');
            if (fieldsNews) fieldsNews.classList.remove('hidden');
            if (customFieldsTitle) customFieldsTitle.innerHTML = '<i class="ph ph-newspaper text-indigo-500 text-lg"></i> Detail Berita Perpustakaan';
            if (customFieldsCard) customFieldsCard.classList.remove('hidden');
            
            // Berita tidak butuh tombol aksi dan narahubung
            if (cardTombolAksi) cardTombolAksi.classList.add('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        }
        else if (val === 'tips') {
            // Tips: butuh Judul + Ringkasan + Trix Editor lengkap (artikel)
            // Tips tidak butuh tombol aksi, dan narahubung
            if (cardTombolAksi) cardTombolAksi.classList.add('hidden');
            if (cardNarahubung) cardNarahubung.classList.add('hidden');
        }
        
        // Helper Box Logic
        const catHelpers = {
            announcement: 'Digunakan untuk informasi resmi dari perpustakaan. Contoh: Perubahan Jam Operasional, Maintenance Sistem, Libur Nasional, Layanan Baru, dan Pengingat Pengembalian Buku.',
            event: 'Digunakan untuk menginformasikan kegiatan perpustakaan. Contoh: Workshop, Seminar, Pelatihan, Lomba, Bedah Buku, dan kegiatan lainnya.',
            book_recommendation: 'Digunakan untuk memberikan informasi atau rekomendasi mengenai koleksi buku. Contoh: Rekomendasi Buku Minggu Ini, Buku Pilihan Pustakawan, Buku Terpopuler, Buku Referensi Skripsi, dan Rekomendasi Bacaan berdasarkan tema.',
            library_news: 'Digunakan untuk berita dan dokumentasi kegiatan perpustakaan. Contoh: Dokumentasi Kegiatan, Prestasi, Kerja Sama, dan Peresmian Fasilitas Baru.',
            tips: 'Digunakan untuk memberikan panduan kepada pengguna. Contoh: Cara Meminjam Buku, Cara Menggunakan OPAC, Tips Mencari Jurnal, Panduan Akses Repository, serta FAQ.'
        };

        const helperBox = document.getElementById('category-helper-box');
        const helperDesc = document.getElementById('category-helper-desc');
        
        if (catHelpers[val]) {
            helperDesc.textContent = catHelpers[val];
            helperBox.classList.remove('hidden');
        } else {
            helperBox.classList.add('hidden');
        }
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', handleCategoryChange);
        // Jalankan saat load awal jika ada old() value
        handleCategoryChange();
    }
</script>
@endpush
