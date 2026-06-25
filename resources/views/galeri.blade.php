<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Galeri') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* slightly darker background like Tokopedia */
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <!-- Header Section -->
    <div class="relative pt-24 pb-16 overflow-hidden bg-white shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center border border-green-100">
                        <i class="ph ph-squares-four text-2xl font-bold"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ __('Galeri Koleksi') }}</h1>
                        <p class="text-sm text-slate-500 font-medium">{{ __('Jelajahi seluruh koleksi literatur kami.') }}</p>
                    </div>
                </div>

                <!-- Search -->
                <div class="w-full md:w-96">
                    <form action="{{ route('galeri') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari di Galeri...') }}" 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-100 border-0 rounded-xl focus:ring-2 focus:ring-[#106c38]/20 focus:bg-white transition-all text-sm font-medium">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#106c38]">
                            <i class="ph ph-magnifying-glass text-lg font-bold"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-[1400px] mx-auto w-full px-2 sm:px-4 lg:px-6 mb-20">
        
        <!-- Bubble Filters -->
        <div class="mb-6 relative">
            <div id="category-container" class="flex flex-wrap items-center gap-2 sm:gap-3 w-full">
                <!-- Semua Kategori -->
                <a href="{{ route('galeri', ['q' => request('q')]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ !request('category') ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-sm shadow-sm">
                    <i class="ph ph-squares-four text-lg"></i> {{ __('Semua Kategori') }}
                </a>
                
                @php
                    $categories = [
                        ['name' => 'Umum', 'icon' => 'ph-books'],
                        ['name' => 'Agama', 'icon' => 'ph-mosque'],
                        ['name' => 'Hukum', 'icon' => 'ph-scales'],
                        ['name' => 'Kesehatan & Kedokteran', 'icon' => 'ph-stethoscope'],
                        ['name' => 'Sains & Teknologi', 'icon' => 'ph-rocket'],
                        ['name' => 'Sosial & Humaniora', 'icon' => 'ph-users-three'],
                        ['name' => 'Sejarah', 'icon' => 'ph-hourglass'],
                        ['name' => 'Ekonomi & Bisnis', 'icon' => 'ph-chart-line-up'],
                        ['name' => 'Sastra & Bahasa', 'icon' => 'ph-translate'],
                        ['name' => 'Kesenian', 'icon' => 'ph-palette'],
                        ['name' => 'Komputer & IT', 'icon' => 'ph-desktop'],
                        ['name' => 'Filsafat', 'icon' => 'ph-brain'],
                        ['name' => 'Geografi', 'icon' => 'ph-globe']
                    ];
                    $activeCategory = request('category');
                    $activeIndex = array_search($activeCategory, array_column($categories, 'name'));
                    $isExpanded = $activeIndex !== false && $activeIndex >= 5;
                @endphp

                @foreach($categories as $index => $cat)
                    @php
                        $isActive = $activeCategory === $cat['name'];
                        $isExtra = $index >= 5;
                        $isHidden = $isExtra && !$isExpanded;
                    @endphp
                    <a href="{{ route('galeri', ['category' => $cat['name'], 'q' => request('q')]) }}" 
                       style="{{ $isHidden ? 'display: none;' : '' }}"
                       class="{{ $isExtra ? 'extra-category-bubble' : '' }} category-bubble inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $isActive ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-sm shadow-sm">
                        <i class="ph {{ $cat['icon'] }} text-lg"></i> {{ __($cat['name']) }}
                    </a>
                @endforeach

                <!-- Button Lihat Lebih Banyak -->
                <button id="toggle-categories-btn" onclick="toggleCategories()" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border bg-slate-50 border-slate-200 text-slate-600 font-medium hover:bg-slate-100 hover:text-slate-800 transition-colors text-sm shadow-sm cursor-pointer">
                    <i id="toggle-icon" class="ph {{ $isExpanded ? 'ph-caret-up' : 'ph-caret-down' }} text-lg"></i> 
                    <span id="toggle-text">{{ $isExpanded ? __('Sembunyikan') : __('Kategori Lainnya') }}</span>
                </button>
            </div>
        </div>

        <script>
            let isExpanded = {{ $isExpanded ? 'true' : 'false' }};
            
            function toggleCategories() {
                const extraBubbles = document.querySelectorAll('.extra-category-bubble');
                const btnText = document.getElementById('toggle-text');
                const btnIcon = document.getElementById('toggle-icon');

                isExpanded = !isExpanded;

                if (isExpanded) {
                    // Show them
                    extraBubbles.forEach(el => {
                        el.style.display = 'inline-flex';
                    });
                    btnText.innerText = '{{ __("Sembunyikan") }}';
                    btnIcon.classList.replace('ph-caret-down', 'ph-caret-up');
                } else {
                    // Hide them
                    extraBubbles.forEach(el => {
                        el.style.display = 'none';
                    });
                    btnText.innerText = '{{ __("Kategori Lainnya") }}';
                    btnIcon.classList.replace('ph-caret-up', 'ph-caret-down');
                }
            }
        </script>

        @if($books->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100 mt-4">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="ph ph-books text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ __('Koleksi Tidak Ditemukan') }}</h3>
                <p class="text-slate-500">{{ __('Maaf, tidak ada buku yang sesuai dengan pencarian Anda.') }}</p>
            </div>
        @else
            <!-- Grid Layout mimicking Tokopedia -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3">
                @foreach($books as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        
                        <!-- Image Container -->
                        <div class="aspect-[4/5] bg-slate-50 relative border-b border-slate-100 flex items-center justify-center overflow-hidden p-2">
                            @if($book->cover_image)
                                <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-md shadow-[0_4px_10px_rgba(0,0,0,0.1)] group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center text-slate-300">
                                    <i class="ph ph-book-open text-4xl mb-1"></i>
                                    <span class="text-[9px] font-bold uppercase">{{ __('No Cover') }}</span>
                                </div>
                            @endif
                            
                            <!-- Top Left Badge (Type) -->
                            <div class="absolute top-0 left-0 bg-[#ef4444] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-br-lg shadow-sm">
                                {{ strtoupper(__($book->type)) }}
                            </div>

                            <!-- Category Badge on bottom left -->
                            <div class="absolute bottom-1 left-1 bg-white/90 backdrop-blur-sm text-slate-700 text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm border border-slate-100/50">
                                {{ __($book->category ?: 'Umum') }}
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="p-2 sm:p-2.5 flex flex-col flex-grow">
                            <!-- Title -->
                            <h3 class="text-[12px] sm:text-[13px] font-medium text-slate-800 line-clamp-2 leading-snug mb-1.5 group-hover:text-[#106c38] transition-colors" title="{{ $book->title }}">
                                {{ $book->title }}
                            </h3>

                            <!-- Author (acting as Price visual) -->
                            <div class="text-[13px] sm:text-[15px] font-extrabold text-slate-900 mb-0.5 truncate" title="{{ $book->author }}">
                                {{ $book->author ?: '-' }}
                            </div>

                            <!-- Availability (acting as promo text) -->
                            @php
                                $totalCopies = $book->items->count();
                                $availableCopies = $book->items->filter(function($item) { return strtolower($item->status) === 'tersedia'; })->count();
                            @endphp
                            
                            <div class="mt-auto">
                                <!-- Copies Info -->
                                <div class="mb-2">
                                    @if($availableCopies > 0)
                                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 font-bold px-2 py-0.5 rounded-full border border-green-200/50 text-[9px] sm:text-[10px]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            {{ $availableCopies }} / {{ $totalCopies }} {{ __('Eksemplar') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 font-bold px-2 py-0.5 rounded-full border border-slate-200/50 text-[9px] sm:text-[10px]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            {{ __('Sedang Dipinjam') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Publisher Row (acting as Store Name) -->
                                <div class="flex items-center gap-1 text-[9px] sm:text-[10px] text-slate-500">
                                    <div class="w-3.5 h-3.5 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                                        <i class="ph-fill ph-seal-check text-[9px]"></i>
                                    </div>
                                    <span class="truncate font-medium">{{ $book->publisher ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Custom Pagination -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 pt-6">
                <!-- Items Per Page Dropdown -->
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-slate-500">{{ __('Tampilkan:') }}</span>
                    <div class="relative">
                        <select onchange="window.location.href=this.value" class="appearance-none bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-full pl-5 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] shadow-sm cursor-pointer transition-colors hover:border-slate-300">
                            @foreach([10, 24, 48, 100] as $val)
                                <option value="{{ request()->fullUrlWithQuery(['per' => $val, 'page' => 1]) }}" {{ $perPage == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                        <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs font-bold"></i>
                    </div>
                </div>

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

                    <!-- Page Numbers -->
                    <div class="flex items-center gap-1">
                        @php
                            $window = \Illuminate\Pagination\UrlWindow::make($books);
                            $elements = array_filter([
                                $window['first'],
                                is_array($window['slider']) ? '...' : null,
                                $window['slider'],
                                is_array($window['last']) ? '...' : null,
                                $window['last'],
                            ]);
                        @endphp
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-slate-400 text-xs sm:text-sm font-bold">
                                    {{ $element }}
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $books->currentPage())
                                        <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#106c38] text-white flex items-center justify-center text-xs sm:text-sm font-bold shadow-md shadow-green-900/20">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 flex items-center justify-center text-xs sm:text-sm font-bold transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
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

</body>
</html>
