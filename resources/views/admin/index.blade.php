<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
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

        /* Tom Select Custom Tailwind Styling */
        .ts-control {
            display: flex !important;
            align-items: center !important;
            border-radius: 0.75rem !important; /* rounded-xl to match other inputs */
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important; /* slate-50 to match others */
            padding: 0.75rem 1rem !important; /* py-3 px-4 */
            font-size: 0.875rem !important;
            font-family: 'Inter', sans-serif !important;
            color: #334155 !important;
            font-weight: 600 !important;
            min-height: 48px !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease !important;
        }
        .ts-control > input {
            font-size: 0.875rem !important;
            font-weight: 500 !important;
        }
        .ts-control.focus {
            border-color: #F9C311 !important;
            box-shadow: 0 0 0 3px rgba(249, 195, 17, 0.2) !important;
        }
        .ts-wrapper.dropdown-active .ts-control {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-bottom-color: transparent !important;
        }
        .ts-dropdown {
            border-bottom-left-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: 1px solid #e2e8f0 !important;
            border-top: none !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.875rem !important;
            margin-top: 0 !important;
            overflow: hidden !important;
            z-index: 100 !important;
            padding: 0.5rem !important;
        }
        .ts-dropdown .ts-dropdown-content {
            padding: 0 !important;
        }
        .ts-dropdown .ts-dropdown-content::-webkit-scrollbar {
            width: 6px;
        }
        .ts-dropdown .ts-dropdown-content::-webkit-scrollbar-track {
            background: transparent;
        }
        .ts-dropdown .ts-dropdown-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .ts-dropdown .ts-dropdown-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
            color: #475569 !important;
            border-radius: 0.75rem !important;
            margin-bottom: 2px !important;
            transition: all 0.2s ease !important;
        }
        .ts-dropdown .option:last-child {
            margin-bottom: 0 !important;
        }
        .ts-dropdown .active {
            background-color: #106c38 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        .ts-wrapper.single .ts-control:after {
            content: " ";
            display: block !important;
            position: absolute !important;
            top: 50% !important;
            margin-top: -3px !important;
            border-color: #94a3b8 transparent transparent transparent !important;
            border-width: 6px 5px 0 5px !important;
            border-style: solid !important;
            right: 1.25rem !important;
        }
        .ts-wrapper.single.dropdown-active .ts-control:after {
            border-color: transparent transparent #94a3b8 transparent !important;
            border-width: 0 5px 6px 5px !important;
        }
        /* Sembunyikan item yang dipilih saat sedang mencari/fokus */
        .ts-wrapper.single.focus .ts-control .item {
            display: none !important;
        }
    </style>
    
    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
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

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Stat 1: Total Titles -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-book-open"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Buku</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($totalBooks) }}</h3>
                </div>
            </div>

            <!-- Stat 2: Total Items (Copies) -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-barcode"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Eksemplar</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($totalItems) }}</h3>
                </div>
            </div>

            <!-- Stat 3: Available Items -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-check-square"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Eksemplar Tersedia</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($availableItems) }}</h3>
                </div>
            </div>

            <!-- Stat 4: Borrowed Items -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-user-minus"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Eksemplar Dipinjam</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($borrowedItems) }}</h3>
                </div>
            </div>

            <!-- Stat 5: Books With Cover -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-image"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Buku Punya Cover</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($totalBooksWithCover) }}</h3>
                </div>
            </div>

            <!-- Stat 6: Books Without Cover -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 relative flex items-center gap-4 shadow-sm hover:shadow-md hover:border-[#F9C311]/50 custom-card group transition-all">
                <div class="text-[#F9C311] text-5xl flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i class="ph ph-image-broken"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Buku Tanpa Cover</span>
                    <h3 class="text-3xl font-black text-[#006633] mt-0.5">{{ number_format($totalBooksWithoutCover) }}</h3>
                </div>
            </div>
        </div>

        <!-- Location Cover Stats Cards -->
        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#006633]/10 text-[#006633] flex items-center justify-center text-2xl">
                        <i class="ph ph-buildings"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Statistik Kelengkapan Cover per Lokasi</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Memantau kelengkapan cover buku untuk semua lokasi perpustakaan.</p>
                    </div>
                </div>

                <!-- Dropdown Filter -->
                <form action="{{ route('admin.index') }}" method="GET" class="flex-shrink-0 w-full sm:w-72">
                    <select name="lokasi" id="lokasi-select" onchange="this.form.submit()" placeholder="Cari Lokasi...">
                        <option value="all" {{ request('lokasi', 'all') == 'all' ? 'selected' : '' }}>Semua Lokasi</option>
                        @foreach($locationsList as $locationName)
                            <option value="{{ $locationName }}" {{ request('lokasi') == $locationName ? 'selected' : '' }}>{{ $locationName }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <div class="pt-2 border-t border-slate-100">
                <div class="flex items-center gap-2 mb-4">
                    <i class="ph ph-map-pin text-usu-green"></i>
                    <h3 class="text-sm font-bold text-slate-600 uppercase tracking-wider">{{ $selectedLocation }}</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Total Buku -->
                    <div class="border border-slate-200/80 rounded-2xl p-6 bg-white flex flex-col justify-center items-center text-center relative custom-card group shadow-sm hover:shadow-md hover:border-[#F9C311]/50 transition-all">
                        <div class="text-[#F9C311] text-5xl mb-3 group-hover:scale-110 transition-transform"><i class="ph ph-books"></i></div>
                        <h4 class="text-4xl font-black text-[#006633] mb-1">{{ number_format($locationStats->total_books) }}</h4>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Buku</span>
                    </div>

                    <!-- Ber-Cover -->
                    <div class="border border-slate-200/80 rounded-2xl p-6 bg-white flex flex-col justify-center items-center text-center relative custom-card group shadow-sm hover:shadow-md hover:border-[#F9C311]/50 transition-all">
                        <div class="text-[#F9C311] text-5xl mb-3 group-hover:scale-110 transition-transform"><i class="ph ph-image"></i></div>
                        <h4 class="text-4xl font-black text-[#006633] mb-1">{{ number_format($locationStats->with_cover) }}</h4>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Ber-Cover</span>
                    </div>

                    <!-- Tanpa Cover -->
                    <div class="border border-slate-200/80 rounded-2xl p-6 bg-white flex flex-col justify-center items-center text-center relative custom-card group shadow-sm hover:shadow-md hover:border-[#F9C311]/50 transition-all">
                        <div class="text-[#F9C311] text-5xl mb-3 group-hover:scale-110 transition-transform"><i class="ph ph-image-broken"></i></div>
                        <h4 class="text-4xl font-black text-[#006633] mb-1">{{ number_format($locationStats->without_cover) }}</h4>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanpa Cover</span>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tom Select for Location
            if (document.getElementById('lokasi-select')) {
                new TomSelect('#lokasi-select', {
                    create: false,
                    placeholder: "Cari Lokasi...",
                    maxOptions: 100,
                    render: {
                        item: function(data, escape) {
                            return '<div class="flex items-center gap-2"><i class="ph ph-map-pin text-[#106c38] text-lg"></i><span>' + escape(data.text) + '</span></div>';
                        },
                        option: function(data, escape) {
                            return '<div class="flex items-center gap-2"><i class="ph ph-map-pin text-[#106c38] text-lg"></i><span>' + escape(data.text) + '</span></div>';
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
