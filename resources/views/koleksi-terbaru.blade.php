<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koleksi Terbaru - OPAC USU Library</title>

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
            background-color: #ffffff;
            font-family: 'Inter', sans-serif !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased">

    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Links -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('logo usu.jpeg') }}" alt="USU Logo" class="h-10 w-auto rounded bg-white p-0.5">
                        <div class="flex flex-col hidden sm:flex">
                            <span class="font-bold text-white leading-none text-sm">Universitas</span>
                            <span class="font-bold text-white leading-none text-sm">Sumatera Utara</span>
                        </div>
                    </a>
                    <div class="hidden lg:flex space-x-6 items-center">
                        <a href="{{ route('home') }}" class="text-green-100 font-medium text-sm hover:text-white transition pb-1">Beranda</a>
                        <a href="{{ route('koleksi.terbaru') }}" class="text-white font-bold text-sm hover:text-green-200 transition border-b-2 border-white pb-1">Koleksi Terbaru</a>
                        <a href="#" class="text-green-100 font-medium text-sm hover:text-white transition pb-1">Index Judul</a>
                        <div class="relative group">
                            <button class="text-green-100 font-medium text-sm hover:text-white transition flex items-center gap-1 pb-1">
                                Tautan Lain <i class="ph ph-caret-down"></i>
                            </button>
                        </div>
                        <a href="#" class="text-green-100 font-medium text-sm hover:text-white transition pb-1">Cek Pinjaman</a>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="hidden md:flex space-x-5 items-center">
                    <a href="#" class="text-green-100 font-medium text-sm hover:text-white transition">Bantuan</a>
                    <a href="#" class="text-green-100 font-medium text-sm hover:text-white transition">Kontak Kami</a>
                    <button class="text-green-100 font-medium text-sm hover:text-white transition flex items-center gap-1">
                        <i class="ph ph-translate text-lg"></i> Bahasa
                    </button>
                    <a href="#" class="bg-white text-[#106c38] px-5 py-2 rounded-full font-bold text-sm shadow hover:bg-green-50 transition-all">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow w-full pt-16">
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-light text-slate-800 tracking-widest" style="font-family: 'Inter', sans-serif;">20 Koleksi Terbaru</h2>
            </div>

        <div class="space-y-6">
            @foreach($latestBooks as $index => $book)
                <a href="{{ route('books.show', $book->id) }}" class="flex items-start gap-4 sm:gap-6 p-4 rounded-2xl hover:bg-[#106c38] group transition-all duration-300 block mb-2 border border-transparent hover:shadow-lg border-b border-slate-200 hover:border-[#106c38]">
                    <!-- Number -->
                    <div class="w-8 flex-shrink-0 pt-2">
                        <span class="text-xl font-medium text-red-700 group-hover:text-green-100 transition-colors">{{ $index + 1 }}.</span>
                    </div>

                    <!-- Book Cover/Icon -->
                    <div class="w-24 aspect-[2/3] bg-slate-50 rounded-xl shadow-sm border border-slate-200 overflow-hidden flex-shrink-0 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 group-hover:text-green-300 transition-colors p-2">
                                <i class="ph ph-book-open text-3xl mb-1.5"></i>
                                <span class="text-[10px] font-bold text-center leading-tight">Cover Buku</span>
                            </div>
                        @endif
                        
                        <!-- NEW Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm">NEW</span>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="flex-grow pt-1">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-white group-hover:underline mb-1 transition-colors">
                            {{ $book->title }}
                        </h3>
                        <p class="text-sm text-slate-800 mb-1 font-medium group-hover:text-white transition-colors">{{ $book->classification }} {{ $book->author }}</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1 group-hover:text-green-200 transition-colors">{{ $book->subject }}</p>
                        <p class="text-xs text-slate-500 group-hover:text-green-200 transition-colors">{{ $book->publisher }}{{ $book->publish_year ? ', ' . $book->publish_year : '' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-[#064e3b] to-[#022c22] border-t-4 border-[#106c38] py-10 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center p-0.5 overflow-hidden">
                    <img src="{{ asset('logousu.jpeg') }}" alt="Logo USU" class="w-full h-full rounded-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-base tracking-wide">Universitas Sumatera Utara</span>
                    <span class="text-xs text-green-200">Online Public Access Catalog © 2026</span>
                </div>
            </div>
            <p class="text-xs text-green-100/60 max-w-md text-center sm:text-right">
                Perpustakaan Universitas Sumatera Utara. Jl. Perpustakaan No. 1, Kampus Padang Bulan, Medan, Sumatera Utara.
            </p>
        </div>
    </footer>

</body>
</html>
