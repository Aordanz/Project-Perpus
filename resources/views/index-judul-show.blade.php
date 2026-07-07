<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Index Judul') }} '{{ $initial }}' - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <!-- Navigation / Alphabet Header -->
    <div class="relative pt-24 pb-8 lg:pt-28 lg:pb-10 overflow-hidden bg-white shadow-sm z-10 border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">{{ __('Index Judul') }}</h2>
                <div class="w-16 h-1 bg-[#106c38] mx-auto mt-2 rounded-full"></div>
            </div>

            <!-- Numbers Section -->
            <div class="mb-6">
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                    @foreach(range(0, 9) as $number)
                        <a href="{{ route('index-judul.show', ['initial' => $number]) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-base transition-all duration-300 {{ (string)$initial === (string)$number ? 'bg-[#106c38] text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-[#106c38]/10 hover:text-[#106c38] border border-slate-200' }}">
                            {{ $number }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Alphabet Section -->
            <div>
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                    @foreach(range('A', 'Z') as $letter)
                        <a href="{{ route('index-judul.show', ['initial' => $letter]) }}" 
                           class="w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center rounded-xl font-bold text-base sm:text-lg transition-all duration-300 {{ $initial === $letter ? 'bg-[#106c38] text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-[#106c38]/10 hover:text-[#106c38] border border-slate-200' }}">
                            {{ $letter }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 relative z-20 pb-20">
        
        <!-- Search Summary + Per-Page Selector -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">
                {{ __('Koleksi Berawalan') }} "{{ $initial }}" ({{ $books->total() }} {{ __('Koleksi') }})
            </h2>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span>{{ __('Tampilkan:') }}</span>
            <div class="relative">
                <!-- Dropdown Trigger Button -->
                <button type="button" id="per-page-dropdown-trigger" class="flex items-center justify-between gap-4 bg-white border border-emerald-600/35 text-slate-700 text-xs font-bold rounded-full pl-4 pr-3 py-1.5 outline-none cursor-pointer hover:border-emerald-600 focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all shadow-sm min-w-[75px]">
                    <span id="per-page-selected-label">
                        @if($perPage === 'all')
                            {{ __('Semua') }}
                        @else
                            {{ $perPage }}
                        @endif
                    </span>
                    <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
                </button>
                
                <!-- Dropdown Options Menu -->
                <div id="per-page-dropdown-menu" class="hidden absolute right-0 top-full mt-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50 transition-all">
                    @foreach([5, 10, 20, 50, 100] as $val)
                        @php
                            $isSelected = ($perPage == $val && $perPage !== 'all');
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['per_page' => $val, 'page' => 1]) }}" 
                           class="w-full text-left px-4 py-2.5 text-xs font-bold transition flex items-center justify-between {{ $isSelected ? 'text-[#106c38] bg-green-50/50 hover:bg-green-50' : 'text-slate-600 hover:bg-green-50 hover:text-[#106c38]' }}">
                            <span>{{ $val }}</span>
                            <i class="ph ph-check text-[12px] {{ $isSelected ? '' : 'hidden' }}"></i>
                        </a>
                    @endforeach
                    @php
                        $isAllSelected = ($perPage === 'all');
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 'all', 'page' => 1]) }}" 
                       class="w-full text-left px-4 py-2.5 text-xs font-bold transition flex items-center justify-between {{ $isAllSelected ? 'text-[#106c38] bg-green-50/50 hover:bg-green-50' : 'text-slate-600 hover:bg-green-50 hover:text-[#106c38]' }}">
                        <span>{{ __('Semua') }}</span>
                        <i class="ph ph-check text-[12px] {{ $isAllSelected ? '' : 'hidden' }}"></i>
                    </a>
                </div>
            </div>
            </div>
        </div>

        <!-- Results List -->
        <div class="space-y-4 mb-8">
            @forelse($books as $book)
                <div class="book-card result-card bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-3.5 sm:p-6 flex gap-3 sm:gap-6 items-start shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group">
                    <!-- Card Numbering Index -->
                    <div class="flex-shrink-0 text-base sm:text-2xl font-black text-slate-200 group-hover:text-[#106c38]/30 transition-colors select-none w-6 sm:w-8 text-center pt-1.5 sm:pt-4">
                        {{ sprintf('%02d', $books->firstItem() + $loop->index) }}
                    </div>

                    <!-- Book Cover -->
                    <div class="w-20 sm:w-28 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-lg sm:rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative">
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

                    <!-- Book Details -->
                    <div class="flex-grow flex flex-col h-full">
                        <div class="mb-2">
                            <!-- Category Badge -->
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 tracking-wider uppercase">
                                {{ __($book->category ?: 'Umum') }}
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 hover:text-[#106c38] hover:underline transition leading-snug">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                            </h3>
                        </div>

                        <!-- Author & Code -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mb-4 text-xs font-medium text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-user text-sm text-slate-400"></i>
                                <span>{{ __('Pengarang:') }} <strong class="text-slate-700">{{ $book->author }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-hash text-sm text-slate-400"></i>
                                <span>{{ __('No. Panggil:') }} <strong class="text-slate-700">{{ $book->call_number ?: '-' }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-buildings text-sm text-slate-400"></i>
                                <span>{{ __('Penerbit:') }} <strong class="text-slate-700">{{ $book->publisher ?: '-' }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar text-sm text-slate-400"></i>
                                <span>{{ __('Tahun Terbit:') }} <strong class="text-slate-700">{{ $book->publish_year ?: '-' }}</strong></span>
                            </div>
                        </div>

                        <!-- Availability Pill -->
                        <div class="mt-auto pt-3 border-t border-slate-50 flex flex-wrap gap-2 items-center justify-between text-xs">
                            <div class="flex items-center gap-1.5 text-slate-400">
                                <i class="ph ph-map-pin text-sm text-[#106c38]"></i>
                                <span class="font-medium text-slate-500">
                                    {{ __('Lokasi:') }} 
                                    @php
                                        $locNames = $book->items->map(function($i) { return __($i->location->name); })->unique();
                                    @endphp
                                    <strong class="text-slate-700">{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}</strong>
                                </span>
                            </div>
                            
                            <!-- Available count -->
                            @php
                                $totalCopies = $book->items->count();
                                $availableCopies = $book->items->where('status', 'Tersedia')->count();
                            @endphp
                            <div class="flex items-center gap-1">
                                @if($availableCopies > 0)
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 font-bold px-2.5 py-0.5 rounded-full border border-green-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        {{ $availableCopies }} / {{ $totalCopies }} {{ __('Eksemplar') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 font-bold px-2.5 py-0.5 rounded-full border border-red-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        {{ __('Semua Salinan Dipinjam') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm mt-8">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                        <i class="ph ph-warning-circle"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __('Koleksi Tidak Ditemukan') }}</h3>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                        {{ __('Maaf, belum ada buku yang judulnya berawalan huruf/angka') }} "{{ $initial }}".
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination -->
        @if($books->lastPage() > 1)
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 pt-6">
            <!-- Info text -->
            <p class="text-xs text-slate-400 font-medium">
                {{ __('Menampilkan') }} {{ $books->firstItem() }} {{ __('sampai') }} {{ $books->lastItem() }} {{ __('dari') }} {{ $books->total() }} {{ __('hasil') }}
            </p>

            <!-- Pagination Buttons -->
            <div class="flex items-center gap-1.5">
                @if ($books->onFirstPage())
                    <span class="px-3 sm:px-4 py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed">
                        <i class="ph ph-caret-left text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                    </span>
                @else
                    <a href="{{ $books->previousPageUrl() }}" class="px-3 sm:px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm">
                        <i class="ph ph-caret-left text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                    </a>
                @endif

                <!-- Page Numbers: max 5 with sliding window -->
                <div class="flex items-center gap-1">
                    @php
                        $current = $books->currentPage();
                        $last    = $books->lastPage();
                        $window  = 5;
                        $half    = (int) floor($window / 2);
                        $start   = max(1, min($current - $half, $last - $window + 1));
                        $end     = min($last, $start + $window - 1);
                    @endphp
                    @if($start > 1)
                        <a href="{{ $books->url(1) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 flex items-center justify-center text-xs sm:text-sm font-bold transition-colors">1</a>
                        @if($start > 2)
                            <span class="w-8 h-8 flex items-center justify-center text-slate-400 text-xs font-bold">…</span>
                        @endif
                    @endif
                    @for($p = $start; $p <= $end; $p++)
                        @if($p == $current)
                            <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#106c38] text-white flex items-center justify-center text-xs sm:text-sm font-bold shadow-md shadow-green-900/20">{{ $p }}</span>
                        @else
                            <a href="{{ $books->url($p) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 flex items-center justify-center text-xs sm:text-sm font-bold transition-colors">{{ $p }}</a>
                        @endif
                    @endfor
                    @if($end < $last)
                        @if($end < $last - 1)
                            <span class="w-8 h-8 flex items-center justify-center text-slate-400 text-xs font-bold">…</span>
                        @endif
                        <a href="{{ $books->url($last) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 flex items-center justify-center text-xs sm:text-sm font-bold transition-colors">{{ $last }}</a>
                    @endif
                </div>

                @if ($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="px-3 sm:px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm">
                        <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-lg"></i>
                    </a>
                @else
                    <span class="px-3 sm:px-4 py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed">
                        <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-lg"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('per-page-dropdown-trigger');
            const menu = document.getElementById('per-page-dropdown-menu');

            if (trigger && menu) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
