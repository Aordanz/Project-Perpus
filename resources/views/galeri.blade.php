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
        
        <div class="mb-6 relative">
            <div id="category-container" class="flex overflow-x-auto whitespace-nowrap scrollbar-hide items-center gap-2 sm:gap-3 w-full pb-2">
                <!-- Semua Kategori -->
                <a href="{{ route('galeri', ['q' => request('q')]) }}" 
                   class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ !request('category') ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm flex-shrink-0">
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
                       class="category-bubble inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ $isActive ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold active-category-bubble' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm flex-shrink-0 {{ $index >= 6 ? 'extra-category' : '' }}"
                       style="{{ $index >= 6 && !$isActive ? 'display: none;' : '' }}">
                        <i class="ph {{ $cat['icon'] }} text-base sm:text-lg"></i> {{ __($cat['name']) }}
                    </a>
                @endforeach

                @if(count($categories) > 6)
                    <button id="toggle-categories-btn" class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-slate-200 bg-white text-slate-500 font-medium hover:bg-slate-50 hover:text-[#106c38] hover:border-[#106c38]/40 transition-colors text-xs sm:text-sm shadow-sm cursor-pointer select-none flex-shrink-0">
                        <span id="toggle-categories-text">{{ __('Tampilkan Selengkapnya') }}</span>
                        <i id="toggle-categories-icon" class="ph ph-caret-down text-base transition-transform duration-200"></i>
                    </button>
                @endif
            </div>
        </div>

        <div id="gallery-container">
            @include('partials.gallery_content')
        </div>
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

            // AJAX Live Search for Galeri Koleksi (global across all pages)
            const searchInput = document.getElementById('live-search-input');
            let debounceTimer;

            function performGallerySearch() {
                const query = searchInput.value;
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('q', query);
                urlParams.set('page', '1'); // Reset to page 1 on new search

                const targetUrl = `{{ route('galeri') }}?${urlParams.toString()}`;
                
                // Update browser address bar without reload
                window.history.pushState({}, '', targetUrl);

                const container = document.getElementById('gallery-container');
                if (container) {
                    container.style.opacity = '0.5';
                    container.style.pointerEvents = 'none';
                }

                fetch(targetUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Search failed');
                    return response.text();
                })
                .then(html => {
                    if (container) {
                        container.innerHTML = html;
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    }
                })
                .catch(error => {
                    console.error('Gallery live search failed:', error);
                    if (container) {
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(performGallerySearch, 300);
                });

                // Prevent page refresh on form submit, trigger AJAX search instead
                const searchForm = searchInput.closest('form');
                if (searchForm) {
                    searchForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        clearTimeout(debounceTimer);
                        performGallerySearch();
                    });
                }
            }
        });
    </script>

</body>
</html>