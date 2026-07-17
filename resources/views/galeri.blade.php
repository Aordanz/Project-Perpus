<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Galeri') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>

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

    <main>

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
        
        <div class="mb-6 max-w-6xl mx-auto px-2">
            @php
                $hasActiveCategory = request()->has('category') && request('category') != '';
                $activeCategory = request('category');
            @endphp

            <style>
                .cat-collapsible {
                    display: none !important;
                }
                @media (min-width: 640px) {
                    .cat-collapsible.sm-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 768px) {
                    .cat-collapsible.md-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 1024px) {
                    .cat-collapsible.lg-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 1280px) {
                    .cat-collapsible.xl-visible {
                        display: inline-flex !important;
                    }
                }
                .expanded-mode .cat-collapsible {
                    display: inline-flex !important;
                }
            </style>
            <div id="category-container" class="flex flex-wrap gap-2 sm:gap-3 justify-center items-center {{ $hasActiveCategory ? 'expanded-mode' : '' }}">
                <!-- Semua Kategori -->
                <a href="{{ route('galeri', ['q' => request('q')]) }}" 
                   class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ !request('category') ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm">
                    <i class="ph ph-squares-four text-base sm:text-lg"></i> {{ __('Semua Kategori') }}
                </a>
                
                @foreach($ddcCategories as $key => $cat)
                    @php 
                        $isActive = $activeCategory === (string) $key; 
                        $index = $loop->index;
                        $visibilityClass = '';
                        
                        // Menyamakan jumlah baris yang tampil dengan halaman koleksi terbaru
                        if ($index >= 1 && $index < 2) $visibilityClass = 'cat-collapsible sm-visible';
                        elseif ($index >= 2 && $index < 3) $visibilityClass = 'cat-collapsible md-visible';
                        elseif ($index >= 3 && $index < 4) $visibilityClass = 'cat-collapsible lg-visible';
                        elseif ($index >= 4 && $index < 6) $visibilityClass = 'cat-collapsible xl-visible';
                        elseif ($index >= 6) $visibilityClass = 'cat-collapsible';
                    @endphp
                    <a href="{{ route('galeri', ['category' => $key, 'q' => request('q')]) }}" 
                       class="category-bubble {{ $visibilityClass ?: 'inline-flex' }} items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border {{ $isActive ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-[#106c38] hover:text-[#106c38]' }} transition-colors text-xs sm:text-sm shadow-sm">
                        <i class="ph {{ $cat['icon'] }} text-base sm:text-lg"></i> {{ __($cat['name']) }}
                    </a>
                @endforeach

                <!-- Toggle Button -->
                <button id="toggle-category-btn" class="flex-shrink-0 text-xs sm:text-sm font-semibold text-[#106c38] hover:text-[#0b4d27] flex items-center gap-1 transition-colors bg-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-full shadow-sm border border-[#106c38]/30 hover:border-[#106c38] cursor-pointer">
                    <span id="toggle-category-text">{{ $hasActiveCategory ? __('Sembunyikan') : __('Lainnya') }}</span>
                    <i id="toggle-category-icon" class="ph ph-caret-down transition-transform duration-300 {{ $hasActiveCategory ? 'rotate-180' : '' }}"></i>
                </button>
            </div>
        </div>

        <div id="gallery-container">
            @include('partials.gallery_content')
        </div>
    </div>

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            const categoryContainer = document.getElementById('category-container');
            const toggleCategoryBtn = document.getElementById('toggle-category-btn');
            const toggleCategoryText = document.getElementById('toggle-category-text');
            const toggleCategoryIcon = document.getElementById('toggle-category-icon');
            
            if (toggleCategoryBtn && categoryContainer) {
                let isExpanded = {{ request()->has('category') && request('category') != '' ? 'true' : 'false' }};
                
                toggleCategoryBtn.addEventListener('click', function() {
                    isExpanded = !isExpanded;
                    if (isExpanded) {
                        categoryContainer.classList.add('expanded-mode');
                        toggleCategoryText.textContent = '{{ __("Sembunyikan") }}';
                        toggleCategoryIcon.classList.add('rotate-180');
                    } else {
                        categoryContainer.classList.remove('expanded-mode');
                        toggleCategoryText.textContent = '{{ __("Lainnya") }}';
                        toggleCategoryIcon.classList.remove('rotate-180');
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

            // Event delegation for custom per-page dropdown in gallery
            document.addEventListener('click', function(e) {
                const trigger = document.getElementById('per-dropdown-trigger');
                const menu = document.getElementById('per-dropdown-menu');
                
                if (trigger && menu) {
                    if (trigger.contains(e.target)) {
                        e.stopPropagation();
                        menu.classList.toggle('hidden');
                    } else if (!menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                }
            });
        });
    </script>

</body>
</html>