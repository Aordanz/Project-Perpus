<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Panduan lengkap penggunaan layanan pencarian, status koleksi, dan informasi perpustakaan.">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Pusat Bantuan') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        @media (min-width: 1024px) {
            .ditarik-card-center {
                grid-column-start: 2 !important;
                grid-column-end: span 1 !important;
            }
        }
        @media (min-width: 640px) and (max-width: 1023px) {
            .ditarik-card-center {
                grid-column: span 2 !important;
                max-width: 380px;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-grow">

    <!-- Header Section with Layered Green Gradients (Match Kontak Kami) -->
    <div class="relative pt-28 pb-24 lg:pt-32 lg:pb-36 overflow-hidden bg-slate-900">
        <!-- Background Image with Layered Gradients -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('kolam_perpustakaan.webp') }}" alt="Perpustakaan USU" class="w-full h-full object-cover opacity-35 scale-105 transform">
            <div class="absolute inset-0 bg-gradient-to-b from-[#064e3b]/90 via-[#064e3b]/75 to-[#f8fafc]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,108,56,0.4),transparent_50%)]"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Pill Badge (Match Kontak Kami) -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-green-100 text-xs sm:text-sm font-medium mb-6 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ __('Pusat Panduan & Informasi Pemustaka') }}</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{{ __('Pusat Bantuan') }}</h1>
            <p class="text-base sm:text-lg md:text-xl text-green-50/90 max-w-3xl mx-auto font-light leading-relaxed">
                {{ __('Panduan resmi penggunaan katalog online (OPAC), memahami status ketersediaan koleksi, hingga tata cara kunjungan Perpustakaan USU.') }}
            </p>
        </div>
    </div>

    <!-- Quick Navigation Anchor Tabs -->
    <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 mb-8">
        <div class="bg-white rounded-2xl p-2 sm:p-3 shadow-lg border border-slate-100 flex flex-wrap gap-2 justify-center text-xs sm:text-sm font-semibold">
            <a href="#bantuan-pencarian" class="px-4 py-2.5 rounded-xl bg-green-50 text-[#106c38] hover:bg-[#106c38] hover:text-white transition flex items-center gap-2">
                <i class="ph ph-magnifying-glass font-bold"></i> {{ __('Bantuan Pencarian') }}
            </a>
            <a href="#status-ketersediaan" class="px-4 py-2.5 rounded-xl bg-slate-50 text-slate-700 hover:bg-[#106c38] hover:text-white transition flex items-center gap-2">
                <i class="ph ph-info font-bold"></i> {{ __('Status & Koleksi') }}
            </a>
            <a href="#aturan-layanan" class="px-4 py-2.5 rounded-xl bg-slate-50 text-slate-700 hover:bg-[#106c38] hover:text-white transition flex items-center gap-2">
                <i class="ph ph-notebook font-bold"></i> {{ __('Aturan & Layanan') }}
            </a>
            <a href="#faq-bantuan" class="px-4 py-2.5 rounded-xl bg-slate-50 text-slate-700 hover:bg-[#106c38] hover:text-white transition flex items-center gap-2">
                <i class="ph ph-chats-circle font-bold"></i> {{ __('Pertanyaan Umum (FAQ)') }}
            </a>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-20 space-y-14 md:space-y-20">

        <!-- SECTION 1: BANTUAN PENCARIAN -->
        <div id="bantuan-pencarian" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-6 sm:p-8 md:p-10 scroll-mt-28 mb-14 md:mb-20" style="margin-bottom: 4rem;">
            <div class="flex items-center gap-3 sm:gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100">
                    <i class="ph ph-magnifying-glass text-2xl font-bold"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">{{ __('Bantuan Pencarian OPAC') }}</h2>
                    <p class="text-slate-500 mt-0.5 text-sm">{{ __('Pelajari metode pencarian untuk menemukan koleksi dengan cepat dan akurat') }}</p>
                </div>
            </div>

            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                {{ __('Ada 2 metode pencarian utama yang dapat Anda gunakan di katalog OPAC Perpustakaan USU. Pilihlah metode yang paling sesuai dengan kebutuhan informasi Anda.') }}
            </p>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Pencarian Sederhana -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-green-200 transition-colors flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#106c38] group-hover:scale-110 transition-transform">
                            <i class="ph ph-cursor-click text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2 flex items-center gap-2">
                            {{ __('1. Pencarian Sederhana') }}
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            {{ __('Metode paling cepat pada OPAC. Anda dapat langsung memasukkan kata kunci apapun, baik judul buku, nama pengarang, maupun subjek umum pada kolom pencarian utama.') }}
                        </p>
                    </div>
                    <div class="mt-4 p-3.5 bg-white rounded-xl border border-slate-200/80 text-xs text-slate-600">
                        <i class="ph ph-lightbulb text-amber-500 text-sm mr-1.5"></i><strong>{{ __('Tips:') }}</strong> {{ __('Ketikkan minimal 3 karakter atau lebih dari satu kata untuk mempersempit hasil pencarian.') }}
                    </div>
                </div>

                <!-- Pencarian Spesifik -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-green-200 transition-colors flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center mb-4 text-[#106c38] group-hover:scale-110 transition-transform">
                            <i class="ph ph-funnel text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2 flex items-center gap-2">
                            {{ __('2. Pencarian Spesifik') }}
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            {{ __('Memungkinkan Anda menyaring pencarian berdasarkan kolom spesifik seperti Judul, Pengarang, Subjek, ISBN/ISSN, hingga memilih lokasi perpustakaan cabang.') }}
                        </p>
                    </div>
                    <div class="mt-4 p-3.5 bg-white rounded-xl border border-slate-200/80 text-xs text-slate-600">
                        <i class="ph ph-map-pin text-[#106c38] text-sm mr-1.5"></i><strong>{{ __('Filter Lokasi:') }}</strong> {{ __('Gunakan filter lokasi untuk memastikan buku fisik tersedia di perpustakaan pusat atau fakultas Anda.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: STATUS & KOLEKSI -->
        <div id="status-ketersediaan" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-6 sm:p-8 md:p-10 scroll-mt-28 mb-14 md:mb-20" style="margin-bottom: 4rem;">
            <div class="flex items-center gap-3 sm:gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100">
                    <i class="ph ph-info text-2xl font-bold"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">{{ __('Memahami Status & Kode Eksemplar') }}</h2>
                    <p class="text-slate-500 mt-0.5 text-sm">{{ __('Panduan arti kode tipe koleksi dan status ketersediaan fisik buku') }}</p>
                </div>
            </div>

            <!-- Tipe Koleksi Badges Guide -->
            <div class="mb-8">
                <h3 class="text-base font-extrabold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="ph ph-tag text-[#106c38]"></i> {{ __('Tipe Koleksi (Jangka Waktu Pinjam)') }}
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="font-extrabold text-xs bg-[#106c38] text-white px-2.5 py-1 rounded-md font-mono shrink-0 shadow-sm">STD</span>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Standard') }}</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ __('Koleksi sirkulasi umum yang memiliki jangka waktu pinjam normal (dapat dipinjam pulang).') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="font-extrabold text-xs bg-amber-500 text-white px-2.5 py-1 rounded-md font-mono shrink-0 shadow-sm">KPS</span>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Koleksi Pinjam Singkat') }}</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ __('Koleksi dengan permintaan tinggi atau terbatas yang memiliki durasi peminjaman lebih singkat.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Eksemplar Table / Grid -->
            <div>
                <h3 class="text-base font-extrabold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="ph ph-check-circle text-[#106c38]"></i> {{ __('Arti Status Ketersediaan Fisik') }}
                </h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3.5 items-stretch">
                    <!-- Tersedia -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #ecfdf5; border: 1px solid #a7f3d0;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 bg-emerald-600 text-white font-extrabold px-2.5 py-1 rounded-full text-xs shadow-sm">
                                🟢 {{ __('Tersedia') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold text-emerald-900 bg-white px-1.5 py-0.5 rounded border border-emerald-300">{{ __('Kode') }}: TSD</span>
                        </div>
                        <span class="text-xs text-emerald-950 font-medium leading-snug flex-1">{{ __('Buku ada di rak & siap dipinjam / dibaca.') }}</span>
                    </div>

                    <!-- Dipinjam -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #fefce8; border: 1px solid #fef08a;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 bg-amber-500 text-white font-extrabold px-2.5 py-1 rounded-full text-xs shadow-sm">
                                🟡 {{ __('Dipinjam') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold text-amber-900 bg-white px-1.5 py-0.5 rounded border border-amber-300">{{ __('Kode') }}: PJM</span>
                        </div>
                        <span class="text-xs text-amber-950 font-medium leading-snug flex-1">{{ __('Buku sedang dipinjam oleh pemustaka lain.') }}</span>
                    </div>

                    <!-- Baca di Tempat -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #eff6ff; border: 1px solid #bfdbfe;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 bg-blue-600 text-white font-extrabold px-2 py-1 rounded-full text-[11px] shadow-sm">
                                📖 {{ __('Baca di Tempat') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold text-blue-900 bg-white px-1.5 py-0.5 rounded border border-blue-300">{{ __('Kode') }}: R / NL</span>
                        </div>
                        <span class="text-xs text-blue-950 font-medium leading-snug flex-1">{{ __('Koleksi khusus (Referensi/Non-Lending) dibaca di tempat.') }}</span>
                    </div>

                    <!-- Hilang -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #fff1f2; border: 1px solid #fecdd3;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 bg-rose-600 text-white font-extrabold px-2.5 py-1 rounded-full text-xs shadow-sm">
                                🔴 {{ __('Hilang') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold text-rose-900 bg-white px-1.5 py-0.5 rounded border border-rose-300">Missing (MIS)</span>
                        </div>
                        <span class="text-xs text-rose-950 font-medium leading-snug flex-1">{{ __('Eksemplar dinyatakan hilang atau dalam klarifikasi.') }}</span>
                    </div>

                    <!-- Rusak -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #fff7ed; border: 1px solid #ffedd5;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 text-white font-extrabold px-2.5 py-1 rounded-full text-xs shadow-sm" style="background-color: #ea580c;">
                                ⚠️ {{ __('Rusak') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold px-1.5 py-0.5 rounded" style="color: #9a3412; background-color: #ffffff; border: 1px solid #fdba74;">{{ __('Kode') }}: RSK</span>
                        </div>
                        <span class="text-xs text-orange-950 font-semibold leading-snug flex-1">{{ __('Eksemplar mengalami kerusakan fisik dan sedang ditangani.') }}</span>
                    </div>

                    <!-- Sedang Dijilid -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px]" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 bg-slate-700 text-white font-extrabold px-2 py-1 rounded-full text-[11px] shadow-sm">
                                🔧 {{ __('Sedang Dijilid') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold text-slate-800 bg-white px-1.5 py-0.5 rounded border border-slate-300">{{ __('Kode') }}: JLD</span>
                        </div>
                        <span class="text-xs text-slate-800 font-medium leading-snug flex-1">{{ __('Buku dalam proses pemeliharaan / penjilidan ulang.') }}</span>
                    </div>

                    <!-- Ditarik (Weeded) -> Berada di dalam grid 3 kolom utama, dipaksa di tengah (kolom 2) -->
                    <div class="p-3.5 rounded-2xl flex items-center gap-3.5 h-[105px] ditarik-card-center transition-all" style="background-color: #f3e8ff; border: 1px solid #d8b4fe;">
                        <div class="w-[125px] shrink-0 flex flex-col items-start gap-1">
                            <span class="w-full inline-flex items-center justify-center gap-1 text-white font-extrabold px-2.5 py-1 rounded-full text-xs shadow-sm" style="background-color: #7e22ce;">
                                📦 {{ __('Ditarik') }}
                            </span>
                            <span class="w-full text-center text-[9.5px] font-mono font-extrabold px-1.5 py-0.5 rounded" style="color: #6b21a8; background-color: #ffffff; border: 1px solid #c084fc;">Weeded (WED)</span>
                        </div>
                        <span class="text-xs text-purple-950 font-semibold leading-snug flex-1">{{ __('Buku diarsipkan atau ditarik dari sirkulasi aktif.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: KETENTUAN & PROSEDUR PEMINJAMAN BUKU -->
        <div id="aturan-layanan" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-6 sm:p-8 md:p-10 scroll-mt-28 mb-14 md:mb-20" style="margin-bottom: 4rem;">
            <div class="flex items-center gap-3 sm:gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100">
                    <i class="ph ph-notebook text-2xl font-bold"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">{{ __('Ketentuan & Prosedur Peminjaman') }}</h2>
                    <p class="text-slate-500 mt-0.5 text-sm">{{ __('Panduan hak, batas kuota, durasi pinjam, dan tata tertib pemustaka') }}</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Syarat & Kuota Peminjaman -->
                <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-100 space-y-3.5">
                    <h3 class="font-bold text-[#106c38] text-sm flex items-center gap-2">
                        <i class="ph ph-cardholder text-lg text-[#106c38]"></i> {{ __('1. Syarat & Kuota Pinjam Koleksi') }}
                    </h3>
                    <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-[#106c38] text-sm shrink-0 mt-0.5"></i>
                            <span>{{ __('Wajib membawa Kartu Tanda Mahasiswa (KTM) / Kartu Anggota Aktif saat bertransaksi di meja sirkulasi.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-[#106c38] text-sm shrink-0 mt-0.5"></i>
                            <span><strong>{{ __('Koleksi Standard (STD):') }}</strong> {{ __('Maksimal 3 - 5 eksemplar dengan durasi pinjam selama 7 hari kalender.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-[#106c38] text-sm shrink-0 mt-0.5"></i>
                            <span><strong>{{ __('Koleksi Pinjam Singkat (KPS):') }}</strong> {{ __('Maksimal 1 - 2 eksemplar dengan durasi pinjam 3 hari.') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Perpanjangan & Sanksi Keterlambatan -->
                <div class="bg-emerald-50/50 rounded-2xl p-5 border border-emerald-100 space-y-3.5">
                    <h3 class="font-bold text-[#106c38] text-sm flex items-center gap-2">
                        <i class="ph ph-arrows-clockwise text-lg text-[#106c38]"></i> {{ __('2. Perpanjangan & Sanksi Keterlambatan') }}
                    </h3>
                    <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <i class="ph ph-arrow-right text-[#106c38] text-sm shrink-0 mt-0.5"></i>
                            <span><strong>{{ __('Perpanjangan (Renewal):') }}</strong> {{ __('Dapat dilakukan 1x perpanjangan sebelum tanggal jatuh tempo, selama buku tidak di-pesan pemustaka lain.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-warning-circle text-amber-600 text-sm shrink-0 mt-0.5"></i>
                            <span><strong>{{ __('Keterlambatan Pengembalian:') }}</strong> {{ __('Dikenakan sanksi denda keterlambatan per hari sesuai dengan Peraturan Perpustakaan USU yang berlaku.') }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-certificate text-emerald-700 text-sm shrink-0 mt-0.5"></i>
                            <span><strong>{{ __('Bebas Pustaka:') }}</strong> {{ __('Persyaratan wisuda / kelulusan memerlukan pengembalian seluruh koleksi pinjaman terlebih dahulu.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- SECTION 4: FAQ & KONTAK BANTUAN -->
        <div id="faq-bantuan" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-6 sm:p-8 md:p-10 scroll-mt-28">
            <div class="flex items-center gap-3 sm:gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100">
                    <i class="ph ph-chats-circle text-2xl font-bold"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">{{ __('Pertanyaan Sering Diajukan (FAQ)') }}</h2>
                    <p class="text-slate-500 mt-0.5 text-sm">{{ __('Jawaban cepat untuk pertanyaan yang umum ditanyakan pemustaka') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base mb-1.5 flex items-center gap-2">
                        <i class="ph ph-question text-[#106c38] font-bold"></i> {{ __('Siapa saja yang bisa meminjam buku di Perpustakaan USU?') }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                        {{ __('Seluruh mahasiswa aktif, dosen, dan tenaga kependidikan Universitas Sumatera Utara yang terdaftar serta memiliki Kartu Tanda Mahasiswa (KTM) / Kartu Anggota Perpustakaan yang aktif.') }}
                    </p>
                </div>

                <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base mb-1.5 flex items-center gap-2">
                        <i class="ph ph-question text-[#106c38] font-bold"></i> {{ __('Bagaimana jika buku yang saya cari berstatus "Dipinjam"?') }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                        {{ __('Anda dapat mengecek estimasi tanggal pengembalian melalui layanan informasi di meja sirkulasi atau menghubungi pustakawan kami via WhatsApp / Telepon di halaman Kontak Kami.') }}
                    </p>
                </div>

                <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base mb-1.5 flex items-center gap-2">
                        <i class="ph ph-question text-[#106c38] font-bold"></i> {{ __('Apakah saya bisa bertanya langsung ke Asisten AI Virtual?') }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-6">
                        {{ __('Bisa! Anda dapat menggunakan tombol Asisten AI (ikon obrolan kuning) di pojok kanan bawah layar untuk bertanya seputar jam buka, lokasi koleksi, dan panduan umum secara otomatis 24/7.') }}
                    </p>
                </div>
            </div>

            <!-- Call to action -->
            <div class="mt-8 bg-gradient-to-r from-[#064e3b] to-[#106c38] rounded-2xl p-6 sm:p-8 text-center text-white shadow-lg relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                
                <h3 class="text-xl sm:text-2xl font-bold mb-2 relative z-10">{{ __('Masih Butuh Bantuan Lain?') }}</h3>
                <p class="text-xs sm:text-sm text-green-100 mb-5 relative z-10">{{ __('Tim pustakawan kami siap membantu kebutuhan referensi & informasi Anda.') }}</p>
                <div class="flex flex-wrap justify-center gap-3 relative z-10">
                    <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-white text-[#106c38] px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold hover:bg-green-50 transition shadow-md">
                        <i class="ph ph-envelope-simple text-base"></i> {{ __('Hubungi Pustakawan') }}
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white/15 text-white border border-white/30 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold hover:bg-white/25 transition">
                        <i class="ph ph-house text-base"></i> {{ __('Kembali ke Beranda') }}
                    </a>
                </div>
            </div>

        </div>

    </div>

    </main>

    @include('partials.footer')

</body>
</html>
