<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Pustakawan - Portal Admin OPAC USU</title>

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
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
        }
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="ph ph-images text-usu-green text-3xl"></i>
                    <span>Galeri Pustakawan</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Pantau seluruh koleksi buku dalam tampilan galeri. Mudah untuk melihat sampul dan status ketersediaan.</p>
            </div>
            
            <form action="{{ route('admin.galeri') }}" method="GET" class="w-full sm:w-64 relative flex items-center">
                <div class="absolute left-3.5 text-slate-400">
                    <i class="ph ph-magnifying-glass text-lg"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..." class="w-full pl-10 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-sm outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                @if(request('search'))
                    <a href="{{ route('admin.galeri') }}" class="absolute right-3.5 text-slate-400 hover:text-slate-600">
                        <i class="ph ph-x-circle text-base"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Book Gallery Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm book-card flex flex-col h-full group relative">
                    <!-- Cover Image -->
                    <div class="w-full aspect-[2/3] bg-slate-100 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-2">
                                <i class="ph ph-book text-4xl"></i>
                                <span class="text-[10px] font-semibold uppercase tracking-wider">No Cover</span>
                            </div>
                        @endif
                        
                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                            <a href="{{ route('books.show', $book->id) }}" class="bg-white/20 hover:bg-white text-white hover:text-slate-900 text-xs font-bold py-1.5 px-3 rounded-lg backdrop-blur-sm transition flex items-center gap-1.5">
                                <i class="ph ph-eye"></i> Detail
                            </a>
                             <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-blue-600/80 hover:bg-blue-600 text-white text-xs font-bold py-1.5 px-3 rounded-lg backdrop-blur-sm transition flex items-center gap-1.5">
                                 <i class="ph ph-pencil-simple"></i> Edit
                             </a>
                        </div>

                        <!-- Status Badge -->
                        @php
                            $avail = $book->items->where('status', 'Tersedia')->count();
                            $copies = $book->items->count();
                        @endphp
                        <div class="absolute top-2 left-2 {{ $avail > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                            {{ $avail > 0 ? $avail . ' Tersedia' : 'Habis' }}
                        </div>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="p-3 flex flex-col flex-grow justify-between gap-2">
                        <div>
                            <h3 class="font-bold text-slate-800 text-xs leading-snug line-clamp-2" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="text-[10px] text-slate-500 mt-1 truncate" title="{{ $book->author }}">{{ $book->author }}</p>
                        </div>
                        <div class="text-[9px] font-mono font-semibold text-slate-400">
                            {{ $book->call_number ?: '-' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-400">
                    <i class="ph ph-books text-6xl mb-3 text-slate-200"></i>
                    <p class="font-semibold text-lg text-slate-500">Tidak ada buku ditemukan</p>
                    <p class="text-sm">Silakan tambahkan buku baru atau sesuaikan pencarian Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $books->links() }}
        </div>

            </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

</body>
</html>
