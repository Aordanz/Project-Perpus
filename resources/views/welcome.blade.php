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

        /* Mobile positions */
        .carousel-slide.prev {
            opacity: 0.8;
            transform: translate(-210%, -50%) scale(0.8);
            z-index: 20;
            pointer-events: auto;
            cursor: pointer;
        }

        .carousel-slide.next {
            opacity: 0.8;
            transform: translate(110%, -50%) scale(0.8);
            z-index: 20;
            pointer-events: auto;
            cursor: pointer;
        }

        .carousel-slide.hidden-left {
            opacity: 0;
            transform: translate(-300%, -50%) scale(0.5);
            z-index: 10;
            pointer-events: none;
        }

        .carousel-slide.hidden-right {
            opacity: 0;
            transform: translate(200%, -50%) scale(0.5);
            z-index: 10;
            pointer-events: none;
        }

        /* Desktop positions */
        @media (min-width: 640px) {
            .carousel-slide.active {
                transform: translate(-50%, -50%) scale(1);
            }

            .carousel-slide.prev {
                opacity: 0.85;
                transform: translate(-215%, -50%) scale(0.8);
            }

            .carousel-slide.next {
                opacity: 0.85;
                transform: translate(115%, -50%) scale(0.8);
            }

            .carousel-slide.hidden-left {
                transform: translate(-315%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(215%, -50%) scale(0.5);
            }
        }

        @media (min-width: 768px) {
            .carousel-slide.prev {
                opacity: 0.85;
                transform: translate(-220%, -50%) scale(0.85);
            }

            .carousel-slide.next {
                opacity: 0.85;
                transform: translate(120%, -50%) scale(0.85);
            }

            .carousel-slide.hidden-left {
                transform: translate(-320%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(220%, -50%) scale(0.5);
            }
        }

        @media (min-width: 1024px) {
            .carousel-slide.prev {
                opacity: 0.9;
                transform: translate(-225%, -50%) scale(0.85);
            }

            .carousel-slide.next {
                opacity: 0.9;
                transform: translate(125%, -50%) scale(0.85);
            }

            .carousel-slide.hidden-left {
                transform: translate(-325%, -50%) scale(0.5);
            }

            .carousel-slide.hidden-right {
                transform: translate(225%, -50%) scale(0.5);
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

        .carousel-slide.active .info-panel {
            width: 150px;
            max-width: 150px;
            opacity: 1;
            padding: 1rem;
            border-left: 1px solid rgba(0, 0, 0, 0.08);
        }

        @media (min-width: 640px) {
            .carousel-slide.active .info-panel {
                width: 300px;
                max-width: 300px;
                padding: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .carousel-slide.active .info-panel {
                width: 360px;
                max-width: 360px;
                padding: 2rem;
            }
        }

        @media (min-width: 1024px) {
            .carousel-slide.active .info-panel {
                width: 400px;
                max-width: 400px;
                padding: 2rem;
            }
        }
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
                <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-xl">
                    <div class="flex-grow relative flex items-center bg-white rounded-xl border border-transparent overflow-hidden focus-within:ring-2 focus-within:ring-[#106c38]/20 transition-all">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                        </div>
                        <input type="text" name="q" placeholder="{{ __('Cari buku, jurnal, penulis, atau kata kunci...') }}" class="w-full pl-11 pr-4 py-3 sm:py-4 bg-transparent border-0 focus:ring-0 focus:border-0 outline-none text-slate-800 placeholder-slate-400 text-sm sm:text-base font-medium">
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
                        {{ __('Koleksi Baru') }}
                    </h3>
                </div>

                <!-- Carousel Area -->
                <div class="relative w-full h-[340px] sm:h-[390px] md:h-[420px] flex items-center justify-center overflow-hidden">
                    <!-- Left Navigation Button -->
                    <button id="prev-btn-koleksi" class="absolute left-2 sm:left-6 md:left-10 lg:left-12 xl:left-16 z-40 w-10 h-10 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full flex items-center justify-center transition-all cursor-pointer">
                        <i class="ph ph-caret-left text-xl font-bold"></i>
                    </button>

                    <!-- Slides Track -->
                    <div id="carousel-koleksi-track" class="relative w-full h-full flex items-center justify-center">
                        @foreach ($latestBooks as $index => $book)
                        <div class="carousel-slide absolute transition-all duration-500 ease-in-out opacity-0 pointer-events-none" data-index="{{ $index }}">
                            <div class="flex bg-white/95 backdrop-blur-md border border-slate-200/80 rounded-2xl overflow-hidden shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] transition-all duration-500 max-w-[90vw] md:max-w-4xl">
                                <!-- Cover Panel -->
                                <div class="w-[110px] sm:w-[190px] md:w-[210px] flex-shrink-0 aspect-[2/3] bg-slate-50 relative overflow-hidden flex items-center justify-center p-3 sm:p-5 border-r border-slate-100">
                                    @if ($book->cover_image)
                                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 border border-dashed border-slate-200 rounded-lg bg-slate-100/50">
                                            <i class="ph ph-book-open text-4xl sm:text-5xl mb-2 text-[#106c38]"></i>
                                            <span class="text-[9px] sm:text-xs font-semibold text-slate-500 text-center leading-tight">{{ __('Cover Buku') }}</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-red-600 text-white text-[8px] sm:text-[9px] font-bold px-1.5 py-0.5 rounded shadow">NEW</span>
                                </div>

                                <!-- Info Panel (Slides out when active) -->
                                <div class="info-panel flex flex-col justify-between text-left">
                                    <div class="overflow-hidden">
                                        <!-- Category -->
                                        <span class="inline-block px-2.5 py-0.5 bg-green-50 text-[#106c38] border border-green-200/60 text-[8px] sm:text-[9px] font-bold rounded-full uppercase tracking-wider mb-2 sm:mb-3">
                                            {{ $book->category ?: 'GENERAL' }}
                                        </span>
                                        <!-- Title -->
                                        <h4 class="text-sm sm:text-base md:text-xl font-bold text-slate-900 leading-snug mb-1 sm:mb-2 line-clamp-2" title="{{ $book->title }}">
                                            {{ $book->title }}
                                        </h4>
                                        <!-- Author (Mobile only) -->
                                        <p class="text-[9px] sm:hidden text-slate-500 mb-2 truncate">
                                            {{ __('Penulis:') }} <span class="text-[#106c38] font-bold">{{ $book->author ?: '-' }}</span>
                                        </p>
                                        <!-- Short description -->
                                        <p class="text-xs sm:text-sm text-slate-600 mb-3 sm:mb-5 leading-relaxed line-clamp-2 sm:line-clamp-3">
                                            {{ $book->physical_description ?: 'Koleksi literatur terbaru Perpustakaan Universitas Sumatera Utara yang siap mendukung riset, studi, dan referensi akademik Anda.' }}
                                        </p>

                                        <!-- Metadata Grid (Tablet/Desktop) -->
                                        <div class="hidden sm:grid grid-cols-2 gap-x-6 gap-y-3 border-t border-slate-100 pt-4 mb-2 text-xs sm:text-sm">
                                            <div>
                                                <span class="block text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Penulis') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate" title="{{ $book->author }}">{{ $book->author ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Klasifikasi') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate">{{ $book->classification ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Penerbit') }}</span>
                                                <span class="text-slate-800 font-semibold block truncate" title="{{ $book->publisher }}">{{ $book->publisher ?: '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ __('Tahun Terbit') }}</span>
                                                <span class="text-slate-800 font-semibold block">{{ $book->publish_year ?: '-' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Footer -->
                                    <div class="flex justify-between items-center border-t border-slate-100 pt-3 mt-auto">
                                        <span class="text-[10px] sm:text-xs font-mono text-slate-500 font-medium">
                                            <span class="text-[#106c38] font-bold">{{ $index + 1 }}</span> / {{ count($latestBooks) }}
                                        </span>
                                        <a href="{{ route('books.show', $book->id) }}" class="w-8 h-8 sm:w-10 sm:h-10 bg-[#106c38] hover:bg-green-700 text-white rounded-full flex items-center justify-center transition-all hover:scale-105 shadow-lg shadow-green-600/20 cursor-pointer">
                                            <i class="ph ph-arrow-right text-base sm:text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Right Navigation Button -->
                    <button id="next-btn-koleksi" class="absolute right-2 sm:right-6 md:left-auto md:right-10 lg:right-12 xl:right-16 z-40 w-10 h-10 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full flex items-center justify-center transition-all cursor-pointer">
                        <i class="ph ph-caret-right text-xl font-bold"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section (Marquee) -->
    <div id="statistics-section" class="pt-6 pb-6 w-full overflow-hidden bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 relative flex flex-col items-center justify-center">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-slate-800 mb-3">{{ __('Jumlah Judul Buku Berdasarkan Lokasi') }}</h2>
                <div class="w-24 h-1 bg-[#106c38] mx-auto rounded-full"></div>
            </div>
            <div class="mt-5 sm:mt-0 sm:absolute sm:right-8 sm:top-0 sm:bottom-0 flex items-center justify-center">
                <button id="btn-toggle-locations" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-[#106c38] px-6 py-2.5 rounded-full font-bold text-sm tracking-wider uppercase border-2 border-[#106c38]/20 hover:border-[#106c38] transition shadow-sm focus:outline-none cursor-pointer">
                    <span id="text-toggle-locations">{{ __('Lihat Semua') }}</span> 
                    <i class="ph ph-caret-down text-lg transition-transform duration-300" id="icon-toggle-locations"></i>
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
                    <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="bg-white rounded-xl p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 w-[280px] shrink-0 h-[100px]">
                        
                        <!-- Orange glow at bottom right -->
                        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                        <div class="flex flex-col z-10 max-w-[75%]">
                            <h3 class="text-[26px] font-bold text-[#064e3b] mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                            <p class="text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                        </div>
                        
                        <div class="text-[#064e3b] z-10 opacity-90">
                            <i class="ph {{ $stat->icon }} text-[42px]"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
                <!-- Duplicated Set for Loop -->
                <div class="flex gap-6 shrink-0">
                    @foreach($locations as $stat)
                    <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="bg-white rounded-xl p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 w-[280px] shrink-0 h-[100px]">
                        
                        <!-- Orange glow at bottom right -->
                        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                        <div class="flex flex-col z-10 max-w-[75%]">
                            <h3 class="text-[26px] font-bold text-[#064e3b] mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                            <p class="text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                        </div>
                        
                        <div class="text-[#064e3b] z-10 opacity-90">
                            <i class="ph {{ $stat->icon }} text-[42px]"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Expanded Grid View (Hidden by default) -->
        <div id="expanded-locations-grid" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 hidden transition-all duration-500 opacity-0 transform -translate-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 pt-2">
                @foreach($locations as $stat)
                <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="bg-white rounded-xl p-6 border border-slate-200/80 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] relative overflow-hidden flex items-center justify-between group cursor-pointer transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] hover:-translate-y-1 h-[100px] w-full">
                    
                    <!-- Orange glow at bottom right -->
                    <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-orange-400/50 to-transparent rounded-full blur-xl group-hover:from-orange-400/70 transition-all duration-300"></div>

                    <div class="flex flex-col z-10 max-w-[75%]">
                        <h3 class="text-[26px] font-bold text-[#064e3b] mb-1 tracking-tight">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                        <p class="text-xs font-semibold text-[#064e3b] leading-tight">{{ __($stat->name) }}</p>
                    </div>
                    
                    <div class="text-[#064e3b] z-10 opacity-90">
                        <i class="ph {{ $stat->icon }} text-[42px]"></i>
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
    </style>

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
                            <input type="text" name="inJudul" placeholder="e.g. Metode Penelitian Hukum" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Pengarang -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Pengarang') }}</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-user text-xl"></i>
                            </div>
                            <input type="text" name="inPengarang1" placeholder="e.g. Prof. Soerjono Soekanto" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inPenerbit" placeholder="e.g. Rajawali Pers" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Subyek') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-tag text-xl"></i>
                                </div>
                                <input type="text" name="inSubyek" placeholder="e.g. Hukum Perdata" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="intahunterbit" placeholder="e.g. 2023" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('ISBN') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-barcode text-xl"></i>
                                </div>
                                <input type="text" name="inisbn" placeholder="e.g. 978-602-8512-30-4" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                <input type="text" name="inKlasifikasi" placeholder="e.g. 340" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-slate-500 pl-1">{{ __('Barcode') }}</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-slate-400">
                                    <i class="ph ph-qr-code text-xl"></i>
                                </div>
                                <input type="text" name="inbarcode" placeholder="e.g. 120930193" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
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
                                        <option value="{{ $loc->code }}">{{ __($loc->name) }}</option>
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
                                    <option value="buku">{{ __('Buku') }}</option>
                                    <option value="jurnal">{{ __('Jurnal') }}</option>
                                    <option value="majalah">{{ __('Majalah') }}</option>
                                    <option value="skripsi">{{ __('Skripsi/Tesis/Disertasi') }}</option>
                                    <option value="laporan_penelitian">{{ __('Laporan Penelitian') }}</option>
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

            // 3D Koleksi Terbaru Carousel
            const newestSlides = document.querySelectorAll('.carousel-slide');
            if (newestSlides.length > 0) {
                let newestCurrentIndex = 0;
                const newestTotalSlides = newestSlides.length;
                let newestAutoScroll;

                function updateNewestCarousel() {
                    newestSlides.forEach((slide, idx) => {
                        slide.className = 'carousel-slide absolute transition-all duration-500 ease-in-out';
                        
                        let diff = idx - newestCurrentIndex;
                        
                        // Handle circular index wrapping
                        if (diff < -newestTotalSlides / 2) {
                            diff += newestTotalSlides;
                        } else if (diff > newestTotalSlides / 2) {
                            diff -= newestTotalSlides;
                        }

                        if (diff === 0) {
                            slide.classList.add('active');
                        } else if (diff === -1) {
                            slide.classList.add('prev');
                        } else if (diff === 1) {
                            slide.classList.add('next');
                        } else if (diff < 0) {
                            slide.classList.add('hidden-left');
                        } else {
                            slide.classList.add('hidden-right');
                        }
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

                const prevBtnKoleksi = document.getElementById('prev-btn-koleksi');
                const nextBtnKoleksi = document.getElementById('next-btn-koleksi');

                if (prevBtnKoleksi) {
                    prevBtnKoleksi.addEventListener('click', (e) => {
                        e.stopPropagation();
                        newestPrevSlide();
                        resetNewestAutoPlay();
                    });
                }

                if (nextBtnKoleksi) {
                    nextBtnKoleksi.addEventListener('click', (e) => {
                        e.stopPropagation();
                        newestNextSlide();
                        resetNewestAutoPlay();
                    });
                }

                // Click on adjacent slides to move to them
                newestSlides.forEach((slide, idx) => {
                    slide.addEventListener('click', (e) => {
                        if (slide.classList.contains('prev')) {
                            e.preventDefault();
                            newestPrevSlide();
                            resetNewestAutoPlay();
                        } else if (slide.classList.contains('next')) {
                            e.preventDefault();
                            newestNextSlide();
                            resetNewestAutoPlay();
                        }
                    });
                });

                function startNewestAutoPlay() {
                    newestAutoScroll = setInterval(newestNextSlide, 4500);
                }

                function resetNewestAutoPlay() {
                    clearInterval(newestAutoScroll);
                    startNewestAutoPlay();
                }

                // Initialize
                updateNewestCarousel();
                startNewestAutoPlay();

                // Pause on hover
                const carouselTrack = document.getElementById('carousel-koleksi-track');
                if (carouselTrack) {
                    carouselTrack.addEventListener('mouseenter', () => clearInterval(newestAutoScroll));
                    carouselTrack.addEventListener('mouseleave', resetNewestAutoPlay);
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
