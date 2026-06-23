<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OPAC - Universitas Sumatera Utara</title>

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
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        }
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #106c38;
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900">

    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Links -->
                <div class="flex items-center gap-8">
                    <a href="#" class="flex items-center gap-2">
                        <img src="{{ asset('logo usu.jpeg') }}" alt="USU Logo" class="h-10 w-auto">
                        <div class="flex flex-col hidden sm:flex">
                            <span class="font-bold text-slate-800 leading-none text-sm">Universitas</span>
                            <span class="font-bold text-slate-800 leading-none text-sm">Sumatera Utara</span>
                        </div>
                    </a>
                    <div class="hidden lg:flex space-x-6 items-center">
                    <a href="#" class="text-[#106c38] font-semibold text-sm hover:text-green-900 transition">Beranda</a>
                    <a href="#" class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition">Koleksi Terbaru</a>
                    <a href="#" class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition">Index Judul</a>
                    <div class="relative group">
                        <button class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition flex items-center gap-1">
                            Tautan Lain <i class="ph ph-caret-down"></i>
                        </button>
                    </div>
                    <a href="#" class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition">Cek Pinjaman</a>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="hidden md:flex space-x-5 items-center">
                    <a href="#" class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition">Bantuan</a>
                    <a href="#" class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition">Kontak Kami</a>
                    <button class="text-slate-600 font-medium text-sm hover:text-[#106c38] transition flex items-center gap-1">
                        <i class="ph ph-translate text-lg"></i> Bahasa
                    </button>
                    <a href="#" class="bg-[#106c38] text-white px-5 py-2 rounded-full font-medium text-sm shadow-md shadow-green-700/30 hover:bg-green-800 hover:shadow-green-800/50 transition-all">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient pt-32 pb-24 relative overflow-hidden">
        <!-- Background Image of USU Pond with Low Opacity Overlay -->
        <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-35" style="background-image: url('{{ asset('kolam_perpustakaan.jpg') }}');"></div>

        <!-- Abstract Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none opacity-40">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-12 -right-12 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 backdrop-blur-md mb-8">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <img src="{{ asset('logo-usu.png') }}" alt="USU Logo" class="w-6 h-6">
                </div>
                <span class="text-white/90 text-sm font-medium tracking-wide">Universitas Sumatera Utara Library</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold text-white tracking-tight mb-4">
                O P A C
            </h1>
            <p class="text-green-100 text-lg md:text-xl font-light tracking-wide mb-10 max-w-2xl mx-auto">
                Online Public Access Catalog. Jelajahi jutaan koleksi pustaka untuk mendukung riset dan pendidikan Anda.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex items-center focus-within:ring-4 focus-within:ring-[#106c38]/30 transition-all">
                <div class="pl-5 text-slate-400">
                    <i class="ph ph-magnifying-glass text-2xl"></i>
                </div>
                <input type="text" name="q" placeholder="Cari buku, jurnal, penulis, atau kata kunci..." class="w-full bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 px-4 py-4 text-lg outline-none">
                <button type="submit" class="bg-[#106c38] text-white rounded-xl px-8 py-4 font-semibold text-lg hover:bg-green-800 transition shadow-lg shadow-[#106c38]/30">
                    Cari
                </button>
            </form>
            <div class="mt-5">
                <button id="open-modal-pencarian-spesifik" class="text-green-200 hover:text-white transition text-sm font-medium flex items-center justify-center gap-1 mx-auto bg-transparent border-none outline-none cursor-pointer">
                    Pencarian Spesifik <i class="ph ph-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">Jumlah Judul Buku Berdasarkan Lokasi</h2>
            <div class="w-24 h-1 bg-[#106c38] mx-auto rounded-full"></div>
            <p class="mt-4 text-slate-500">Koleksi tersebar di berbagai fakultas dan perpustakaan pusat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($locations as $stat)
            <a href="{{ route('search', ['inLokasi' => $stat->code]) }}" class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300 block">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph {{ $stat->icon }} text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">{{ number_format($stat->items_count, 0, ',', '.') }}</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">{{ $stat->name }}</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Newest Collections Section (Marquee) -->
    <div class="py-16 bg-slate-50 border-t border-slate-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 text-center">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">20 Koleksi Terbaru</h2>
            <div class="w-24 h-1 bg-[#106c38] mx-auto rounded-full"></div>
            <p class="mt-4 text-slate-500">Buku dan literatur terbaru yang baru saja ditambahkan ke katalog kami</p>
        </div>

        <div class="relative max-w-[1400px] mx-auto px-4 sm:px-12 group/slider">
            <!-- Navigation Buttons -->
            <button id="btn-scroll-left" class="absolute left-0 sm:left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white text-[#106c38] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center hover:bg-[#106c38] hover:text-white transition-all border border-slate-100 opacity-0 group-hover/slider:opacity-100 focus:opacity-100 cursor-pointer">
                <i class="ph ph-caret-left text-2xl font-bold"></i>
            </button>
            <button id="btn-scroll-right" class="absolute right-0 sm:right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white text-[#106c38] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center hover:bg-[#106c38] hover:text-white transition-all border border-slate-100 opacity-0 group-hover/slider:opacity-100 focus:opacity-100 cursor-pointer">
                <i class="ph ph-caret-right text-2xl font-bold"></i>
            </button>

            <!-- Fade gradients -->
            <div class="hidden sm:block absolute left-12 top-0 bottom-0 w-24 bg-gradient-to-r from-slate-50 to-transparent z-10 pointer-events-none"></div>
            <div class="hidden sm:block absolute right-12 top-0 bottom-0 w-24 bg-gradient-to-l from-slate-50 to-transparent z-10 pointer-events-none"></div>
            
            <div id="books-scroll-container" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-8 pt-4 px-2 hide-scrollbar items-stretch">
                @for ($repeat = 0; $repeat < 2; $repeat++)
                    @foreach ($latestBooks as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="snap-start w-[160px] flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1 block">
                        <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                            @if ($book->cover_image)
                                <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                                    <i class="ph ph-book-open text-3xl mb-2"></i>
                                    <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                        </div>
                        <div class="flex flex-col flex-grow">
                            <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">{{ $book->title }}</h4>
                            <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">{{ $book->classification }}</p>
                            <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">{{ $book->category }}</p>
                        </div>
                    </a>
                    @endforeach
                @endfor
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('books-scroll-container');
                const btnLeft = document.getElementById('btn-scroll-left');
                const btnRight = document.getElementById('btn-scroll-right');
                
                // Lebar 1 kartu + gap (160px + 20px)
                const scrollAmount = 180; 
                // Jumlah kartu unik sebelum perulangan
                const uniqueItems = 5;
                const batchWidth = scrollAmount * uniqueItems;

                const scrollNext = () => {
                    // Jika mendekati ujung kanan, pindahkan 5 item pertama ke belakang
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - scrollAmount * 2) {
                        container.classList.remove('scroll-smooth');
                        for (let i = 0; i < uniqueItems; i++) {
                            container.appendChild(container.firstElementChild);
                        }
                        container.scrollLeft -= batchWidth;
                        void container.offsetWidth; // Force reflow
                        container.classList.add('scroll-smooth');
                    }
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                };

                const scrollPrev = () => {
                    // Jika mendekati ujung kiri, pindahkan 5 item terakhir ke depan
                    if (container.scrollLeft <= scrollAmount) {
                        container.classList.remove('scroll-smooth');
                        for (let i = 0; i < uniqueItems; i++) {
                            container.insertBefore(container.lastElementChild, container.firstElementChild);
                        }
                        container.scrollLeft += batchWidth;
                        void container.offsetWidth; // Force reflow
                        container.classList.add('scroll-smooth');
                    }
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                };

                btnLeft.addEventListener('click', scrollPrev);
                btnRight.addEventListener('click', scrollNext);

                // Auto-scroll logic (infinite looping to the right)
                let autoScroll = setInterval(scrollNext, 3500);

                const resetAutoScroll = () => {
                    clearInterval(autoScroll);
                    autoScroll = setInterval(scrollNext, 3500);
                };

                // Pause on hover or touch
                container.addEventListener('mouseenter', () => clearInterval(autoScroll));
                container.addEventListener('mouseleave', resetAutoScroll);
                container.addEventListener('touchstart', () => clearInterval(autoScroll));
                container.addEventListener('touchend', resetAutoScroll);
                
                // Reset timer when manually clicking buttons
                btnLeft.addEventListener('click', resetAutoScroll);
                btnRight.addEventListener('click', resetAutoScroll);
            });
        </script>
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
                    <img src="{{ asset('logo-usu.png') }}" alt="USU Logo" class="w-10 h-10">
                </div>
                <div>
                    <p class="text-white font-bold text-lg tracking-wide">Perpustakaan Universitas Sumatera Utara</p>
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
                        <h3 class="text-lg md:text-xl font-bold tracking-wide">Pencarian Spesifik</h3>
                        <p class="text-xs text-green-100/90 font-medium font-sans">Temukan buku, skripsi, dan jurnal untuk tugas kuliahmu dengan cepat!</p>
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
                        <i class="ph ph-info text-sm text-[#106c38]"></i> Detail Bibliografi
                    </h4>
                    
                    <!-- Judul -->
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-book-open text-xl"></i>
                        </div>
                        <input type="text" name="inJudul" placeholder="e.g. Metode Penelitian Hukum" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                    </div>
                    
                    <!-- Pengarang -->
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-slate-400">
                            <i class="ph ph-user text-xl"></i>
                        </div>
                        <input type="text" name="inPengarang1" placeholder="e.g. Prof. Soerjono Soekanto" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                    </div>
                    
                    <!-- Penerbit & Subyek -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-buildings text-xl"></i>
                            </div>
                            <input type="text" name="inPenerbit" placeholder="e.g. Rajawali Pers" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-tag text-xl"></i>
                            </div>
                            <input type="text" name="inSubyek" placeholder="e.g. Hukum Perdata" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- Tahun Terbit & ISBN -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-calendar text-xl"></i>
                            </div>
                            <input type="text" name="intahunterbit" placeholder="e.g. 2023" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-barcode text-xl"></i>
                            </div>
                            <input type="text" name="inisbn" placeholder="e.g. 978-602-8512-30-4" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                    
                    <!-- No. Klasifikasi & Barcode -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-hash text-xl"></i>
                            </div>
                            <input type="text" name="inKlasifikasi" placeholder="e.g. 340" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-qr-code text-xl"></i>
                            </div>
                            <input type="text" name="inbarcode" placeholder="e.g. 120930193" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 font-medium text-sm">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Filter Pencarian -->
                <div class="space-y-4 pt-2 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                        <i class="ph ph-sliders-horizontal text-sm text-[#106c38]"></i> Lokasi & Jenis Koleksi
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Semua Lokasi -->
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-map-pin text-xl"></i>
                            </div>
                            <select name="inLokasi" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm appearance-none cursor-pointer">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->code }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 pointer-events-none text-slate-400">
                                <i class="ph ph-caret-down text-sm"></i>
                            </div>
                        </div>
                        
                        <!-- Semua Jenis -->
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-slate-400">
                                <i class="ph ph-file-text text-xl"></i>
                            </div>
                            <select name="inJenis" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-600 font-medium text-sm appearance-none cursor-pointer">
                                <option value="">Semua Jenis</option>
                                <option value="buku">Buku</option>
                                <option value="jurnal">Jurnal</option>
                                <option value="majalah">Majalah</option>
                                <option value="skripsi">Skripsi/Tesis/Disertasi</option>
                                <option value="laporan_penelitian">Laporan Penelitian</option>
                            </select>
                            <div class="absolute right-4 pointer-events-none text-slate-400">
                                <i class="ph ph-caret-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cari Button -->
                <div class="flex justify-center pt-4">
                    <button type="submit" class="bg-[#106c38] hover:bg-green-800 text-white px-12 py-4 rounded-full font-bold text-sm tracking-wider uppercase transition-all shadow-lg shadow-green-950/20 hover:shadow-green-900/40 hover:-translate-y-0.5 focus:outline-none flex items-center gap-2">
                        <i class="ph ph-magnifying-glass text-lg"></i> Cari Koleksi
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
        });
    </script>
</body>
</html>

