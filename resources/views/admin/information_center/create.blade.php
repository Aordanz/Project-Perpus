@extends('admin.information_center.layout')

@section('title', 'Tambah Informasi Baru')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
        trix-editor {
            min-height: 250px;
            background: white;
        }
    </style>
@endpush

@section('content')
<!-- Header Area -->
<div class="flex items-center gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm mb-6">
    <a href="{{ route('admin.information-center.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors">
        <i class="ph ph-arrow-left text-xl"></i>
    </a>
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Buat Informasi Baru</h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Publikasikan event, pengumuman, tips, dan pemeliharaan untuk pengguna perpustakaan.</p>
    </div>
</div>

<form action="{{ route('admin.information-center.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- CARD 0: PILIH KATEGORI TERLEBIH DAHULU -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-6">
        <label class="block text-sm font-bold text-slate-800 uppercase mb-3 flex items-center gap-2">
            <i class="ph ph-tag text-usu-green text-xl animate-bounce"></i> Langkah 1: Pilih Kategori Informasi Terlebih Dahulu <span class="text-red-500">*</span>
        </label>
        <select name="category" id="category-select" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all cursor-pointer">
            <option value="">-- Silakan Pilih Kategori Informasi --</option>
            <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event / Kegiatan</option>
            <option value="announcement" {{ old('category') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan Server / Gedung (Maintenance)</option>
            <option value="new_collection" {{ old('category') == 'new_collection' ? 'selected' : '' }}>Buku / Koleksi Baru</option>
            <option value="tips" {{ old('category') == 'tips' ? 'selected' : '' }}>Tips & Trik</option>
            <option value="promotion" {{ old('category') == 'promotion' ? 'selected' : '' }}>Promo / Penawaran khusus</option>
            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Informasi Umum</option>
        </select>
    </div>

    <!-- AREA FORM UTAMA (Akan di-toggle show/hide via JS) -->
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
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Judul Informasi / Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all" placeholder="Contoh: Pemeliharaan Server Web Perpustakaan...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Ringkasan Singkat (Penjelasan Singkat di Halaman Depan)</label>
                        <textarea name="summary" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all" placeholder="Tuliskan ringkasan 1-2 kalimat untuk mempermudah pembaca..."></textarea>
                    </div>

                    <div id="trix-editor-container">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Isi Informasi Lengkap</label>
                        <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                        <trix-editor input="content" class="rounded-xl border-slate-200 bg-slate-50"></trix-editor>
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
                                <label class="block text-xs font-bold text-slate-700 mb-2">Waktu Kegiatan <span class="text-red-500">*</span></label>
                                <input type="text" name="event_time" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 09.00 - 12.00 WIB" value="09.00 - 12.00 WIB">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                                <input type="text" name="event_location" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Ruang Seminar Lantai 3" value="Gedung UPT Perpustakaan USU">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Penyelenggara</label>
                                <input type="text" name="event_organizer" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: UPT Perpustakaan USU" value="UPT Perpustakaan Universitas Sumatera Utara">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Sasaran Peserta</label>
                                <input type="text" name="event_participants" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Mahasiswa & Umum" value="Civitas Akademika USU & Umum">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Fasilitas Acara</label>
                                <input type="text" name="event_facilities" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: E-Sertifikat, Snack" value="Ilmu Bermanfaat, E-Sertifikat">
                            </div>
                        </div>
                        <div class="border-t border-slate-100 pt-4 mt-2">
                            <h4 class="text-xs font-black text-slate-700 uppercase mb-3">Tampilan Brosur Kiri (Flyer Slider)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-2">Label Badge Flyer</label>
                                    <input type="text" name="event_left_badge" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Contoh: EVENT PERPUSTAKAAN" value="EVENT PERPUSTAKAAN">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-2">Judul Besar Flyer (Kiri)</label>
                                    <input type="text" name="event_left_title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Kosongkan untuk samakan judul">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-2">Subjudul Flyer (Kiri)</label>
                                    <input type="text" name="event_left_subtitle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Teks singkat penarik minat">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-2">Stiker / Quota Tag</label>
                                    <input type="text" name="event_quota_tag" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Contoh: PENDAFTARAN DIBUKA!<br>Kuota Terbatas!" value="PENDAFTARAN DIBUKA!<br>Jangan sampai ketinggalan!">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 mb-2">Fitur / Benefit Flyer (Tulis 1 poin per baris, maks 4 baris)</label>
                                    <textarea name="event_left_features" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Materi Praktis&#10;Studi Kasus Nyata&#10;E-Sertifikat&#10;Doorprize Menarik">Materi Praktis
Studi Kasus Nyata
E-Sertifikat
Doorprize Menarik</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pemeliharaan / Maintenance Fields -->
                    <div id="fields-maintenance" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Layanan yang Terdampak <span class="text-red-500">*</span></label>
                                <input type="text" name="maintenance_services" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Website OPAC, Aplikasi Mobile Perpustakaan">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Perkiraan Durasi / Selesai</label>
                                <input type="text" name="maintenance_downtime" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 2 Jam (12.00 - 14.00 WIB) atau Selesai Gedung Dibersihkan">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Link / Solusi Alternatif (Pengalihan Jika Ada)</label>
                            <input type="url" name="maintenance_alternative" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: https://alternative-opac.usu.ac.id">
                        </div>
                    </div>

                    <!-- Buku / Koleksi Baru Fields -->
                    <div id="fields-new_collection" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Judul Buku / Koleksi <span class="text-red-500">*</span></label>
                                <input type="text" name="book_title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Algoritma & Pemrograman">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Penulis / Pencipta <span class="text-red-500">*</span></label>
                                <input type="text" name="book_author" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Prof. Dr. Budi Luhur">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Penerbit & Tahun Terbit</label>
                                <input type="text" name="book_publisher" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Erlangga, 2024">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Lokasi Rak / Klasifikasi Buku</label>
                                <input type="text" name="shelf_location" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Rak 4B - Umum atau Klasifikasi DDC 005.1">
                            </div>
                        </div>
                    </div>

                    <!-- Promo / Penawaran Khusus Fields -->
                    <div id="fields-promotion" class="category-fields-section hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Periode Promo <span class="text-red-500">*</span></label>
                                <input type="text" name="promo_period" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 1 - 31 Agustus 2026">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Benefit / Hadiah Promo <span class="text-red-500">*</span></label>
                                <input type="text" name="promo_benefit" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Bebas Denda Keterlambatan atau Akses Jurnal Gratis">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nama Kontak</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Ibu Mawar Harahap">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 08123456789">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: mawar@usu.ac.id">
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
                        <label class="block text-xs font-bold text-slate-700 mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draf (Disimpan Dulu)</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : 'selected' }}>Diterbitkan (Langsung Tayang)</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan (Dihilangkan Dari Web)</option>
                        </select>
                    </div>

                    <!-- Pemisahan Tanggal dan Jam agar Mudah Di-Klik Orang Tua -->
                    <div id="publish-time-container" class="space-y-4 border-t border-slate-100 pt-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Waktu Mulai Tayang <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Tanggal Mulai</span>
                                    <input type="date" name="publish_start_date" id="publish_start_date_input" value="{{ old('publish_start_date', date('Y-m-d')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Jam Mulai</span>
                                    <input type="time" name="publish_start_time" id="publish_start_time_input" value="{{ old('publish_start_time', '08:00') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Waktu Selesai Tayang (Opsional)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Tanggal Selesai</span>
                                    <input type="date" name="publish_end_date" value="{{ old('publish_end_date') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-500 mb-1">Jam Selesai</span>
                                    <input type="time" name="publish_end_time" value="{{ old('publish_end_time') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
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
                            <input type="checkbox" name="show_popup" value="1" {{ old('show_popup') ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Tampilkan Popup</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan langsung **muncul melayang** sebagai iklan/pengumuman di layar depan pengunjung saat pertama kali membuka website perpustakaan.</span>
                        
                        <div class="mt-2.5 pt-2.5 border-t border-slate-200/60">
                            <label class="block text-[10px] font-bold text-slate-700 mb-1 uppercase">Prioritas Popup (Urutan Keutamaan)</label>
                            <input type="number" name="popup_priority" value="{{ old('popup_priority', 1) }}" min="1" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs">
                            <span class="text-[9px] text-slate-400 mt-1 block">Angka lebih tinggi (misal: 5) akan diutamakan muncul di atas angka rendah (misal: 1) jika ada lebih dari satu popup aktif bersamaan.</span>
                        </div>
                    </div>

                    <!-- Navbar -->
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-150">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_navbar" value="1" {{ old('show_navbar') ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Tampilkan di Navbar</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan muncul di menu **Pusat Informasi** pada bar navigasi atas website, memudahkan pengunjung mencarinya kembali.</span>
                    </div>

                    <!-- Featured -->
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-150">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300 text-usu-green focus:ring-usu-green">
                            <span class="text-sm font-bold text-slate-800">Sorotan / Highlight</span>
                        </label>
                        <span class="text-[10px] text-slate-500 mt-1 block">Jika dicentang, informasi ini akan menjadi sorotan utama perpustakaan dan ditampilkan secara khusus.</span>
                    </div>
                    
                    <!-- Sort Order -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan Pengurutan (Sort Order)</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
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
                    <img id="image-preview" src="#" alt="Pratinjau Gambar" class="hidden w-full h-auto rounded-xl object-cover border border-slate-200 mb-4">
                    
                    <label class="block w-full cursor-pointer bg-slate-50 border border-dashed border-slate-300 hover:border-usu-green p-4 rounded-xl transition-colors">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="ph ph-upload-simple text-2xl text-slate-400"></i>
                            <span class="text-xs text-slate-600 font-bold">Klik untuk Pilih Gambar</span>
                            <span class="text-[9px] text-slate-400">Maks. 5MB (JPG, JPEG, PNG, WEBP)</span>
                        </div>
                        <input type="file" name="image_path" id="image-input" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp">
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="mt-6 pt-6 border-t border-slate-150 flex justify-end gap-4">
        <a href="{{ route('admin.information-center.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
        <button type="submit" class="btn-gold px-8 py-3 rounded-xl transition-all shadow-sm flex items-center gap-2" onclick="this.innerHTML = '<i class=\'ph ph-spinner animate-spin\'></i> Menyimpan...'; this.form.submit(); this.disabled = true;">
            <i class="ph ph-floppy-disk text-lg font-bold"></i> Simpan Informasi
        </button>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    // Image Preview
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');

    if(imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
                imagePreview.src = '#';
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
                    <label class="block text-[10px] font-black text-slate-500 mb-1">LABEL/NAMA TOMBOL</label>
                    <input type="text" name="action_buttons[${btnIndex}][name]" value="${name}" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs" placeholder="Contoh: Daftar Lomba">
                </div>
                <div class="flex-1">
                    <label class="block text-[10px] font-black text-slate-500 mb-1">LINK TAUTAN (URL)</label>
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

    // Toggle Category Specific Fields
    const categorySelect = document.getElementById('category-select');
    const mainFormArea = document.getElementById('main-form-area');
    
    // Cards & Containers
    const customFieldsCard = document.getElementById('custom-category-fields-card');
    const customFieldsTitle = document.getElementById('custom-fields-title');
    const allSections = document.querySelectorAll('.category-fields-section');
    
    const trixEditorContainer = document.getElementById('trix-editor-container');
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
        allSections.forEach(sec => sec.classList.add('hidden'));
        customFieldsCard.classList.add('hidden');

        // Reset default visibility for standard elements
        trixEditorContainer.classList.remove('hidden');
        cardTombolAksi.classList.remove('hidden');
        cardNarahubung.classList.remove('hidden');
        publishTimeContainer.classList.remove('hidden');
        popupOptionContainer.classList.remove('hidden');
        cardPoster.classList.remove('hidden');

        // Set inputs as required by default
        if (publishStartDateInput) publishStartDateInput.required = true;
        if (publishStartTimeInput) publishStartTimeInput.required = true;

        if (val === 'event') {
            document.getElementById('fields-event').classList.remove('hidden');
            customFieldsTitle.innerHTML = '<i class="ph ph-calendar text-usu-green text-lg"></i> Detail Event / Kegiatan';
            customFieldsCard.classList.remove('hidden');
        } 
        else if (val === 'announcement') {
            // Pengumuman: tidak perlu kustom field tambahan, tapi kontak dan tombol aksi tetap tampil
        }
        else if (val === 'maintenance') {
            document.getElementById('fields-maintenance').classList.remove('hidden');
            customFieldsTitle.innerHTML = '<i class="ph ph-wrench text-usu-green text-lg"></i> Detail Pemeliharaan (Maintenance)';
            customFieldsCard.classList.remove('hidden');
            
            // Maintenance tidak butuh trix editor artikel panjang, poster, narahubung, atau tombol aksi
            trixEditorContainer.classList.add('hidden');
            cardPoster.classList.add('hidden');
            cardNarahubung.classList.add('hidden');
            cardTombolAksi.classList.add('hidden');
        } 
        else if (val === 'new_collection') {
            document.getElementById('fields-new_collection').classList.remove('hidden');
            customFieldsTitle.innerHTML = '<i class="ph ph-book-open text-usu-green text-lg"></i> Detail Koleksi Buku Baru';
            customFieldsCard.classList.remove('hidden');
            
            // Koleksi baru tidak butuh trix editor, tombol aksi, dan narahubung
            trixEditorContainer.classList.add('hidden');
            cardTombolAksi.classList.add('hidden');
            cardNarahubung.classList.add('hidden');
        } 
        else if (val === 'tips') {
            // Tips: butuh Judul + Ringkasan + Trix Editor lengkap (artikel)
            // Tips tidak butuh tombol aksi, dan narahubung
            cardTombolAksi.classList.add('hidden');
            cardNarahubung.classList.add('hidden');
        }
        else if (val === 'promotion') {
            document.getElementById('fields-promotion').classList.remove('hidden');
            customFieldsTitle.innerHTML = '<i class="ph ph-tag text-usu-green text-lg"></i> Detail Promo / Penawaran Khusus';
            customFieldsCard.classList.remove('hidden');
            
            // Promo tidak butuh trix editor (cukup ringkasan & detail kustom saja)
            trixEditorContainer.classList.add('hidden');
        }
        else if (val === 'general') {
            // Umum: butuh Judul + Ringkasan + Trix Editor lengkap
            // Tidak butuh tombol aksi, dan narahubung
            cardTombolAksi.classList.add('hidden');
            cardNarahubung.classList.add('hidden');
        }
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', handleCategoryChange);
        // Jalankan saat load awal jika ada old() value
        handleCategoryChange();
    }
</script>
@endpush
