<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OPAC - {{ __('Universitas Sumatera Utara') }}</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;850;900&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

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
        .hero-gradient {
            background: linear-gradient(135deg, #07522d 0%, #106c38 50%, #15803d 100%);
        }
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #106c38;
        }

        /* 3D Carousel Styles */
        .carousel-slide {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(0.5);
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
        }

        .carousel-slide.active {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
            z-index: 30;
            pointer-events: auto;
        }

        /* ===== Mobile (< 640px): tighter card, prev/next peeking at edges ===== */
        .carousel-slide.prev {
            opacity: 0.75;
            transform: translate(-225%, -50%) scale(0.85);
            z-index: 20;
            pointer-events: auto;
        }

        .carousel-slide.next {
            opacity: 0.75;
            transform: translate(125%, -50%) scale(0.85);
            z-index: 20;
            pointer-events: auto;
        }

        .carousel-slide.hidden-left {
            opacity: 0;
            transform: translate(-325%, -50%) scale(0.5);
            z-index: 10;
            pointer-events: none;
        }

        .carousel-slide.hidden-right {
            opacity: 0;
            transform: translate(225%, -50%) scale(0.5);
            z-index: 10;
            pointer-events: none;
        }

        /* ===== Small Tablet (640px+) ===== */
        @media (min-width: 640px) {
            .carousel-slide.active {
                transform: translate(-50%, -50%) scale(1);
            }

            .carousel-slide.prev {
                opacity: 0.75;
                transform: translate(-128%, -50%) scale(0.78);
                pointer-events: auto;
                cursor: pointer;
            }

            .carousel-slide.next {
                opacity: 0.75;
                transform: translate(28%, -50%) scale(0.78);
                pointer-events: auto;
                cursor: pointer;
            }

            .carousel-slide.hidden-left {
                transform: translate(-210%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(110%, -50%) scale(0.5);
            }
        }

        /* ===== iPad / Medium Tablet (768px+) ===== */
        @media (min-width: 768px) {
            .carousel-slide.active {
                transform: translate(-50%, -50%) scale(1);
            }

            .carousel-slide.prev {
                opacity: 0.80;
                transform: translate(-190%, -50%) scale(0.82);
            }

            .carousel-slide.next {
                opacity: 0.80;
                transform: translate(90%, -50%) scale(0.82);
            }

            .carousel-slide.hidden-left {
                transform: translate(-290%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(190%, -50%) scale(0.5);
            }
        }

        /* ===== Desktop (1024px+) ===== */
        @media (min-width: 1024px) {
            .carousel-slide.active {
                transform: translate(-50%, -50%) scale(1);
            }

            .carousel-slide.prev {
                opacity: 0.88;
                transform: translate(-205%, -50%) scale(0.84);
            }

            .carousel-slide.next {
                opacity: 0.88;
                transform: translate(105%, -50%) scale(0.84);
            }

            .carousel-slide.hidden-left {
                transform: translate(-310%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(210%, -50%) scale(0.5);
            }
        }

        /* Info panel collapse/expand */
        .carousel-slide .info-panel {
            width: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            padding: 0;
            transition: max-width 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease, padding 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Mobile active info panel — compact but readable */
        .carousel-slide.active .info-panel {
            width: 250px;
            max-width: 250px;
            opacity: 1;
            padding: 1rem;
            border-left: 1px solid rgba(0, 0, 0, 0.08);
        }

        @media (min-width: 640px) {
            .carousel-slide.active .info-panel {
                width: 280px;
                max-width: 280px;
                padding: 1.25rem;
            }
        }

        @media (min-width: 768px) {
            .carousel-slide.active .info-panel {
                width: 340px;
                max-width: 340px;
                padding: 1.75rem;
            }
        }

        @media (min-width: 1024px) {
            .carousel-slide.active .info-panel {
                width: 390px;
                max-width: 390px;
                padding: 2rem;
            }
        }
        /* Carousel swipe: disable browser touch handling so our Pointer Events work */
        #carousel-koleksi-track,
        #carousel-koleksi-track .carousel-slide,
        #carousel-koleksi-track a {
            touch-action: pan-y;      /* allow vertical scroll, let JS handle horizontal */
            user-select: none;
            -webkit-user-select: none;
        }

        /* The outer wrapper (overflow-hidden div) also needs touch-action */
        #prev-btn-koleksi,
        #next-btn-koleksi,
        #prev-btn-koleksi ~ * {
            touch-action: pan-y;
        }

        /* Reverted mobile scroll styles to preserve original 3D stacked layout style */

    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900">

    @include('partials.navbar')

    <!-- Hero Section -->
    <div class="hero-gradient min-h-[74vh] pt-24 pb-0 relative overflow-hidden flex flex-col justify-start">
        <!-- Background Image of USU Pond with Low Opacity Overlay -->
        <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-35" style="background-image: url('{{ asset('kolam_perpustakaan.jpg') }}');"></div>

        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none opacity-40">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
            <div class="absolute top-12 -right-12 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex flex-col justify-start pt-2 w-full">
            <!-- OPAC Brand Block -->
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-4 mt-2">
                <div class="flex flex-col text-white">
                    <span class="font-extrabold text-4xl sm:text-5xl lg:text-6xl leading-none tracking-[0.2em] drop-shadow-lg mb-2">O P A C</span>
                    <span class="text-xs sm:text-sm lg:text-base font-bold text-green-100/90 leading-none tracking-widest uppercase drop-shadow-md mb-1">ONLINE PUBLIC ACCESS CATALOG</span>
                    <span class="text-[10px] sm:text-xs lg:text-sm font-semibold text-green-100/80 leading-none tracking-wide drop-shadow-md">University of Sumatera Utara Library</span>
                </div>
            </div>

            <!-- Search Area -->
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-6 w-full mt-4">
                <!-- Search Bar -->
                <form id="main-search-form" action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-xl">
                    <div class="flex-grow relative flex items-center bg-white rounded-xl border border-transparent overflow-hidden focus-within:ring-2 focus-within:ring-[#106c38]/20 transition-all">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                        </div>
                        <input type="text" id="live-search-input" name="q" placeholder="{{ __('Cari buku, jurnal, penulis, atau kata kunci...') }}" class="w-full pl-11 pr-4 py-3 sm:py-4 bg-transparent border-0 focus:ring-0 focus:border-0 outline-none text-slate-800 placeholder-slate-400 text-sm sm:text-base font-medium">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-[#106c38] hover:bg-green-800 text-white font-bold text-sm sm:text-base px-6 py-3 sm:py-4 rounded-xl transition shadow-md flex items-center justify-center gap-1.5 flex-grow md:flex-none cursor-pointer">
                            <i class="ph ph-magnifying-glass"></i> {{ __('Cari') }}
                        </button>
                        <button type="button" id="open-modal-pencarian-spesifik" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-5 py-3 sm:py-4 rounded-xl transition border border-emerald-500/35 flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="ph ph-sliders-horizontal"></i> {{ __('Spesifik') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- 20 Koleksi Terbaru Carousel -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative w-full">
                <div class="text-center mb-1 max-w-5xl mx-auto px-4">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white tracking-normal">
                        {{ __('Koleksi Terbaru') }}
                    </h3>
                </div>

                <!-- Carousel Area -->
                <div id="carousel-koleksi-area" class="relative w-full h-[280px] sm:h-[420px] md:h-[460px] flex items-center justify-center overflow-hidden">
                    <!-- Left Navigation Button -->
                    <button id="prev-btn-koleksi" class="absolute hidden lg:flex top-1/2 -translate-y-1/2 left-2 sm:left-6 md:left-10 lg:left-12 xl:left-16 z-40 w-8 h-8 sm:w-10 sm:h-10 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full items-center justify-center transition-all cursor-pointer">
                        <i class="ph ph-caret-left text-xl font-bold"></i>
                    </button>

                    <!-- Slides Track -->
                    <div id="carousel-koleksi-track" class="relative w-full h-full flex items-center justify-center">
                        @foreach ($latestBooks as $index => $book)
                        @php $bigCat = $book->category ?: 'Umum'; @endphp
                        <div class="book-card carousel-slide absolute transition-all duration-500 ease-in-out opacity-0 pointer-events-none" data-index="{{ $index }}"
                             data-title="{{ strtolower($book->title) }}" 
                             data-author="{{ strtolower($book->author) }}" 
                             data-publisher="{{ strtolower($book->publisher) }}">
                            <a href="{{ route('books.show', $book->id) }}"
                               class="flex h-[225px] sm:h-[285px] md:h-[315px] bg-white/95 backdrop-blur-md border border-slate-200/80 rounded-2xl overflow-hidden shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] transition-all duration-300 max-w-[90vw] md:max-w-4xl hover:-translate-y-2 hover:shadow-[0_32px_60px_-12px_rgba(0,0,0,0.35)] hover:border-[#106c38]/30 group cursor-pointer">
                                <!-- Cover Panel -->
                                <div class="w-[150px] sm:w-[190px] md:w-[210px] h-full flex-shrink-0 bg-slate-50 relative overflow-hidden flex items-center justify-center p-2 sm:p-5 border-r border-slate-100">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-lg shadow-md transition-transform duration-300 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 border border-dashed border-slate-200 rounded-lg bg-slate-100/50">
                                            <i class="ph ph-book-open text-4xl sm:text-5xl mb-2 text-[#106c38]"></i>
                                            <span class="text-[9px] sm:text-xs font-semibold text-slate-500 text-center leading-tight">{{ __('Cover Buku') }}</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-red-600 text-white text-[8px] sm:text-[9px] font-bold px-1.5 py-0.5 rounded shadow">NEW</span>
                                </div>

                                <!-- Info Panel -->
                                <div class="info-panel flex flex-col justify-between text-left h-full">
                                    <div class="overflow-hidden">
                                        <!-- Big Category Badge -->
                                        <span class="inline-block px-2.5 py-0.5 bg-green-50 text-[#106c38] border border-green-200/60 text-[8px] sm:text-[9px] font-bold rounded-full uppercase tracking-wider mb-2 sm:mb-3">
                                            {{ __($bigCat) }}
                                        </span>
                                        <!-- Title -->
                                        <h4 class="text-sm sm:text-base md:text-xl font-bold text-slate-900 leading-snug mb-1 sm:mb-2 line-clamp-2 group-hover:text-[#106c38] transition-colors" title="{{ $book->title }}">
                                            {{ $book->title }}
                                        </h4>
                                        <!-- Metadata (Mobile & Desktop) -->
                                        @php
                                            $locNames = $book->items->map(function($i) { return __($i->location->name); })->unique();
                                        @endphp
                                        
                                        <!-- Metadata Grid (All devices) -->
                                        <div class="grid grid-cols-2 gap-x-2 sm:gap-x-6 gap-y-2 sm:gap-y-3 border-t border-slate-100 pt-2 sm:pt-4 mb-2 text-[9px] sm:text-xs md:text-sm">
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Penulis') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate" title="{{ $book->author }}">{{ $book->author ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('No. Klasifikasi') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate">{{ $book->classification ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Penerbit') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate" title="{{ $book->publisher }}">{{ $book->publisher ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Tahun Terbit') }}</span>
                                                <span class="text-slate-800 font-semibold block">{{ $book->publish_year ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">Jenis</span>
                                                <span class="text-slate-800 font-semibold block truncate">{{ strtoupper($book->jenis ?: 'buku') }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[8px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Lokasi') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate" title="{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}">{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Right Navigation Button -->
                    <button id="next-btn-koleksi" class="absolute hidden lg:flex top-1/2 -translate-y-1/2 right-2 sm:right-6 md:right-10 lg:right-12 xl:right-16 z-40 w-8 h-8 sm:w-10 sm:h-10 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full items-center justify-center transition-all cursor-pointer">
                        <i class="ph ph-caret-right text-xl font-bold"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section (Marquee) -->
    <div id="statistics-section" class="pt-6 pb-6 w-full overflow-hidden bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 sm:mb-10 relative flex flex-col items-center justify-center text-center">
            <div class="flex flex-col items-center">
                <h2 class="text-lg sm:text-2xl md:text-3xl font-bold text-slate-800 mb-1 sm:mb-3">{{ __('Jumlah Judul Buku Berdasarkan Lokasi') }}</h2>
                <div class="w-16 sm:w-24 h-1 bg-[#106c38] rounded-full"></div>
            </div>
            <div class="sm:absolute right-4 sm:right-6 lg:right-8 sm:top-1/2 sm:-translate-y-1/2 mt-4 sm:mt-0">
                <button id="btn-toggle-locations" class="inline-flex items-center gap-1 sm:gap-2 bg-white hover:bg-slate-50 text-[#106c38] px-3 sm:px-6 py-1.5 sm:py-2.5 rounded-full font-bold text-[10px] sm:text-sm tracking-wider uppercase border-2 border-[#106c38]/20 hover:border-[#106c38] transition shadow-sm focus:outline-none cursor-pointer">
                    <span id="text-toggle-locations">{{ __('Lihat Semua') }}</span> 
                    <i class="ph ph-caret-down text-sm sm:text-lg transition-transform duration-300" id="icon-toggle-locations"></i>
                </button>
            </div>
        </div>

        <div id="marquee-locations-container" class="marquee-container relative w-full overflow-hidden py-4 transition-all duration-500">
            <!-- Fade edges -->
            <div class="absolute top-0 left-0 w-8 md:w-32 h-full bg-gradient-to-r from-[#f8fafc] to-transparent z-10 pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-8 md:w-32 h-full bg-gradient-to-l from-[#f8fafc] to-transparent z-10 pointer-events-none"></div>

            <div class="animate-marquee-right flex gap-6 px-3">
                <!-- Original Set -->
                <div class="flex gap-6 shrink-0">
                    @foreach($locations as $stat)
                    <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" data-location="{{ $stat->code }}" class="bg-white rounded-xl p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 w-[220px] sm:w-[280px] shrink-0 h-[85px] sm:h-[100px]">
                        
                        <!-- Orange glow at bottom right -->
                        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                        <div class="flex flex-col z-10 max-w-[75%]">
                            <h3 class="text-[26px] font-bold text-[#064e3b] mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                            <p class="text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                        </div>
                        
                        <div class="text-[#064e3b] z-10 opacity-90">
                            <i class="ph {{ $stat->icon }} text-2xl sm:text-[42px]"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
                <!-- Duplicated Set for Loop -->
                <div class="flex gap-6 shrink-0">
                    @foreach($locations as $stat)
                    <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" data-location="{{ $stat->code }}" class="bg-white rounded-xl p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 w-[220px] sm:w-[280px] shrink-0 h-[85px] sm:h-[100px]">
                        
                        <!-- Orange glow at bottom right -->
                        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                        <div class="flex flex-col z-10 max-w-[75%]">
                            <h3 class="text-[26px] font-bold text-[#064e3b] mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                            <p class="text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                        </div>
                        
                        <div class="text-[#064e3b] z-10 opacity-90">
                            <i class="ph {{ $stat->icon }} text-2xl sm:text-[42px]"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="expanded-locations-grid" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 hidden transition-all duration-500 opacity-0 transform -translate-y-4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 pt-2">
                @foreach($locations as $stat)
                <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" data-location="{{ $stat->code }}" class="bg-white rounded-xl p-3 sm:p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 h-[75px] sm:h-[100px] w-full">
                    
                    <!-- Orange glow at bottom right -->
                    <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                    <div class="flex flex-col z-10 max-w-[75%]">
                        <h3 class="text-lg sm:text-[26px] font-bold text-[#064e3b] mb-0.5 sm:mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                        <p class="text-[10px] sm:text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                    </div>
                    
                    <div class="text-[#064e3b] z-10 opacity-90">
                        <i class="ph {{ $stat->icon }} text-2xl sm:text-[42px]"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>


    @include('partials.footer')

    <!-- Animations -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Marquee Animation */
        @keyframes marquee-right {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0%); }
        }
        .animate-marquee-right {
            display: flex;
            width: max-content;
            animation: marquee-right 90s linear infinite;
        }
        .marquee-container:hover .animate-marquee-right {
            animation-play-state: paused;
        }

        /* Hide scrollbar for slider */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .writing-vertical-rl {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
        .result-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.05), 0 8px 8px -5px rgba(0, 0, 0, 0.02);
            border-color: rgba(16, 108, 56, 0.3);
        }
    </style>

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
            <form id="modal-pencarian-spesifik-form" action="{{ route('search') }}" method="GET" class="p-5 md:p-8 space-y-4 md:space-y-6 overflow-y-auto flex-grow">
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
                            <input type="text" name="inJudul" placeholder="{{ __('e.g. Metode Penelitian Hukum') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Pengarang -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Pengarang') }}</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-user text-xl"></i>
                            </div>
                            <input type="text" name="inPengarang1" placeholder="{{ __('e.g. Prof. Soerjono Soekanto') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inPenerbit" placeholder="{{ __('e.g. Rajawali Pers') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Subyek') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-tag text-xl"></i>
                                </div>
                                <input type="text" name="inSubyek" placeholder="{{ __('e.g. Hukum Perdata') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="intahunterbit" placeholder="{{ __('e.g. 2023') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('ISBN') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-barcode text-xl"></i>
                                </div>
                                <input type="text" name="inisbn" placeholder="{{ __('e.g. 978-602-8512-30-4') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inKlasifikasi" placeholder="{{ __('e.g. 340') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Barcode') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-qr-code text-xl"></i>
                                </div>
                                <input type="text" name="inbarcode" placeholder="{{ __('e.g. 120930193') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <button type="button" id="spec-dropdown-lokasi-trigger" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm flex items-center justify-between cursor-pointer select-none text-left">
                                    <span id="spec-dropdown-lokasi-label">{{ __('Semua Lokasi') }}</span>
                                    <i class="ph ph-caret-down text-sm text-slate-400"></i>
                                </button>
                                <input type="hidden" name="inLokasi" id="spec-dropdown-lokasi-value" value="">
                                
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
                                <button type="button" id="spec-dropdown-jenis-trigger" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm flex items-center justify-between cursor-pointer select-none text-left">
                                    <span id="spec-dropdown-jenis-label">{{ __('Semua Jenis') }}</span>
                                    <i class="ph ph-caret-down text-sm text-slate-400"></i>
                                </button>
                                <input type="hidden" name="inJenis" id="spec-dropdown-jenis-value" value="">
                                
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

    <!-- Location Results Modal -->
    <div id="modal-hasil-lokasi" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/65 backdrop-blur-md p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl h-[85vh] overflow-hidden border border-emerald-800/10 transform transition-all duration-200 scale-95 opacity-0 flex flex-col" id="modal-hasil-content">
            <!-- Modal Header Banner -->
            <div class="bg-gradient-to-br from-[#064e3b] to-[#106c38] px-6 py-5 text-white relative rounded-t-3xl flex-shrink-0">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-2xl shadow-inner">
                        <i id="modal-hasil-icon" class="ph ph-buildings"></i>
                    </div>
                    <div>
                        <h3 id="modal-hasil-title" class="text-lg md:text-xl font-bold tracking-wide">{{ __('Koleksi Buku') }}</h3>
                        <p class="text-xs text-green-100/90 font-medium font-sans">{{ __('Daftar koleksi buku yang tersedia di lokasi ini') }}</p>
                    </div>
                </div>
                <button id="close-modal-hasil-lokasi" class="absolute top-5 right-6 text-white/80 hover:text-white transition-all hover:scale-105 focus:outline-none bg-white/10 hover:bg-white/20 p-2 rounded-xl flex items-center justify-center cursor-pointer">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
            
            <!-- Modal Body (Flex container) -->
            <div class="p-6 md:p-8 flex-grow flex flex-col min-h-0 bg-slate-50 rounded-b-3xl">
                <!-- Search Bar (Fixed at top) -->
                <div class="mb-6 flex-shrink-0">
                    <div class="relative flex items-center bg-white rounded-2xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-[#106c38]/20 focus-within:border-[#106c38] transition-all">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                        </div>
                        <input type="text" id="modal-hasil-search" placeholder="{{ __('Cari berdasarkan judul, pengarang, atau penerbit...') }}" class="w-full pl-11 pr-10 py-3.5 bg-transparent border-0 focus:ring-0 focus:border-0 outline-none text-slate-800 placeholder-slate-400 text-sm font-medium">
                        <button id="modal-hasil-search-clear" class="absolute right-4 text-slate-400 hover:text-slate-600 hidden bg-transparent border-none cursor-pointer">
                            <i class="ph ph-x-circle text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Scrollable list container -->
                <div class="overflow-y-auto flex-grow min-h-0 pr-1 -mr-2 scrollbar-thin" id="modal-hasil-body">
                    <!-- Loading State -->
                    <div id="modal-hasil-loading" class="flex flex-col items-center justify-center py-16 gap-3">
                        <div class="w-12 h-12 border-4 border-[#106c38] border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-slate-500 font-medium text-sm">Memuat daftar koleksi...</p>
                    </div>
                    <!-- Content Container -->
                    <div id="modal-hasil-container" class="hidden space-y-4">
                    </div>
                </div>

                <!-- Pagination Footer (Fixed at bottom) -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-200 mt-4 flex-shrink-0">
                    <!-- Show entries dropdown -->
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span>{{ __('Tampilkan:') }}</span>
                        <div class="relative inline-block text-left" id="modal-custom-dropdown">
                            <!-- Dropdown Trigger Button -->
                            <button type="button" id="modal-dropdown-trigger" class="flex items-center justify-between gap-4 bg-white border border-emerald-600/35 text-slate-700 text-xs font-bold rounded-full pl-4 pr-3 py-1.5 outline-none cursor-pointer hover:border-emerald-600 focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all shadow-sm min-w-[75px]">
                                <span id="modal-dropdown-selected-label">5</span>
                                <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
                            </button>
                            <!-- Hidden input to store value -->
                            <input type="hidden" id="modal-hasil-perpage" value="5">
                            
                            <!-- Dropdown Options Menu -->
                            <div id="modal-dropdown-menu" class="hidden absolute left-0 bottom-full mb-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 transition-all">
                                <button type="button" data-value="5" class="modal-dropdown-option w-full text-left px-4 py-2.5 text-xs font-bold text-[#106c38] bg-green-50/50 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                                    <span>5</span>
                                    <i class="ph ph-check text-[12px] modal-active-check"></i>
                                </button>
                                <button type="button" data-value="10" class="modal-dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                                    <span>10</span>
                                    <i class="ph ph-check text-[12px] modal-active-check hidden"></i>
                                </button>
                                <button type="button" data-value="50" class="modal-dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                                    <span>50</span>
                                    <i class="ph ph-check text-[12px] modal-active-check hidden"></i>
                                </button>
                                <button type="button" data-value="100" class="modal-dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                                    <span>100</span>
                                    <i class="ph ph-check text-[12px] modal-active-check hidden"></i>
                                </button>
                                <button type="button" data-value="all" class="modal-dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                                    <span>{{ __('Semua') }}</span>
                                    <i class="ph ph-check text-[12px] modal-active-check hidden"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Client-side Pagination links -->
                    <div id="modal-hasil-pagination" class="flex items-center gap-1.5">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Modal Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal-pencarian-spesifik');
            const modalContent = document.getElementById('modal-content');
            const btnOpen = document.getElementById('open-modal-pencarian-spesifik');
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

            if (btnOpen) btnOpen.addEventListener('click', openModal);
            if (btnClose) btnClose.addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Specific Search Modal: Custom Dropdowns Toggles & Handlers
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

            // Init Check Icons
            syncCheckIcons(specLocOpts, "");
            syncCheckIcons(specJenisOpts, "");

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

            // Location results modal toggles
            const modalHasil = document.getElementById('modal-hasil-lokasi');
            const modalHasilContent = document.getElementById('modal-hasil-content');
            const btnCloseHasil = document.getElementById('close-modal-hasil-lokasi');

            function openModalHasil() {
                modalHasil.classList.remove('hidden');
                modalHasil.classList.add('flex');
                setTimeout(() => {
                    modalHasilContent.classList.remove('scale-95', 'opacity-0');
                    modalHasilContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModalHasil() {
                modalHasilContent.classList.remove('scale-100', 'opacity-100');
                modalHasilContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalHasil.classList.remove('flex');
                    modalHasil.classList.add('hidden');
                }, 200);
            }

            if (btnCloseHasil) btnCloseHasil.addEventListener('click', closeModalHasil);

            modalHasil.addEventListener('click', function (e) {
                if (e.target === modalHasil) {
                    closeModalHasil();
                }
            });

            // State variables for Live Search & Client-side Pagination
            let allCards = [];
            let filteredCards = [];
            let currentPage = 1;
            let perPage = 5;

            const searchInput = document.getElementById('modal-hasil-search');
            const clearSearchBtn = document.getElementById('modal-hasil-search-clear');
            const perPageSelect = document.getElementById('modal-hasil-perpage');

            // Handle location cards click to open search results popup on homepage
            const locationCards = document.querySelectorAll('[data-location]');
            const modalHasilTitle = document.getElementById('modal-hasil-title');
            const modalHasilIcon = document.getElementById('modal-hasil-icon');

            locationCards.forEach(card => {
                card.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const branchName = this.querySelector('p') ? this.querySelector('p').innerText : '{{ __("Koleksi Buku") }}';
                    const iconEl = this.querySelector('i');
                    const iconClass = iconEl ? iconEl.className : 'ph ph-buildings';
                    const searchUrl = this.getAttribute('href');

                    if (modalHasilTitle) modalHasilTitle.innerText = branchName;
                    if (modalHasilIcon) modalHasilIcon.className = iconClass + ' text-2xl';

                    // Reset search state
                    allCards = [];
                    filteredCards = [];
                    currentPage = 1;
                    perPage = 5;
                    if (perPageSelect) {
                        perPageSelect.value = "5";
                        const modalDropdownLabel = document.getElementById('modal-dropdown-selected-label');
                        if (modalDropdownLabel) modalDropdownLabel.textContent = "5";
                        const modalDropdownOptions = document.querySelectorAll('.modal-dropdown-option');
                        modalDropdownOptions.forEach(o => {
                            const val = o.getAttribute('data-value');
                            const check = o.querySelector('.modal-active-check');
                            if (val === "5") {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });
                    }
                    if (searchInput) searchInput.value = '';
                    if (clearSearchBtn) clearSearchBtn.classList.add('hidden');

                    openModalHasil();
                    loadLocationResults(searchUrl);
                });
            });

            // Handle main search form submission to open results popup on homepage
            const mainSearchForm = document.getElementById('main-search-form');
            if (mainSearchForm) {
                mainSearchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevents app.js from intercepting the form submission
                    
                    const qInput = this.querySelector('input[name="q"]');
                    const queryVal = qInput ? qInput.value.trim() : '';
                    if (queryVal === '') return; // Don't search if empty

                    // Set modal info
                    if (modalHasilTitle) modalHasilTitle.innerText = '{{ __("Hasil Pencarian: ") }}' + '"' + queryVal + '"';
                    if (modalHasilIcon) modalHasilIcon.className = 'ph ph-magnifying-glass text-2xl';

                    // Reset search state
                    allCards = [];
                    filteredCards = [];
                    currentPage = 1;
                    perPage = 5;
                    if (perPageSelect) {
                        perPageSelect.value = "5";
                        const modalDropdownLabel = document.getElementById('modal-dropdown-selected-label');
                        if (modalDropdownLabel) modalDropdownLabel.textContent = "5";
                        const modalDropdownOptions = document.querySelectorAll('.modal-dropdown-option');
                        modalDropdownOptions.forEach(o => {
                            const val = o.getAttribute('data-value');
                            const check = o.querySelector('.modal-active-check');
                            if (val === "5") {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });
                    }
                    if (searchInput) searchInput.value = '';
                    if (clearSearchBtn) clearSearchBtn.classList.add('hidden');

                    openModalHasil();
                    
                    // Construct search URL (do NOT set q to server to let JS handle fuzzy search!)
                    const searchUrl = new URL(this.action, window.location.origin);
                    
                    loadLocationResults(searchUrl.toString(), queryVal);
                });
            }

            // Handle specific search form submission to open results popup on homepage
            const specificSearchForm = document.getElementById('modal-pencarian-spesifik-form');
            if (specificSearchForm) {
                specificSearchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Close input modal
                    closeModal();

                    // Set modal title & icon
                    if (modalHasilTitle) modalHasilTitle.innerText = '{{ __("Hasil Pencarian Spesifik") }}';
                    if (modalHasilIcon) modalHasilIcon.className = 'ph ph-sliders-horizontal text-2xl';

                    // Reset search state
                    allCards = [];
                    filteredCards = [];
                    currentPage = 1;
                    perPage = 5;
                    if (perPageSelect) {
                        perPageSelect.value = "5";
                        const modalDropdownLabel = document.getElementById('modal-dropdown-selected-label');
                        if (modalDropdownLabel) modalDropdownLabel.textContent = "5";
                        const modalDropdownOptions = document.querySelectorAll('.modal-dropdown-option');
                        modalDropdownOptions.forEach(o => {
                            const val = o.getAttribute('data-value');
                            const check = o.querySelector('.modal-active-check');
                            if (val === "5") {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });
                    }
                    if (searchInput) searchInput.value = '';
                    if (clearSearchBtn) clearSearchBtn.classList.add('hidden');

                    openModalHasil();

                    // Construct search URL from form data
                    const formData = new FormData(specificSearchForm);
                    const params = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        if (value.trim() !== '') {
                            params.append(key, value);
                        }
                    }
                    const searchUrl = `${specificSearchForm.action}?${params.toString()}`;

                    loadLocationResults(searchUrl, '');
                });
            }

            function loadLocationResults(url, initialQuery = '') {
                const loading = document.getElementById('modal-hasil-loading');
                const container = document.getElementById('modal-hasil-container');
                const paginationEl = document.getElementById('modal-hasil-pagination');
                
                if (loading) loading.classList.remove('hidden');
                if (container) {
                    container.classList.add('hidden');
                    container.innerHTML = '';
                }
                if (paginationEl) paginationEl.innerHTML = '';

                // Request with per_page=all to get all books for client-side search/pagination
                const urlObj = new URL(url, window.location.origin);
                urlObj.searchParams.set('per_page', 'all');

                fetch(urlObj.toString())
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const resultsList = doc.querySelector('main > .space-y-4.mb-8');

                        if (resultsList) {
                            const rawCards = resultsList.querySelectorAll('.result-card');
                            allCards = Array.from(rawCards).map(card => {
                                // Extract metadata fields for client-side search attributes
                                const titleEl = card.querySelector('h3 a');
                                const title = titleEl ? titleEl.innerText.trim().toLowerCase() : '';
                                card.setAttribute('data-title', title);

                                const spans = Array.from(card.querySelectorAll('span'));
                                
                                const authorSpan = spans.find(span => span.textContent.includes('Pengarang:'));
                                const author = authorSpan && authorSpan.querySelector('strong') ? authorSpan.querySelector('strong').innerText.trim().toLowerCase() : '';
                                card.setAttribute('data-author', author);

                                const publisherSpan = spans.find(span => span.textContent.includes('Penerbit:'));
                                const publisher = publisherSpan && publisherSpan.querySelector('strong') ? publisherSpan.querySelector('strong').innerText.trim().toLowerCase() : '';
                                card.setAttribute('data-publisher', publisher);

                                return card;
                            });

                            if (initialQuery !== '') {
                                filteredCards = allCards.filter(card => {
                                    const title = card.getAttribute('data-title') || '';
                                    const author = card.getAttribute('data-author') || '';
                                    const publisher = card.getAttribute('data-publisher') || '';
                                    
                                    if (typeof window.isFuzzyMatch === 'function') {
                                        return window.isFuzzyMatch(title, initialQuery) || 
                                               window.isFuzzyMatch(author, initialQuery) || 
                                               window.isFuzzyMatch(publisher, initialQuery);
                                    }
                                    return title.includes(initialQuery) || author.includes(initialQuery) || publisher.includes(initialQuery);
                                });
                            } else {
                                filteredCards = allCards;
                            }
                            
                            renderResults();
                        } else {
                            if (container) {
                                container.innerHTML = '<div class="text-center py-12 text-slate-500 font-medium">{{ __("Gagal memuat data koleksi.") }}</div>';
                            }
                        }

                        if (loading) loading.classList.add('hidden');
                        if (container) container.classList.remove('hidden');
                    })
                    .catch(err => {
                        console.error('Error loading location results:', err);
                        if (loading) loading.classList.add('hidden');
                        if (container) {
                            container.innerHTML = '<div class="text-center py-12 text-red-500 font-bold">{{ __("Terjadi kesalahan saat memuat data. Silakan coba lagi.") }}</div>';
                            container.classList.remove('hidden');
                        }
                    });
            }

            function renderResults() {
                const container = document.getElementById('modal-hasil-container');
                const paginationEl = document.getElementById('modal-hasil-pagination');
                if (!container) return;

                container.innerHTML = '';
                
                if (filteredCards.length === 0) {
                    container.innerHTML = `
                        <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                                <i class="ph ph-warning-circle"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __("Koleksi Tidak Ditemukan") }}</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto">
                                {{ __("Maaf, kami tidak dapat menemukan buku atau referensi yang cocok dengan kata kunci pencarian Anda di lokasi ini.") }}
                            </p>
                        </div>
                    `;
                    if (paginationEl) paginationEl.innerHTML = '';
                    return;
                }

                let displayCards = [];
                if (perPage === 'all') {
                    displayCards = filteredCards;
                } else {
                    const startIndex = (currentPage - 1) * perPage;
                    const endIndex = startIndex + perPage;
                    displayCards = filteredCards.slice(startIndex, endIndex);
                }

                displayCards.forEach((card, index) => {
                    const cloned = card.cloneNode(true);
                    const numberingEl = cloned.querySelector('.text-slate-200');
                    if (numberingEl) {
                        const itemNumber = (perPage === 'all') 
                            ? (index + 1) 
                            : ((currentPage - 1) * perPage + index + 1);
                        numberingEl.innerText = String(itemNumber).padStart(2, '0');
                    }
                    container.appendChild(cloned);
                });

                if (paginationEl) {
                    paginationEl.innerHTML = '';
                    if (perPage === 'all' || filteredCards.length <= perPage) {
                        return;
                    }

                    const totalPages = Math.ceil(filteredCards.length / perPage);
                    
                    // Prev button
                    const prevBtn = document.createElement('button');
                    prevBtn.className = `px-4 py-1.5 rounded-full border border-slate-200 text-slate-700 font-semibold text-xs flex items-center gap-1 transition cursor-pointer bg-white hover:bg-slate-50`;
                    prevBtn.innerHTML = `<i class="ph ph-caret-left"></i> {{ __('Sebelumnya') }}`;
                    if (currentPage === 1) {
                        prevBtn.classList.add('opacity-50', 'pointer-events-none');
                    } else {
                        prevBtn.addEventListener('click', () => {
                            currentPage--;
                            renderResults();
                            scrollToModalTop();
                        });
                    }
                    paginationEl.appendChild(prevBtn);

                    // Page buttons (max 5 buttons on desktop, 4 on mobile/HP)
                    const isMobile = window.innerWidth < 640;
                    const maxButtons = isMobile ? 4 : 5;
                    const half = Math.floor(maxButtons / 2);
                    let startPage = Math.max(1, currentPage - (maxButtons - 1 - half));
                    let endPage = Math.min(totalPages, startPage + (maxButtons - 1));
                    if (endPage - startPage < (maxButtons - 1)) {
                        startPage = Math.max(1, endPage - (maxButtons - 1));
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        const pageBtn = document.createElement('button');
                        if (i === currentPage) {
                            pageBtn.className = `w-8 h-8 rounded-full bg-[#106c38] text-white flex items-center justify-center font-bold text-xs border-none cursor-default`;
                            pageBtn.innerText = i;
                        } else {
                            pageBtn.className = `w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center font-semibold text-xs cursor-pointer hover:bg-slate-50 transition`;
                            pageBtn.innerText = i;
                            pageBtn.addEventListener('click', () => {
                                currentPage = i;
                                renderResults();
                                scrollToModalTop();
                            });
                        }
                        paginationEl.appendChild(pageBtn);
                    }

                    // Next button
                    const nextBtn = document.createElement('button');
                    nextBtn.className = `px-4 py-1.5 rounded-full border border-slate-200 text-slate-700 font-semibold text-xs flex items-center gap-1 transition cursor-pointer bg-white hover:bg-slate-50`;
                    nextBtn.innerHTML = `{{ __('Berikutnya') }} <i class="ph ph-caret-right"></i>`;
                    if (currentPage === totalPages) {
                        nextBtn.classList.add('opacity-50', 'pointer-events-none');
                    } else {
                        nextBtn.addEventListener('click', () => {
                            currentPage++;
                            renderResults();
                            scrollToModalTop();
                        });
                    }
                    paginationEl.appendChild(nextBtn);
                }
            }

            function scrollToModalTop() {
                const modalBody = document.getElementById('modal-hasil-body');
                if (modalBody) {
                    modalBody.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }

            // Live Search input listener
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim().toLowerCase();
                    
                    if (query === '') {
                        filteredCards = allCards;
                        if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
                    } else {
                        if (clearSearchBtn) clearSearchBtn.classList.remove('hidden');
                        filteredCards = allCards.filter(card => {
                            const title = card.getAttribute('data-title') || '';
                            const author = card.getAttribute('data-author') || '';
                            const publisher = card.getAttribute('data-publisher') || '';
                            
                            if (typeof window.isFuzzyMatch === 'function') {
                                return window.isFuzzyMatch(title, query) || 
                                       window.isFuzzyMatch(author, query) || 
                                       window.isFuzzyMatch(publisher, query);
                            }
                            return title.includes(query) || author.includes(query) || publisher.includes(query);
                        });
                    }
                    
                    currentPage = 1;
                    renderResults();
                });
            }

            // Clear search button listener
            if (clearSearchBtn) {
                clearSearchBtn.addEventListener('click', function() {
                    if (searchInput) {
                        searchInput.value = '';
                        searchInput.dispatchEvent(new Event('input'));
                        searchInput.focus();
                    }
                });
            }

            // PerPage dropdown listener
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const val = this.value;
                    if (val === 'all') {
                        perPage = 'all';
                    } else {
                        perPage = parseInt(val, 10);
                    }
                    currentPage = 1;
                    renderResults();
                });
            }

            // Custom Dropdown UI Handler for Modal
            const modalDropdownTrigger = document.getElementById('modal-dropdown-trigger');
            const modalDropdownMenu = document.getElementById('modal-dropdown-menu');
            const modalDropdownOptions = document.querySelectorAll('.modal-dropdown-option');
            const modalDropdownLabel = document.getElementById('modal-dropdown-selected-label');

            if (modalDropdownTrigger && modalDropdownMenu) {
                modalDropdownTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    modalDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', () => {
                    modalDropdownMenu.classList.add('hidden');
                });

                modalDropdownOptions.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        const val = opt.getAttribute('data-value');
                        const labelText = opt.querySelector('span').textContent.trim();
                        
                        modalDropdownLabel.textContent = labelText;
                        perPageSelect.value = val;
                        
                        // Update active state in UI
                        modalDropdownOptions.forEach(o => {
                            const check = o.querySelector('.modal-active-check');
                            if (o === opt) {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });

                        // Trigger change event programmatically
                        const changeEvent = new Event('change');
                        perPageSelect.dispatchEvent(changeEvent);
                        
                        modalDropdownMenu.classList.add('hidden');
                    });
                });
            }

            // Mobile locations carousel & expand functionality
            const track = document.getElementById('mobile-carousel-track');
            const dots = document.querySelectorAll('#carousel-dots .dot');
            const btnPrev = document.getElementById('btn-mobile-prev');
            const btnNext = document.getElementById('btn-mobile-next');
            const btnExpand = document.getElementById('btn-mobile-expand');
            const btnCollapse = document.getElementById('btn-mobile-collapse');
            const carouselContainer = document.getElementById('locations-mobile');
            const expandContainer = document.getElementById('mobile-expand-container');
            const expandedContainer = document.getElementById('locations-mobile-expanded');

            let currentSlide = 0;
            const totalSlides = dots.length;

            function goToSlide(slideIndex) {
                if (slideIndex < 0 || slideIndex >= totalSlides) return;
                currentSlide = slideIndex;
                
                if (track) {
                    track.style.transform = `translateX(-${slideIndex * 100}%)`;
                }

                // Update dots
                dots.forEach((dot, idx) => {
                    if (idx === slideIndex) {
                        dot.classList.remove('bg-slate-300');
                        dot.classList.add('bg-[#106c38]', 'scale-110');
                    } else {
                        dot.classList.remove('bg-[#106c38]', 'scale-110');
                        dot.classList.add('bg-slate-300');
                    }
                });

                // Enable/disable buttons
                if (btnPrev) btnPrev.disabled = (slideIndex === 0);
                if (btnNext) btnNext.disabled = (slideIndex === totalSlides - 1);
            }

            if (btnPrev) {
                btnPrev.addEventListener('click', () => {
                    goToSlide(currentSlide - 1);
                });
            }

            if (btnNext) {
                btnNext.addEventListener('click', () => {
                    goToSlide(currentSlide + 1);
                });
            }

            if (btnExpand) {
                btnExpand.addEventListener('click', () => {
                    if (carouselContainer) carouselContainer.classList.add('hidden');
                    if (expandContainer) expandContainer.classList.add('hidden');
                    if (expandedContainer) {
                        expandedContainer.classList.remove('hidden');
                        expandedContainer.classList.add('block');
                    }
                });
            }

            if (btnCollapse) {
                btnCollapse.addEventListener('click', () => {
                    if (expandedContainer) {
                        expandedContainer.classList.remove('block');
                        expandedContainer.classList.add('hidden');
                    }
                    if (carouselContainer) carouselContainer.classList.remove('hidden');
                    if (expandContainer) expandContainer.classList.remove('hidden');
                });
            }

            // ─── 3D Koleksi Terbaru Carousel ───────────────────────────────────────
            const newestSlides = document.querySelectorAll('.carousel-slide');
            if (newestSlides.length > 0) {
                let newestCurrentIndex = 0;
                const newestTotalSlides = newestSlides.length;
                let newestAutoScroll;

                function updateNewestCarousel() {
                    newestSlides.forEach((slide, idx) => {
                        slide.className = 'carousel-slide absolute transition-all duration-500 ease-in-out';
                        let diff = idx - newestCurrentIndex;
                        if (diff < -newestTotalSlides / 2) diff += newestTotalSlides;
                        else if (diff > newestTotalSlides / 2) diff -= newestTotalSlides;

                        if (diff === 0)       slide.classList.add('active');
                        else if (diff === -1) slide.classList.add('prev');
                        else if (diff === 1)  slide.classList.add('next');
                        else if (diff < 0)   slide.classList.add('hidden-left');
                        else                 slide.classList.add('hidden-right');
                    });
                }

                function newestNextSlide() {
                    newestCurrentIndex = (newestCurrentIndex + 1) % newestTotalSlides;
                    updateNewestCarousel();
                }

                function newestPrevSlide() {
                    newestCurrentIndex = (newestCurrentIndex - 1 + newestTotalSlides) % newestTotalSlides;
                    updateNewestCarousel();
                }

                function startNewestAutoPlay() {
                    newestAutoScroll = setInterval(newestNextSlide, 4500);
                }

                function resetNewestAutoPlay() {
                    clearInterval(newestAutoScroll);
                    startNewestAutoPlay();
                }

                // Nav buttons
                const prevBtnKoleksi = document.getElementById('prev-btn-koleksi');
                const nextBtnKoleksi = document.getElementById('next-btn-koleksi');
                if (prevBtnKoleksi) prevBtnKoleksi.addEventListener('click', (e) => { e.stopPropagation(); newestPrevSlide(); resetNewestAutoPlay(); });
                if (nextBtnKoleksi) nextBtnKoleksi.addEventListener('click', (e) => { e.stopPropagation(); newestNextSlide(); resetNewestAutoPlay(); });

                // Click on prev/next cards to navigate
                newestSlides.forEach((slide) => {
                    slide.addEventListener('click', (e) => {
                        if (slide.classList.contains('prev')) { e.preventDefault(); newestPrevSlide(); resetNewestAutoPlay(); }
                        else if (slide.classList.contains('next')) { e.preventDefault(); newestNextSlide(); resetNewestAutoPlay(); }
                    });
                });

                // Initialize
                updateNewestCarousel();
                if (window.innerWidth >= 1024) {
                    startNewestAutoPlay();
                }

                // Pause on hover
                const carouselTrack = document.getElementById('carousel-koleksi-track');
                if (carouselTrack) {
                    carouselTrack.addEventListener('mouseenter', () => {
                        if (window.innerWidth >= 1024) clearInterval(newestAutoScroll);
                    });
                    carouselTrack.addEventListener('mouseleave', () => {
                        if (window.innerWidth >= 1024) resetNewestAutoPlay();
                    });
                }

                // Window resize handler to toggle auto scroll based on screen width
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        if (!newestAutoScroll) startNewestAutoPlay();
                    } else {
                        if (newestAutoScroll) {
                            clearInterval(newestAutoScroll);
                            newestAutoScroll = null;
                        }
                    }
                });

                // ── Touch / Pointer Swipe with Velocity (All Screens) ─────────────
                const carouselWrapper = carouselTrack ? carouselTrack.parentElement : null;

                if (carouselWrapper) {
                    let pStartX = 0;
                    let pStartY = 0;
                    let pStartTime = 0;
                    let pMoved  = false;
                    let pIsTouch = false;
                    const SWIPE_MIN = 40;

                    // Prevent native browser link/image dragging to avoid cancelling pointers
                    carouselWrapper.querySelectorAll('a, img').forEach(el => {
                        el.setAttribute('draggable', 'false');
                    });
                    carouselWrapper.addEventListener('dragstart', (e) => {
                        e.preventDefault();
                    });

                    carouselWrapper.addEventListener('pointerdown', (e) => {
                        pIsTouch = e.pointerType === 'touch' || e.pointerType === 'pen' || e.pointerType === 'mouse';
                        pStartX = e.clientX;
                        pStartY = e.clientY;
                        pStartTime = Date.now();
                        pMoved  = false;
                    }, { passive: true });

                    carouselWrapper.addEventListener('pointermove', (e) => {
                        const dx = Math.abs(e.clientX - pStartX);
                        const dy = Math.abs(e.clientY - pStartY);
                        if (dx > 8 && dx > dy) pMoved = true;
                    }, { passive: true });

                    carouselWrapper.addEventListener('pointerup', (e) => {
                        const dx = e.clientX - pStartX;
                        const duration = Date.now() - pStartTime;
                        const distance = Math.abs(dx);
                        
                        if (pMoved && distance >= SWIPE_MIN) {
                            const velocity = distance / duration;
                            
                            // On mobile/tablet, support scrolling multiple slides if swiped quickly
                            let slidesToScroll = 1;
                            if (window.innerWidth < 1024) {
                                if (velocity > 1.2) {
                                    slidesToScroll = 3;
                                } else if (velocity > 0.6) {
                                    slidesToScroll = 2;
                                }
                            }

                            let count = 0;
                            function stepScroll() {
                                if (count < slidesToScroll) {
                                    if (dx < 0) newestNextSlide();
                                    else newestPrevSlide();
                                    count++;
                                    setTimeout(stepScroll, 120); // clean rolling delay for stacked cards
                                }
                            }
                            stepScroll();
                            resetNewestAutoPlay();
                        }
                        pMoved = false;
                    }, { passive: true });

                    carouselWrapper.addEventListener('pointercancel', () => {
                        pMoved = false;
                    }, { passive: true });

                    carouselWrapper.addEventListener('click', (e) => {
                        if (pMoved) {
                            e.preventDefault();
                            e.stopImmediatePropagation();
                        }
                    }, true);
                }
            }
            // Location grid toggle functionality
            const btnToggleLocations = document.getElementById('btn-toggle-locations');
            const marqueeView = document.getElementById('marquee-locations-container');
            const gridView = document.getElementById('expanded-locations-grid');
            const iconToggleLoc = document.getElementById('icon-toggle-locations');
            const textToggleLoc = document.getElementById('text-toggle-locations');

            if (btnToggleLocations) {
                btnToggleLocations.addEventListener('click', function() {
                    if (gridView.classList.contains('hidden')) {
                        // Show grid, hide marquee
                        marqueeView.classList.add('hidden');
                        gridView.classList.remove('hidden');
                        
                        // Small delay for transition
                        setTimeout(() => {
                            gridView.classList.remove('opacity-0', '-translate-y-4');
                            gridView.classList.add('opacity-100', 'translate-y-0');
                        }, 10);
                        
                        iconToggleLoc.classList.replace('ph-caret-down', 'ph-caret-up');
                        textToggleLoc.textContent = '{{ __("Sembunyikan") }}';
                    } else {
                        // Hide grid, show marquee
                        gridView.classList.remove('opacity-100', 'translate-y-0');
                        gridView.classList.add('opacity-0', '-translate-y-4');
                        
                        setTimeout(() => {
                            gridView.classList.add('hidden');
                            marqueeView.classList.remove('hidden');
                        }, 300); // match transition duration
                        
                        iconToggleLoc.classList.replace('ph-caret-up', 'ph-caret-down');
                        textToggleLoc.textContent = '{{ __("Lihat Semua") }}';
                    }
                });
            }
        });
    </script>
</body>
</html>
