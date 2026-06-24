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
        <div class="relative z-10 flex flex-col justify-start pt-6 pb-2 w-full">
            <!-- Search Area -->
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-4 w-full">
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex items-center focus-within:ring-4 focus-within:ring-[#106c38]/30 transition-all">
                    <div class="pl-5 text-slate-400">
                        <i class="ph ph-magnifying-glass text-2xl"></i>
                    </div>
                    <input type="text" name="q" placeholder="{{ __('Cari buku, jurnal, penulis, atau kata kunci...') }}" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 px-4 py-4 text-lg outline-none">
                    <button type="submit" class="bg-[#106c38] text-white rounded-xl px-8 py-4 font-semibold text-lg hover:bg-green-800 transition shadow-lg shadow-[#106c38]/30">
                        {{ __('Cari') }}
                    </button>
                </form>
                <div class="mt-3">
                    <button id="open-modal-pencarian-spesifik" class="text-green-200 hover:text-white transition text-sm font-medium flex items-center justify-center gap-1 mx-auto bg-transparent border-none outline-none cursor-pointer">
                        {{ __('Pencarian Spesifik') }} <i class="ph ph-arrow-right"></i>
                    </button>
                </div>
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

    <!-- Statistics Section -->
    <div id="statistics-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-20">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">{{ __('Jumlah Judul Buku Berdasarkan Lokasi') }}</h2>
            <div class="w-24 h-1 bg-[#106c38] mx-auto rounded-full"></div>
            <p class="mt-4 text-slate-500">{{ __('Koleksi tersebar di berbagai fakultas dan perpustakaan pusat') }}</p>
        </div>

        <!-- Desktop Grid (Hidden on Mobile) -->
        <div id="locations-desktop" class="hidden md:grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($locations as $stat)
            <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300 block">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph {{ $stat->icon }} text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">{{ __($stat->name) }}</p>
            </a>
            @endforeach
        </div>

        <!-- Mobile Carousel View (Hidden on Desktop) -->
        <div id="locations-mobile" class="block md:hidden relative overflow-hidden">
            <!-- Carousel Track -->
            <div id="mobile-carousel-track" class="flex transition-transform duration-500 ease-in-out">
                @foreach($locations->chunk(6) as $chunkIndex => $chunk)
                <div class="w-full flex-shrink-0 grid grid-cols-2 gap-4 px-2">
                    @foreach($chunk as $stat)
                    <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-4 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300 block">
                        <div class="absolute top-0 right-0 p-2 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                            <i class="ph {{ $stat->icon }} text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-1">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300 leading-tight">{{ __($stat->name) }}</p>
                    </a>
                    @endforeach
                </div>
                @endforeach
            </div>

            <!-- Carousel Navigation Controls -->
            <div id="mobile-carousel-nav" class="flex items-center justify-between mt-6 px-4">
                <button id="btn-mobile-prev" class="w-10 h-10 bg-white text-[#106c38] rounded-full shadow-md flex items-center justify-center border border-slate-100 disabled:opacity-40" disabled>
                    <i class="ph ph-caret-left text-xl font-bold"></i>
                </button>
                
                <!-- Dots Indicator -->
                <div class="flex gap-2" id="carousel-dots">
                    @foreach($locations->chunk(6) as $chunkIndex => $chunk)
                    <span class="dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $chunkIndex === 0 ? 'bg-[#106c38] scale-110' : 'bg-slate-300' }}"></span>
                    @endforeach
                </div>

                <button id="btn-mobile-next" class="w-10 h-10 bg-white text-[#106c38] rounded-full shadow-md flex items-center justify-center border border-slate-100">
                    <i class="ph ph-caret-right text-xl font-bold"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Expand Button Container -->
        <div id="mobile-expand-container" class="block md:hidden mt-6 text-center">
            <button id="btn-mobile-expand" class="inline-flex items-center gap-2 bg-white hover:bg-[#106c38] text-[#106c38] hover:text-white px-6 py-3 rounded-full font-bold text-xs tracking-wider uppercase border-2 border-[#106c38]/20 hover:border-[#106c38] transition shadow-md focus:outline-none cursor-pointer">
                {{ __('Tampilkan Semua Kebawah') }} <i class="ph ph-arrow-down-right"></i>
            </button>
        </div>

        <!-- Mobile Expanded View (Hidden by default) -->
        <div id="locations-mobile-expanded" class="hidden md:hidden">
            <div class="grid grid-cols-2 gap-4 px-2">
                @foreach($locations as $stat)
                <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-4 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300 block">
                    <div class="absolute top-0 right-0 p-2 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                        <i class="ph {{ $stat->icon }} text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-1">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300 leading-tight">{{ $stat->name }}</p>
                </a>
                @endforeach
            </div>
            
            <div class="mt-6 text-center">
                <button id="btn-mobile-collapse" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 px-6 py-3 rounded-full font-bold text-xs tracking-wider uppercase border-2 border-slate-200 transition shadow-md focus:outline-none cursor-pointer">
                    {{ __('Kembalikan ke Slider') }} <i class="ph ph-arrow-up-left"></i>
                </button>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#064e3b] to-[#022c22] border-t-4 border-[#106c38] mt-12 py-10 relative overflow-hidden">
        <!-- Abstract Shapes in Footer -->
        <div class="absolute top-0 right-0 w-full h-full overflow-hidden z-0 pointer-events-none opacity-20">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-400 rounded-full mix-blend-multiply filter blur-2xl"></div>
            <div class="absolute bottom-0 left-1/4 w-60 h-60 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1.5 rounded-full shadow-lg">
                    <img src="{{ asset('logousu.jpeg') }}" alt="USU Logo" class="w-10 h-10">
                </div>
                <div>
                    <p class="text-white font-bold text-lg tracking-wide">{{ __('Perpustakaan Universitas Sumatera Utara') }}</p>
                    <p class="text-green-200/80 text-sm">© 2026 OPAC Redesign Project</p>
                </div>
            </div>
        </div>
    </footer>

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
        });
    </script>
</body>
</html>
