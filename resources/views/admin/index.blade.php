<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Admin - OPAC Universitas Sumatera Utara</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .admin-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .btn-gold {
            background-color: #106c38;
            color: white;
            font-weight: 700;
        }
        .btn-gold:hover {
            background-color: #0b4d27;
        }
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
        }
        .border-usu-gold {
            border-color: #106c38;
        }
        .custom-card {
            transition: all 0.3s ease;
        }
        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }
        /* Custom scrollbar for form fields container */
        .form-container::-webkit-scrollbar {
            width: 6px;
        }
        .form-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .form-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        
        <!-- Welcome Alert & Summary -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="ph ph-layout text-usu-green text-3xl"></i>
                    <span>Dashboard Inventaris Buku</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Selamat bekerja! Di sini Anda dapat memantau data sirkulasi dan menambahkan koleksi buku baru secara rinci.</p>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
                    <i class="ph ph-arrow-square-out text-base"></i>
                    <span>Lihat Halaman OPAC</span>
                </a>
            </div>
        </div>

        <!-- Success & Error Alerts -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm animate-pulse">
                <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                <div class="leading-normal">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                <div class="leading-normal">
                    <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- 4 Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat 1: Total Titles -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-green-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-green-50 text-[#106c38] rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-book-open"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Judul</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ number_format($totalBooks) }}</h3>
                </div>
            </div>

            <!-- Stat 2: Total Items (Copies) -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-emerald-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-barcode"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Salinan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ number_format($totalItems) }}</h3>
                </div>
            </div>

            <!-- Stat 3: Available Items -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-teal-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-check-square"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Tersedia</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5 text-green-700">{{ number_format($availableItems) }}</h3>
                </div>
            </div>

            <!-- Stat 4: Borrowed Items -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-amber-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-user-minus"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Dipinjam</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5 text-amber-700">{{ number_format($borrowedItems) }}</h3>
                </div>
            </div>
        </div>

            </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; 2026 Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
