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
                        <input type="text" id="live-search-input" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari di Galeri...') }}" 
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
                   class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ !request('category') ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm">
                    <i class="ph ph-squares-four text-base sm:text-lg"></i> {{ __('Semua Kategori') }}
                </a>
                
                @php
                    // Get unique categories from books table dynamically
                    $dbCategories = \App\Models\Book::select('category')->distinct()->whereNotNull('category')->pluck('category')->toArray();
                    
                    // Sort categories according to our preferred order
                    $preferredOrder = [
                        'Umum', 'Agama', 'Kesehatan & Kedokteran', 'Sains & Teknologi', 'Sosial & Humaniora',
                        'Hukum', 'Ekonomi & Bisnis', 'Pertanian & Kehutanan', 'Matematika & IPA', 'Teknik',
                        'Sastra & Bahasa', 'Komputer & Informatika', 'Seni & Desain', 'Sejarah & Geografi'
                    ];
                    
                    // Icon mapping
                    $iconMap = [
                        'Umum' => 'ph-books',
                        'Agama' => 'ph-mosque',
                        'Kesehatan & Kedokteran' => 'ph-stethoscope',
                        'Sains & Teknologi' => 'ph-rocket',
                        'Sosial & Humaniora' => 'ph-users-three',
                        'Hukum' => 'ph-scales',
                        'Ekonomi & Bisnis' => 'ph-chart-line-up',
                        'Pertanian & Kehutanan' => 'ph-tree',
                        'Matematika & IPA' => 'ph-calculator',
                        'Teknik' => 'ph-wrench',
                        'Sastra & Bahasa' => 'ph-translate',
                        'Komputer & Informatika' => 'ph-desktop',
                        'Seni & Desain' => 'ph-palette',
                        'Sejarah & Geografi' => 'ph-globe',
                    ];
                    
                    // Sort dbCategories based on preferredOrder
                    usort($dbCategories, function($a, $b) use ($preferredOrder) {
                        $posA = array_search($a, $preferredOrder);
                        $posB = array_search($b, $preferredOrder);
                        if ($posA === false) return 1;
                        if ($posB === false) return -1;
                        return $posA - $posB;
                    });

                    $categories = [];
                    foreach ($dbCategories as $catName) {
                        $categories[] = [
                            'name' => $catName,
                            'icon' => $iconMap[$catName] ?? 'ph-books'
                        ];
                    }

                    $activeCategory = request('category');
                @endphp

                @foreach($categories as $index => $cat)
                    @php
                        $isActive = $activeCategory === $cat['name'];
                    @endphp
                    <a href="{{ route('galeri', ['category' => $cat['name'], 'q' => request('q')]) }}" 
                       class="category-bubble inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ $isActive ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold active-category-bubble' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm {{ $index >= 6 ? 'extra-category' : '' }}"
                       style="{{ $index >= 6 && !$isActive ? 'display: none;' : '' }}">
                        <i class="ph {{ $cat['icon'] }} text-base sm:text-lg"></i> {{ __($cat['name']) }}
                    </a>
                @endforeach

                @if(count($categories) > 6)
                    <button id="toggle-categories-btn" class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-slate-200 bg-white text-slate-500 font-medium hover:bg-slate-50 hover:text-[#106c38] hover:border-[#106c38]/40 transition-colors text-xs sm:text-sm shadow-sm cursor-pointer select-none">
                        <span id="toggle-categories-text">{{ __('Tampilkan Selengkapnya') }}</span>
                        <i id="toggle-categories-icon" class="ph ph-caret-down text-base transition-transform duration-200"></i>
                    </button>
                @endif
            </div>
        </div>

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
                    <a href="{{ route('books.show', $book->id) }}" class="book-card bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col group"
                       data-title="{{ strtolower($book->title) }}" 
                       data-author="{{ strtolower($book->author) }}" 
                       data-publisher="{{ strtolower($book->publisher) }}">
                        
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
                                {{ strtoupper(__($book->jenis)) }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-categories-btn');
            const toggleText = document.getElementById('toggle-categories-text');
            const toggleIcon = document.getElementById('toggle-categories-icon');
            const extraCategories = document.querySelectorAll('.extra-category');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    const isCollapsed = Array.from(extraCategories).some(el => el.style.display === 'none');
                    
                    extraCategories.forEach(el => {
                        if (isCollapsed) {
                            el.style.display = 'inline-flex';
                        } else {
                            if (el.classList.contains('active-category-bubble')) {
                                el.style.display = 'inline-flex';
                            } else {
                                el.style.display = 'none';
                            }
                        }
                    });

                    if (isCollapsed) {
                        toggleText.textContent = '{{ __("Sembunyikan") }}';
                        toggleIcon.classList.remove('ph-caret-down');
                        toggleIcon.classList.add('ph-caret-up');
                    } else {
                        toggleText.textContent = '{{ __("Tampilkan Selengkapnya") }}';
                        toggleIcon.classList.remove('ph-caret-up');
                        toggleIcon.classList.add('ph-caret-down');
                    }
                });
            }
        });
    </script>

</body>
</html>
