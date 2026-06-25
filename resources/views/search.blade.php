<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Hasil Pencarian') }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8fafc;
        }
        body, input, select, button, textarea {
            font-family: 'Inter', sans-serif !important;
        }
        .btn-cari {
            background-color: #106c38 !important;
            color: #ffffff !important;
        }
        .btn-cari:hover {
            background-color: #0b4b27 !important;
        }
        .btn-spesifik {
            background-color: #059669 !important;
            color: #ffffff !important;
            border-color: rgba(16, 185, 129, 0.35) !important;
        }
        .btn-spesifik:hover {
            background-color: #047857 !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .result-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05), 0 8px 8px -5px rgba(0, 0, 0, 0.02);
            border-color: #106c38/30;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <nav class="glass-nav sticky top-0 z-40 w-full transition-all">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-6">
                <!-- USU Logo & Name -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('logousu.jpeg') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-white p-0.5 object-cover shadow-sm">
                        <div class="flex flex-col hidden sm:flex">
                            <span class="font-bold text-white leading-none text-xs sm:text-sm group-hover:text-green-200 transition">{{ __('Universitas') }}</span>
                            <span class="font-bold text-white leading-none text-xs sm:text-sm group-hover:text-green-200 transition">{{ __('Sumatera Utara') }}</span>
                        </div>
                    </a>
                </div>
                
                <div></div> <!-- Empty right section -->
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Back to Home Link (Below Navbar) -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10">
                <i class="ph ph-arrow-left"></i> {{ __('Kembali ke Beranda') }}
            </a>
        </div>
        
        <!-- Search Header Banner with Background Image -->
        <div class="relative bg-gradient-to-br from-[#064e3b] to-[#106c38] rounded-3xl p-6 sm:p-10 mb-8 overflow-hidden text-white shadow-lg">
            <!-- Background Image with Low Opacity -->
            <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-35" style="background-image: url('{{ asset('kolam_perpustakaan.jpg') }}');"></div>
            
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">{{ __('Hasil Pencarian Katalog') }}</h1>
                <p class="text-sm text-green-100/90 mb-6 max-w-xl">{{ __('Jelajahi dan temukan koleksi buku referensi, jurnal, atau skripsi untuk kebutuhan riset Anda.') }}</p>
                
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20">
                    <div class="flex-grow relative flex items-center bg-white rounded-xl border border-transparent overflow-hidden focus-within:ring-2 focus-within:ring-[#106c38]/20 transition-all">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari buku, jurnal, penulis, atau kata kunci...') }}" class="w-full pl-11 pr-4 py-3 bg-transparent border-0 focus:ring-0 focus:border-0 outline-none text-slate-800 placeholder-slate-400 text-sm font-medium">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-cari bg-[#106c38] hover:bg-green-800 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow-md flex items-center justify-center gap-1.5 flex-grow md:flex-none cursor-pointer">
                            <i class="ph ph-magnifying-glass"></i> {{ __('Cari') }}
                        </button>
                        <button type="button" id="open-modal-pencarian-spesifik" class="btn-spesifik bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition border border-emerald-500/35 flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="ph ph-sliders-horizontal"></i> {{ __('Spesifik') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Summary -->
        @php
            $activeFilters = array_filter(request()->only(['q', 'inJudul', 'inPengarang1', 'inPenerbit', 'inSubyek', 'intahunterbit', 'inisbn', 'inKlasifikasi', 'inbarcode', 'inLokasi', 'inJenis']), function($value) {
                return !is_null($value) && trim($value) !== '';
            });
            $hasFilters = count($activeFilters) > 0;
        @endphp
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">
                @if($hasFilters)
                    {{ __('Hasil Pencarian') }} ({{ $books->total() }} {{ __('Koleksi Ditemukan') }})
                @else
                    {{ __('Semua Koleksi') }} ({{ $books->total() }} {{ __('Koleksi') }})
                @endif
            </h2>
            
            <!-- Clear Filters -->
            @if($hasFilters)
                <a href="{{ route('search') }}" class="text-xs font-bold text-red-600 hover:text-red-800 transition flex items-center gap-1">
                    <i class="ph ph-trash"></i> {{ __('Bersihkan Filter') }}
                </a>
            @endif
        </div>

        <!-- Results List -->
        <div class="space-y-4 mb-8">
            @forelse($books as $book)
                <div class="result-card bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 flex gap-5 sm:gap-6 items-start shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group">
                    <!-- Book Cover -->
                    <div class="w-24 sm:w-28 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-2">
                                <i class="ph ph-book-open text-3xl mb-1.5"></i>
                                <span class="text-[9px] font-bold text-center leading-tight">NO COVER</span>
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 bg-[#106c38] text-white text-[8px] font-bold px-1.5 py-0.5 rounded shadow">
                            {{ strtoupper($book->type) }}
                        </span>
                    </div>

                    <!-- Book Details -->
                    <div class="flex-grow flex flex-col h-full">
                        <div class="mb-2">
                            <!-- Category Badge -->
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 tracking-wider uppercase">
                                {{ $book->category ?: 'GENERAL' }}
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 hover:text-[#106c38] hover:underline transition leading-snug">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                            </h3>
                        </div>

                        <!-- Author & Code -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mb-4 text-xs font-medium text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-user text-sm text-slate-400"></i>
                                <span>{{ __('Pengarang:') }} <strong class="text-slate-700">{{ $book->author }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-hash text-sm text-slate-400"></i>
                                <span>{{ __('No. Klasifikasi:') }} <strong class="text-slate-700">{{ $book->classification }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-buildings text-sm text-slate-400"></i>
                                <span>{{ __('Penerbit:') }} <strong class="text-slate-700">{{ $book->publisher ?: '-' }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar text-sm text-slate-400"></i>
                                <span>{{ __('Tahun Terbit:') }} <strong class="text-slate-700">{{ $book->publish_year ?: '-' }}</strong></span>
                            </div>
                        </div>

                        <!-- Availability Pill -->
                        <div class="mt-auto pt-3 border-t border-slate-50 flex flex-wrap gap-2 items-center justify-between text-xs">
                            <div class="flex items-center gap-1.5 text-slate-400">
                                <i class="ph ph-map-pin text-sm text-[#106c38]"></i>
                                <span class="font-medium text-slate-500">
                                    {{ __('Penyimpanan:') }} 
                                    @php
                                        $locNames = $book->items->map(function($i) { return __($i->location->name); })->unique();
                                    @endphp
                                    <strong class="text-slate-700">{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}</strong>
                                </span>
                            </div>
                            
                            <!-- Available count -->
                            @php
                                $totalCopies = $book->items->count();
                                $availableCopies = $book->items->where('status', 'Tersedia')->count();
                            @endphp
                            <div class="flex items-center gap-1">
                                @if($availableCopies > 0)
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 font-bold px-2.5 py-0.5 rounded-full border border-green-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        {{ $availableCopies }} / {{ $totalCopies }} {{ __('Eksemplar') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 font-bold px-2.5 py-0.5 rounded-full border border-red-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        {{ __('Semua Salinan Dipinjam') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                        <i class="ph ph-warning-circle"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __('Koleksi Tidak Ditemukan') }}</h3>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                        {{ __('Maaf, kami tidak dapat menemukan buku atau referensi yang Anda cari. Coba ubah kata kunci Anda atau gunakan pencarian spesifik.') }}
                    </p>
                    <button id="open-modal-pencarian-spesifik-empty" class="bg-[#106c38] hover:bg-green-800 text-white font-semibold text-sm px-6 py-3 rounded-2xl transition shadow-md shadow-green-950/10 flex items-center gap-1.5 mx-auto">
                        <i class="ph ph-sliders-horizontal"></i> {{ __('Buka Pencarian Spesifik') }}
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $books->links() }}
        </div>

    </main>

    @include('partials.footer')

    <!-- Advanced Search Modal -->
    <div id="modal-pencarian-spesifik" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/65 backdrop-blur-md p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-emerald-800/10 transform transition-all duration-200 scale-95 opacity-0" id="modal-content">
            <!-- Modal Header Banner -->
            <div class="bg-gradient-to-br from-[#064e3b] to-[#106c38] px-6 py-6 text-white relative rounded-t-3xl">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl shadow-inner">
                        <i class="ph ph-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold tracking-wide">{{ __('Pencarian Spesifik') }}</h3>
                        <p class="text-xs text-green-100/90 font-medium font-sans">{{ __('Temukan buku, skripsi, dan jurnal untuk tugas kuliahmu dengan cepat!') }}</p>
                    </div>
                </div>
                <button id="close-modal-pencarian-spesifik" class="absolute top-6 right-6 text-white/80 hover:text-white transition-all hover:scale-105 focus:outline-none bg-white/10 hover:bg-white/20 p-2 rounded-xl flex items-center justify-center">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form action="{{ route('search') }}" method="GET" class="p-6 md:p-8 space-y-6">
                <!-- Section 1: Detail Bibliografi -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                        <i class="ph ph-info text-sm text-[#106c38]"></i> {{ __('Detail Bibliografi') }}
                    </h4>
                    
                    <!-- Judul -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Judul') }}</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-book-open text-xl"></i>
                            </div>
                            <input type="text" name="inJudul" placeholder="e.g. Metode Penelitian Hukum" value="{{ request('inJudul') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Pengarang -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Pengarang') }}</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-user text-xl"></i>
                            </div>
                            <input type="text" name="inPengarang1" placeholder="e.g. Prof. Soerjono Soekanto" value="{{ request('inPengarang1') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Penerbit & Subyek -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Penerbit') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-buildings text-xl"></i>
                                </div>
                                <input type="text" name="inPenerbit" placeholder="e.g. Rajawali Pers" value="{{ request('inPenerbit') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Subyek') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-tag text-xl"></i>
                                </div>
                                <input type="text" name="inSubyek" placeholder="e.g. Hukum Perdata" value="{{ request('inSubyek') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tahun Terbit & ISBN -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Tahun Terbit') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-calendar text-xl"></i>
                                </div>
                                <input type="text" name="intahunterbit" placeholder="e.g. 2023" value="{{ request('intahunterbit') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('ISBN') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-barcode text-xl"></i>
                                </div>
                                <input type="text" name="inisbn" placeholder="e.g. 978-602-8512-30-4" value="{{ request('inisbn') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- No. Klasifikasi & Barcode -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('No. Klasifikasi') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-hash text-xl"></i>
                                </div>
                                <input type="text" name="inKlasifikasi" placeholder="e.g. 340" value="{{ request('inKlasifikasi') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Barcode') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-qr-code text-xl"></i>
                                </div>
                                <input type="text" name="inbarcode" placeholder="e.g. 120930193" value="{{ request('inbarcode') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Filter Pencarian -->
                <div class="space-y-4 pt-2 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                        <i class="ph ph-sliders-horizontal text-sm text-[#106c38]"></i> {{ __('Lokasi & Jenis Koleksi') }}
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Semua Lokasi -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Lokasi') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-map-pin text-xl"></i>
                                </div>
                                <select name="inLokasi" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm appearance-none cursor-pointer">
                                    <option value="">{{ __('Semua Lokasi') }}</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc->code }}" {{ request('inLokasi') == $loc->code ? 'selected' : '' }}>{{ __($loc->name) }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 pointer-events-none text-slate-400">
                                    <i class="ph ph-caret-down text-sm"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Semua Jenis -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Jenis Koleksi') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-file-text text-xl"></i>
                                </div>
                                <select name="inJenis" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm appearance-none cursor-pointer">
                                    <option value="">{{ __('Semua Jenis') }}</option>
                                    <option value="buku" {{ request('inJenis') == 'buku' ? 'selected' : '' }}>{{ __('Buku') }}</option>
                                    <option value="jurnal" {{ request('inJenis') == 'jurnal' ? 'selected' : '' }}>{{ __('Jurnal') }}</option>
                                    <option value="majalah" {{ request('inJenis') == 'majalah' ? 'selected' : '' }}>{{ __('Majalah') }}</option>
                                    <option value="skripsi" {{ request('inJenis') == 'skripsi' ? 'selected' : '' }}>{{ __('Skripsi/Tesis/Disertasi') }}</option>
                                    <option value="laporan_penelitian" {{ request('inJenis') == 'laporan_penelitian' ? 'selected' : '' }}>{{ __('Laporan Penelitian') }}</option>
                                </select>
                                <div class="absolute right-4 pointer-events-none text-slate-400">
                                    <i class="ph ph-caret-down text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cari Button -->
                <div class="flex justify-center pt-4">
                    <button type="submit" class="bg-[#106c38] hover:bg-green-800 text-white px-12 py-4 rounded-full font-bold text-sm tracking-wider uppercase transition-all shadow-lg shadow-green-950/20 hover:shadow-green-900/40 hover:-translate-y-0.5 focus:outline-none flex items-center gap-2">
                        <i class="ph ph-magnifying-glass text-lg"></i> {{ __('Cari Koleksi') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Trigger and Animation Javascript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal-pencarian-spesifik');
            const modalContent = document.getElementById('modal-content');
            const btnOpenList = [
                document.getElementById('open-modal-pencarian-spesifik'),
                document.getElementById('open-modal-pencarian-spesifik-empty')
            ];
            const btnClose = document.getElementById('close-modal-pencarian-spesifik');

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 200);
            }

            btnOpenList.forEach(btn => {
                if (btn) btn.addEventListener('click', openModal);
            });

            if (btnClose) btnClose.addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
