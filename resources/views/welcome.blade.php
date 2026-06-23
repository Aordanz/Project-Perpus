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
                        <img src="{{ asset('logo-usu.png') }}" alt="USU Logo" class="h-10 w-auto">
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
            <div class="max-w-3xl mx-auto bg-white rounded-2xl p-2 shadow-2xl flex items-center focus-within:ring-4 focus-within:ring-[#106c38]/30 transition-all">
                <div class="pl-5 text-slate-400">
                    <i class="ph ph-magnifying-glass text-2xl"></i>
                </div>
                <input type="text" placeholder="Cari buku, jurnal, penulis, atau kata kunci..." class="w-full bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 px-4 py-4 text-lg outline-none">
                <button class="bg-[#106c38] text-white rounded-xl px-8 py-4 font-semibold text-lg hover:bg-green-800 transition shadow-lg shadow-[#106c38]/30">
                    Cari
                </button>
            </div>
            <div class="mt-5">
                <a href="#" class="text-green-200 hover:text-white transition text-sm font-medium flex items-center justify-center gap-1">
                    Pencarian Spesifik <i class="ph ph-arrow-right"></i>
                </a>
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
            <!-- Stat Card 1 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-books text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">122.522</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Perpustakaan Universitas</p>
            </div>
            
            <!-- Stat Card 2 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-scales text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">7.729</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Hukum</p>
            </div>

            <!-- Stat Card 3 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-mask-happy text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">5.698</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Ilmu Budaya</p>
            </div>

            <!-- Stat Card 4 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-chart-line-up text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">5.156</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Ekonomi dan Bisnis</p>
            </div>

            <!-- Stat Card 5 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-heartbeat text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">4.175</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Kesehatan Masyarakat</p>
            </div>

            <!-- Stat Card 6 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-graduation-cap text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">3.982</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Sekolah Pascasarjana</p>
            </div>

            <!-- Stat Card 7 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-stethoscope text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">3.646</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Kedokteran</p>
            </div>

            <!-- Stat Card 8 -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-users-three text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">3.272</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas ISIP</p>
            </div>
            
            <!-- Additional Cards to fill out the grid nicely -->
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-plant text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">2.936</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Pertanian</p>
            </div>
            
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-first-aid text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">2.839</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Keperawatan</p>
            </div>
            
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-test-tube text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">2.316</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas MIPA</p>
            </div>
            
            <div class="stat-card bg-white hover:bg-[#106c38] rounded-2xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer transition-colors duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-20 transition-opacity duration-300 text-[#106c38] group-hover:text-white">
                    <i class="ph ph-brain text-8xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-[#106c38] group-hover:text-white transition-colors duration-300 mb-2">2.029</h3>
                <p class="text-slate-600 group-hover:text-green-50 font-medium transition-colors duration-300">Fakultas Psikologi</p>
            </div>
        </div>
    </div>

    <!-- Newest Collections Section (Marquee) -->
    <div class="py-16 bg-slate-50 border-t border-slate-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 text-center">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">20 Koleksi Terbaru</h2>
            <div class="w-24 h-1 bg-[#106c38] mx-auto rounded-full"></div>
            <p class="mt-4 text-slate-500">Buku dan literatur terbaru yang baru saja ditambahkan ke katalog kami</p>
        </div>

        <div class="relative max-w-[1400px] mx-auto px-4 sm:px-12 group">
            <!-- Navigation Buttons -->
            <button id="btn-scroll-left" class="absolute left-0 sm:left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white text-[#106c38] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center hover:bg-[#106c38] hover:text-white transition-all border border-slate-100 opacity-0 group-hover:opacity-100 focus:opacity-100 cursor-pointer">
                <i class="ph ph-caret-left text-2xl font-bold"></i>
            </button>
            <button id="btn-scroll-right" class="absolute right-0 sm:right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white text-[#106c38] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] flex items-center justify-center hover:bg-[#106c38] hover:text-white transition-all border border-slate-100 opacity-0 group-hover:opacity-100 focus:opacity-100 cursor-pointer">
                <i class="ph ph-caret-right text-2xl font-bold"></i>
            </button>

            <!-- Fade gradients -->
            <div class="hidden sm:block absolute left-12 top-0 bottom-0 w-24 bg-gradient-to-r from-slate-50 to-transparent z-10 pointer-events-none"></div>
            <div class="hidden sm:block absolute right-12 top-0 bottom-0 w-24 bg-gradient-to-l from-slate-50 to-transparent z-10 pointer-events-none"></div>
            
            <div id="books-scroll-container" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-8 pt-4 px-2 hide-scrollbar items-stretch">
                <!-- Card 1 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Orang-orang yang disayangi Allah</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">297.313 Ali o</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">FAITH AND REASON ISLAM</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Elements of chemical reaction engineering. 7th Ed.</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">660.2 Ele</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">CHEMICAL ENGINEERING</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Membangun jembatan menuju kemandirian penyandang disabilitas</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">305.908 Sir m</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">SOCIAL SCIENCE</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Pengantar Ilmu Hukum dan Tata Hukum Indonesia</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">340.1 Kan p</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">LAW</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Sistem Informasi Manajemen: Mengelola Perusahaan Digital</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">658.403 8 Lau s</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">MANAGEMENT</p>
                    </div>
                </div>
                
                <!-- Duplicate Items for seamless loop -->
                <!-- Card 1 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Orang-orang yang disayangi Allah</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">297.313 Ali o</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">FAITH AND REASON ISLAM</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Elements of chemical reaction engineering. 7th Ed.</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">660.2 Ele</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">CHEMICAL ENGINEERING</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Membangun jembatan menuju kemandirian penyandang disabilitas</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">305.908 Sir m</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">SOCIAL SCIENCE</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Pengantar Ilmu Hukum dan Tata Hukum Indonesia</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">340.1 Kan p</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">LAW</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="snap-start w-[160px] h-full flex-shrink-0 bg-white hover:bg-[#106c38] rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-xl transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <div class="relative w-full aspect-[2/3] bg-slate-100 rounded-md overflow-hidden border border-slate-200 group-hover:border-green-700 transition-colors flex-shrink-0">
                        <img src="" alt="Cover" class="w-full h-full object-cover hidden">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-200">
                            <i class="ph ph-image text-3xl mb-2"></i>
                            <span class="text-[10px] font-medium text-center leading-tight px-2">Cover Buku</span>
                        </div>
                        <div class="absolute top-2 right-2"><span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span></div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h4 class="font-bold text-[#106c38] group-hover:text-white text-sm leading-snug mb-2 group-hover:underline transition-colors break-words">Sistem Informasi Manajemen: Mengelola Perusahaan Digital</h4>
                        <p class="text-[11px] text-slate-500 group-hover:text-green-100 mb-1 transition-colors">658.403 8 Lau s</p>
                        <p class="text-[9px] text-slate-400 group-hover:text-green-200 uppercase tracking-wider transition-colors mt-auto pt-2 border-t border-slate-100 group-hover:border-[#064e3b]">MANAGEMENT</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('books-scroll-container');
                const btnLeft = document.getElementById('btn-scroll-left');
                const btnRight = document.getElementById('btn-scroll-right');
                
                // Lebar 1 kartu + gap (160px + 20px)
                const scrollAmount = 180; 

                btnLeft.addEventListener('click', () => {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });

                btnRight.addEventListener('click', () => {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });

                // Auto-scroll logic
                let autoScroll = setInterval(() => {
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                        container.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                }, 3500);

                const resetAutoScroll = () => {
                    clearInterval(autoScroll);
                    autoScroll = setInterval(() => {
                        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                            container.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                        }
                    }, 3500);
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
</body>
</html>
