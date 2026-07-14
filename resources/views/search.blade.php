<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Hasil Pencarian') }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>

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
            background-color: #F3C300 !important;
            color: #106c38 !important;
        }
        .btn-cari:hover {
            background-color: #e0b400 !important;
        }
        .btn-spesifik {
            background-color: #106c38 !important;
            color: #ffffff !important;
            border: none !important;
        }
        .btn-spesifik:hover {
            background-color: #0b4b27 !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .result-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
        }
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05), 0 8px 8px -5px rgba(0, 0, 0, 0.02);
            border-color: #106c38/30;
        }
        .result-card h3 a::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 10;
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
                        <img src="{{ asset('logousu.webp') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 object-contain">
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

    <main class="flex-grow max-w-[1400px] w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        

        
        <!-- Search Header Banner with Background Image -->
        <div class="relative bg-gradient-to-br from-[#064e3b] to-[#106c38] rounded-3xl p-6 sm:p-10 mb-8 overflow-hidden text-white shadow-lg">
            <!-- Background Image with Low Opacity -->
            <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-35" style="background-image: url('{{ asset('kolam_perpustakaan.webp') }}');"></div>
            
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">{{ __('Hasil Pencarian Katalog') }}</h1>
                <p class="text-sm text-green-100/90 mb-6 max-w-xl">{{ __('Jelajahi dan temukan koleksi buku referensi, jurnal, atau skripsi untuk kebutuhan riset Anda.') }}</p>
                
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20">
                    <div class="flex-grow relative flex items-center bg-white rounded-xl border border-transparent overflow-hidden focus-within:ring-2 focus-within:ring-[#106c38]/20 transition-all">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                        </div>
                        <input type="text" id="live-search-input" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari buku, jurnal, penulis, atau kata kunci...') }}" class="w-full pl-11 pr-4 py-3 bg-transparent border-0 focus:ring-0 focus:border-0 outline-none text-slate-800 placeholder-slate-400 text-sm font-medium">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-cari bg-[#F3C300] hover:bg-[#e0b400] text-[#106c38] font-bold text-sm px-6 py-3 rounded-xl transition shadow-md flex items-center justify-center gap-1.5 flex-grow md:flex-none cursor-pointer">
                            <i class="ph ph-magnifying-glass"></i>{{ __('Cari') }}
                        </button>
                        <button type="button" id="open-modal-pencarian-spesifik" class="btn-spesifik bg-[#106c38] hover:bg-[#0b4b27] text-white font-bold text-sm px-5 py-3 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="ph ph-sliders-horizontal"></i>{{ __('Spesifik') }}
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
                <div class="book-card result-card bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-3.5 sm:p-6 flex flex-col sm:flex-row gap-3 sm:gap-6 items-start shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group"
                     data-title="{{ strtolower($book->title) }}" 
                     data-author="{{ strtolower($book->author) }}" 
                     data-publisher="{{ strtolower($book->publisher) }}">
                    
                    <!-- Mobile Top Section: Number & Title, with Category below -->
                    <div class="flex sm:hidden flex-col w-full mb-2.5 flex-shrink-0">
                        <div class="flex items-start gap-2.5 w-full">
                            <div class="card-number-index text-sm font-black text-slate-500 select-none pt-0.5">
                                {{ sprintf('%02d', $books->firstItem() + $loop->index) }}
                            </div>
                            <h3 class="text-base font-bold text-slate-800 hover:text-[#106c38] hover:underline transition leading-snug">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title ?: __('Judul Tidak Tersedia') }}</a>
                            </h3>
                        </div>
                        <div class="mt-1 pl-[26px]">
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full tracking-wider uppercase">
                                {{ __($book->category ?: 'Umum') }}
                            </span>
                        </div>
                    </div>

                    <!-- Desktop Card Numbering Index -->
                    <div class="card-number-index hidden sm:block flex-shrink-0 text-base sm:text-2xl font-black text-slate-400 group-hover:text-[#106c38]/30 transition-colors select-none w-6 sm:w-8 text-center pt-1.5 sm:pt-4">
                        {{ sprintf('%02d', $books->firstItem() + $loop->index) }}
                    </div>

                    <!-- Desktop Book Cover -->
                    <div class="hidden sm:block w-20 sm:w-28 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-2">
                                <i class="ph ph-book-open text-3xl mb-1.5"></i>
                                <span class="text-[9px] font-bold text-center leading-tight">NO COVER</span>
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 bg-[#106c38] text-white text-[8px] font-bold px-1.5 py-0.5 rounded shadow">
                            {{ strtoupper(__($book->jenis)) }}
                        </span>
                    </div>

                    <!-- Book Details & Mobile Layout container -->
                    <div class="flex-grow flex flex-col h-full w-full">
                        <!-- Header (Desktop Title & Category - hidden on mobile) -->
                        <div class="hidden sm:block mb-2 w-full">
                            <!-- Category Badge (Desktop only) -->
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 tracking-wider uppercase">
                                {{ __($book->category ?: 'Umum') }}
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 hover:text-[#106c38] hover:underline transition leading-snug">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title ?: __('Judul Tidak Tersedia') }}</a>
                            </h3>
                        </div>

                        <!-- Content: Flex side-by-side on mobile, normal block on desktop -->
                        <div class="flex flex-row sm:block gap-4 items-start w-full mt-1 sm:mt-0">
                            <!-- Mobile Book Cover (Visible only on mobile) -->
                            <div class="block sm:hidden w-20 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-lg overflow-hidden shadow-sm flex-shrink-0 relative">
                                @if($book->cover_image)
                                    <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-2">
                                        <i class="ph ph-book-open text-2xl mb-1"></i>
                                        <span class="text-[8px] font-bold text-center leading-tight">NO COVER</span>
                                    </div>
                                @endif
                                <span class="absolute top-1.5 left-1.5 bg-[#106c38] text-white text-[7px] font-bold px-1.5 py-0.5 rounded shadow">
                                    {{ strtoupper(__($book->jenis)) }}
                                </span>
                            </div>

                            <!-- Author & Metadata details -->
                            <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mb-3 sm:mb-4 text-xs font-medium text-slate-500">
                                <div class="flex items-start gap-1.5">
                                    <i class="ph ph-user text-sm text-slate-400 mt-0.5"></i>
                                    <span>{{ __('Pengarang:') }} <strong class="text-slate-700">{{ $book->author }}</strong></span>
                                </div>
                                <div class="flex items-start gap-1.5">
                                    <i class="ph ph-hash text-sm text-slate-400 mt-0.5"></i>
                                    <span>{{ __('No. Panggil:') }} <strong class="text-slate-700">{{ $book->call_number ?: '-' }}</strong></span>
                                </div>
                                <div class="flex items-start gap-1.5">
                                    <i class="ph ph-buildings text-sm text-slate-400 mt-0.5"></i>
                                    <span>{{ __('Penerbit:') }} <strong class="text-slate-700">{{ $book->publisher ?: '-' }}</strong></span>
                                </div>
                                <div class="flex items-start gap-1.5">
                                    <i class="ph ph-calendar text-sm text-slate-400 mt-0.5"></i>
                                    <span>{{ __('Tahun Terbit:') }} <strong class="text-slate-700">{{ $book->publish_year ?: '-' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Availability Pill -->
                        <div class="mt-auto pt-2.5 sm:pt-3 border-t border-slate-50 flex flex-wrap gap-2 items-center justify-between text-xs w-full">
                            <div class="flex items-start gap-1.5 text-slate-400">
                                <i class="ph ph-map-pin text-sm text-[#106c38] mt-0.5"></i>
                                <span class="font-medium text-slate-500">
                                    {{ __('Lokasi:') }} 
                                    @php
                                        $locNames = $book->items->map(function($i) { return __($i->location->name); })->unique();
                                    @endphp
                                    <strong class="text-slate-700">{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}</strong>
                                </span>
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
    <div id="modal-pencarian-spesifik" class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center bg-slate-950/60 backdrop-blur-sm p-0 sm:p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl w-full sm:max-w-2xl max-h-[85vh] sm:max-h-[calc(100vh-4rem)] flex flex-col overflow-hidden border border-emerald-800/10 transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
            <!-- Modal Header Banner -->
            <div class="bg-gradient-to-br from-[#064e3b] to-[#106c38] px-5 py-4 md:px-6 md:py-6 text-white relative flex-shrink-0">
                <div class="flex items-center gap-3 md:gap-4 pr-8">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 backdrop-blur-md rounded-xl md:rounded-2xl flex items-center justify-center text-white text-lg md:text-2xl shadow-inner">
                        <i class="ph ph-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-lg font-bold tracking-wide">{{ __('Pencarian Spesifik') }}</h3>
                        <p class="text-[10px] md:text-xs text-green-100/90 font-medium font-sans leading-tight">{{ __('Temukan buku, skripsi, dan jurnal untuk tugas kuliahmu dengan cepat!') }}</p>
                    </div>
                </div>
                <button id="close-modal-pencarian-spesifik" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/80 hover:text-white transition-all hover:scale-105 focus:outline-none bg-white/10 hover:bg-white/20 p-1.5 md:p-2 rounded-xl flex items-center justify-center">
                    <i class="ph ph-x text-base md:text-lg"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form action="{{ route('search') }}" method="GET" class="p-5 md:p-8 space-y-4 md:space-y-6 overflow-y-auto flex-grow">
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
                            <input type="text" name="inJudul" placeholder="{{ __('e.g. Metode Penelitian Hukum') }}" value="{{ request('inJudul') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Pengarang -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Pengarang') }}</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-user text-xl"></i>
                            </div>
                            <input type="text" name="inPengarang1" placeholder="{{ __('e.g. Prof. Soerjono Soekanto') }}" value="{{ request('inPengarang1') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inPenerbit" placeholder="{{ __('e.g. Rajawali Pers') }}" value="{{ request('inPenerbit') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Subyek') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-tag text-xl"></i>
                                </div>
                                <input type="text" name="inSubyek" placeholder="{{ __('e.g. Hukum Perdata') }}" value="{{ request('inSubyek') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="intahunterbit" placeholder="{{ __('e.g. 2023') }}" value="{{ request('intahunterbit') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('ISBN') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-barcode text-xl"></i>
                                </div>
                                <input type="text" name="inisbn" placeholder="{{ __('e.g. 978-602-8512-30-4') }}" value="{{ request('inisbn') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inKlasifikasi" placeholder="{{ __('e.g. 340') }}" value="{{ request('inKlasifikasi') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Barcode') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-qr-code text-xl"></i>
                                </div>
                                <input type="text" name="inbarcode" placeholder="{{ __('e.g. 120930193') }}" value="{{ request('inbarcode') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                            <div class="relative w-full" id="spec-dropdown-lokasi-container">
                                <div class="absolute left-4 text-slate-400 z-10 pointer-events-none top-1/2 -translate-y-1/2 flex items-center">
                                    <i class="ph ph-map-pin text-xl"></i>
                                </div>
                                @php
                                    $activeLocVal = request('inLokasi', '');
                                    $activeLocLabel = __('Semua Lokasi');
                                    if ($activeLocVal) {
                                        $foundLoc = $locations->firstWhere('code', $activeLocVal);
                                        if ($foundLoc) {
                                            $activeLocLabel = __($foundLoc->name);
                                        }
                                    }
                                @endphp
                                <button type="button" id="spec-dropdown-lokasi-trigger" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm flex items-center justify-between cursor-pointer select-none text-left">
                                    <span id="spec-dropdown-lokasi-label">{{ $activeLocLabel }}</span>
                                    <i class="ph ph-caret-down text-sm text-slate-400"></i>
                                </button>
                                <input type="hidden" name="inLokasi" id="spec-dropdown-lokasi-value" value="{{ $activeLocVal }}">
                                
                                <div id="spec-dropdown-lokasi-menu" class="hidden absolute left-0 bottom-full mb-2 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 transition-all max-h-60 overflow-y-auto scrollbar-thin">
                                    <button type="button" data-value="" class="spec-dropdown-lokasi-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Semua Lokasi') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    @foreach($locations as $loc)
                                        <button type="button" data-value="{{ $loc->code }}" class="spec-dropdown-lokasi-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                            <span>{{ __($loc->name) }}</span>
                                            <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Semua Jenis -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Jenis Koleksi') }}</label>
                            <div class="relative w-full" id="spec-dropdown-jenis-container">
                                <div class="absolute left-4 text-slate-400 z-10 pointer-events-none top-1/2 -translate-y-1/2 flex items-center">
                                    <i class="ph ph-file-text text-xl"></i>
                                </div>
                                @php
                                    $activeJenisVal = request('inJenis', '');
                                    $jenisLabels = [
                                        'buku' => __('Buku'),
                                        'jurnal' => __('Jurnal'),
                                        'majalah' => __('Majalah'),
                                        'skripsi' => __('Skripsi/Tesis/Disertasi'),
                                        'laporan_penelitian' => __('Laporan Penelitian')
                                    ];
                                    $activeJenisLabel = $jenisLabels[$activeJenisVal] ?? __('Semua Jenis');
                                @endphp
                                <button type="button" id="spec-dropdown-jenis-trigger" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm flex items-center justify-between cursor-pointer select-none text-left">
                                    <span id="spec-dropdown-jenis-label">{{ $activeJenisLabel }}</span>
                                    <i class="ph ph-caret-down text-sm text-slate-400"></i>
                                </button>
                                <input type="hidden" name="inJenis" id="spec-dropdown-jenis-value" value="{{ $activeJenisVal }}">
                                
                                <div id="spec-dropdown-jenis-menu" class="hidden absolute left-0 bottom-full mb-2 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 transition-all">
                                    <button type="button" data-value="" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Semua Jenis') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    <button type="button" data-value="buku" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Buku') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    <button type="button" data-value="jurnal" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Jurnal') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    <button type="button" data-value="majalah" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Majalah') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    <button type="button" data-value="skripsi" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Skripsi/Tesis/Disertasi') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
                                    <button type="button" data-value="laporan_penelitian" class="spec-dropdown-jenis-option w-full text-left px-5 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition font-medium flex items-center justify-between">
                                        <span>{{ __('Laporan Penelitian') }}</span>
                                        <i class="ph ph-check text-[14px] check-icon hidden text-[#106c38]"></i>
                                    </button>
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
            // Specific Search Modal Custom Dropdowns
            const specLocTrigger = document.getElementById('spec-dropdown-lokasi-trigger');
            const specLocMenu = document.getElementById('spec-dropdown-lokasi-menu');
            const specLocLabel = document.getElementById('spec-dropdown-lokasi-label');
            const specLocValue = document.getElementById('spec-dropdown-lokasi-value');
            const specLocOpts = document.querySelectorAll('.spec-dropdown-lokasi-option');

            const specJenisTrigger = document.getElementById('spec-dropdown-jenis-trigger');
            const specJenisMenu = document.getElementById('spec-dropdown-jenis-menu');
            const specJenisLabel = document.getElementById('spec-dropdown-jenis-label');
            const specJenisValue = document.getElementById('spec-dropdown-jenis-value');
            const specJenisOpts = document.querySelectorAll('.spec-dropdown-jenis-option');

            function syncCheckIcons(options, activeVal) {
                options.forEach(o => {
                    const check = o.querySelector('.check-icon');
                    if (!check) return;
                    if (o.getAttribute('data-value') === activeVal) {
                        check.classList.remove('hidden');
                        o.classList.add('bg-green-50/50', 'text-[#106c38]', 'font-bold');
                        o.classList.remove('text-slate-700', 'font-medium');
                    } else {
                        check.classList.add('hidden');
                        o.classList.remove('bg-green-50/50', 'text-[#106c38]', 'font-bold');
                        o.classList.add('text-slate-700', 'font-medium');
                    }
                });
            }

            // Init Check Icons based on active query states
            syncCheckIcons(specLocOpts, specLocValue ? specLocValue.value : "");
            syncCheckIcons(specJenisOpts, specJenisValue ? specJenisValue.value : "");

            if (specLocTrigger && specLocMenu) {
                specLocTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    specLocMenu.classList.toggle('hidden');
                    if (specJenisMenu) specJenisMenu.classList.add('hidden');
                });

                specLocOpts.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = opt.getAttribute('data-value');
                        const labelText = opt.querySelector('span').innerText.trim();
                        specLocLabel.innerText = labelText;
                        specLocValue.value = val;
                        syncCheckIcons(specLocOpts, val);
                        specLocMenu.classList.add('hidden');
                    });
                });
            }

            if (specJenisTrigger && specJenisMenu) {
                specJenisTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    specJenisMenu.classList.toggle('hidden');
                    if (specLocMenu) specLocMenu.classList.add('hidden');
                });

                specJenisOpts.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = opt.getAttribute('data-value');
                        const labelText = opt.querySelector('span').innerText.trim();
                        specJenisLabel.innerText = labelText;
                        specJenisValue.value = val;
                        syncCheckIcons(specJenisOpts, val);
                        specJenisMenu.classList.add('hidden');
                    });
                });
            }

            // Close spec menus on click outside
            document.addEventListener('click', () => {
                if (specLocMenu) specLocMenu.classList.add('hidden');
                if (specJenisMenu) specJenisMenu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
