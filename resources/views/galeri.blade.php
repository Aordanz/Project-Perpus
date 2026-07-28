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
    <div class="relative z-30 pt-24 pb-12 bg-white shadow-sm mb-6">
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

                <!-- Search & Pop-down Filter Dropdown -->
                @php
                    $types = [
                        'all'               => ['label' => 'Semua Tipe', 'dot' => 'bg-slate-500'],
                        'buku'              => ['label' => 'Buku', 'dot' => 'bg-[#ef4444]'],
                        'referensi'         => ['label' => 'Referensi', 'dot' => 'bg-indigo-600'],
                        'tesis'             => ['label' => 'Tesis', 'dot' => 'bg-blue-600'],
                        'skripsi'           => ['label' => 'Skripsi', 'dot' => 'bg-purple-600'],
                        'disertasi'         => ['label' => 'Disertasi', 'dot' => 'bg-amber-500'],
                        'jurnal'            => ['label' => 'Jurnal', 'dot' => 'bg-orange-500'],
                        'laporan penelitian' => ['label' => 'Laporan', 'dot' => 'bg-emerald-600'],
                        'makalah'           => ['label' => 'Makalah', 'dot' => 'bg-cyan-600'],
                        'diktat'            => ['label' => 'Diktat', 'dot' => 'bg-rose-600'],
                    ];

                    $rawRequestType = request('type', 'all');
                    $activeTypesArray = array_values(array_filter(array_map('trim', explode(',', strtolower($rawRequestType)))));
                    if (empty($activeTypesArray)) {
                        $activeTypesArray = ['all'];
                    }

                    $activeLabels = [];
                    foreach ($activeTypesArray as $aKey) {
                        if ($aKey !== 'all' && isset($types[$aKey])) {
                            $activeLabels[] = __($types[$aKey]['label']);
                        }
                    }

                    if (empty($activeLabels)) {
                        $initialTypeLabel = __('Semua Tipe');
                    } elseif (count($activeLabels) === 1) {
                        $initialTypeLabel = $activeLabels[0];
                    } elseif (count($activeLabels) === 2) {
                        $initialTypeLabel = implode(', ', $activeLabels);
                    } else {
                        $initialTypeLabel = $activeLabels[0] . ', ' . $activeLabels[1] . ' (+' . (count($activeLabels) - 2) . ')';
                    }
                @endphp
                <div class="w-full md:w-96 flex flex-col items-end gap-2 relative">
                    <form action="{{ route('galeri') }}" method="GET" class="relative w-full">
                        <input type="text" id="live-search-input" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari di Galeri...') }}" 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-100 border-0 rounded-xl focus:ring-2 focus:ring-[#106c38]/20 focus:bg-white transition-all text-sm font-medium">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#106c38]">
                            <i class="ph ph-magnifying-glass text-lg font-bold"></i>
                        </button>
                    </form>

                    <!-- Filter Pop-down Button (Under Search Bar) -->
                    <div class="relative inline-block self-end">
                        <button id="type-filter-dropdown-btn" type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-slate-700 border border-slate-200 shadow-sm hover:border-[#106c38] hover:text-[#106c38] transition cursor-pointer">
                            <i class="ph ph-funnel text-sm text-[#106c38]"></i>
                            <span>{{ __('Filter Tipe:') }}</span>
                            <span class="font-extrabold text-[#106c38]" id="selected-type-label">
                                {{ $initialTypeLabel }}
                            </span>
                            <i class="ph ph-caret-down text-xs transition-transform duration-200" id="type-dropdown-arrow"></i>
                        </button>

                        <!-- Pop-down Dropdown Menu -->
                        <div id="type-filter-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-[60] transition-all duration-200">
                            <div class="px-3.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 mb-1 flex items-center justify-between">
                                <span>{{ __('Pilih Tipe Koleksi') }}</span>
                                <i class="ph ph-funnel text-xs text-[#106c38]"></i>
                            </div>
                            @foreach($types as $tKey => $tVal)
                                @php
                                    $isTypeActive = in_array($tKey, $activeTypesArray) || (in_array('all', $activeTypesArray) && $tKey === 'all');
                                @endphp
                                <button type="button" data-type="{{ $tKey }}" data-label="{{ __($tVal['label']) }}"
                                        class="type-option-btn w-full flex items-center justify-between px-3.5 py-2 text-xs font-semibold hover:bg-slate-50 transition cursor-pointer {{ $isTypeActive ? 'text-[#106c38] bg-green-50/60 font-bold' : 'text-slate-700' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $tVal['dot'] }}"></span>
                                        <span>{{ __($tVal['label']) }}</span>
                                    </div>
                                    <i class="ph ph-check-circle text-sm text-[#106c38] active-check {{ $isTypeActive ? '' : 'hidden' }}"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-[1400px] mx-auto w-full px-2 sm:px-4 lg:px-6 mb-20">

        <div class="mb-6 max-w-6xl mx-auto px-2">
            @php
                $hasActiveCategory = request()->has('category') && request('category') !== null && request('category') !== '';
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
            <div id="category-container" class="flex flex-wrap gap-2 sm:gap-3 justify-center items-center">
                <!-- Semua Kategori -->
                <a href="{{ route('galeri', array_merge(request()->except('page', 'category'), ['q' => request('q')])) }}" 
                   class="group relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 {{ request('category') === null || request('category') === '' ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold shadow-md ring-2 ring-[#106c38]/40' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-green-50/80 hover:border-[#106c38] hover:text-[#106c38] hover:shadow-md hover:shadow-green-100 hover:ring-2 hover:ring-[#106c38]/40' }}">
                    <i class="ph ph-squares-four text-base sm:text-lg"></i>
                    <span>{{ __('Semua Kategori') }}</span>
                </a>
                
                <!-- Diminati -->
                <a href="{{ route('galeri', array_merge(request()->except('page'), ['category' => 'terlaris', 'q' => request('q')])) }}" 
                   class="group relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 {{ request('category') === 'terlaris' ? 'bg-gradient-to-r from-amber-500 to-orange-500 border-amber-500 text-white font-bold shadow-md shadow-orange-300/60 ring-2 ring-orange-400/60' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:border-orange-400 hover:text-orange-600 hover:shadow-md hover:shadow-orange-200/60 hover:ring-2 hover:ring-orange-400/50' }}">
                    <i class="ph ph-fire {{ request('category') === 'terlaris' ? 'text-white animate-pulse' : 'text-amber-500 group-hover:text-orange-500' }} text-base sm:text-lg"></i>
                    <span>{{ __('Diminati') }}</span>
                </a>
                
                @foreach($ddcCategories as $key => $cat)
                    @php 
                        $isActive = request('category') !== null && request('category') !== '' && (string) $activeCategory === (string) $key; 
                        $index = $loop->index;
                        
                        $visibilityClass = 'cat-collapsible';
                        if ($index < 1) $visibilityClass = 'cat-collapsible md-visible';
                        elseif ($index < 2) $visibilityClass = 'cat-collapsible lg-visible';
                        elseif ($index < 3) $visibilityClass = 'cat-collapsible xl-visible';
                    @endphp
                    <a href="{{ route('galeri', array_merge(request()->except('page'), ['category' => $key, 'q' => request('q')])) }}" 
                       class="group category-bubble {{ $visibilityClass }} relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 {{ $isActive ? 'bg-green-50 border-[#106c38] text-[#106c38] font-bold shadow-md ring-2 ring-[#106c38]/40' : 'bg-white border-slate-200 text-slate-700 font-medium hover:bg-green-50/80 hover:border-[#106c38] hover:text-[#106c38] hover:shadow-md hover:shadow-green-100 hover:ring-2 hover:ring-[#106c38]/40' }}">
                        <i class="ph {{ $cat['icon'] }} text-base sm:text-lg"></i>
                        <span>{{ __($cat['name']) }}</span>
                    </a>
                @endforeach

                <!-- Toggle Button -->
                <button id="toggle-category-btn" class="group flex-shrink-0 text-xs sm:text-sm font-semibold text-[#106c38] hover:text-[#0b4d27] inline-flex items-center gap-1 transition-all duration-300 bg-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-full shadow-sm border border-[#106c38]/30 hover:border-[#106c38] hover:ring-2 hover:ring-[#106c38]/40 hover:shadow-md hover:shadow-green-100 cursor-pointer transform hover:-translate-y-0.5">
                    <span id="toggle-category-text">{{ __('Lainnya') }}</span>
                    <i id="toggle-category-icon" class="ph ph-caret-down transition-transform duration-300 group-hover:scale-110"></i>
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

            let selectedTypes = new Set(@json($activeTypesArray));

            function performGallerySearch() {
                const query = searchInput ? searchInput.value : '';
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('q', query);
                urlParams.set('page', '1'); // Reset to page 1 on new search

                if (selectedTypes.has('all') || selectedTypes.size === 0) {
                    urlParams.delete('type');
                } else {
                    urlParams.set('type', Array.from(selectedTypes).join(','));
                }

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
                let isExpanded = false;
                
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

            // Type Filter Pop-down Dropdown Handler
            const typeDropdownBtn = document.getElementById('type-filter-dropdown-btn');
            const typeDropdownMenu = document.getElementById('type-filter-dropdown-menu');
            const typeDropdownArrow = document.getElementById('type-dropdown-arrow');
            const selectedTypeLabel = document.getElementById('selected-type-label');
            const typeOptionBtns = document.querySelectorAll('.type-option-btn');

            if (typeDropdownBtn && typeDropdownMenu) {
                typeDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    typeDropdownMenu.classList.toggle('hidden');
                    if (typeDropdownArrow) typeDropdownArrow.classList.toggle('rotate-180');
                });

                document.addEventListener('click', function(e) {
                    if (!typeDropdownMenu.contains(e.target) && !typeDropdownBtn.contains(e.target)) {
                        typeDropdownMenu.classList.add('hidden');
                        if (typeDropdownArrow) typeDropdownArrow.classList.remove('rotate-180');
                    }
                });

                const totalSpecificTypes = Array.from(typeOptionBtns).filter(b => b.getAttribute('data-type') !== 'all').length;

                typeOptionBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const key = btn.getAttribute('data-type');

                        if (key === 'all') {
                            selectedTypes.clear();
                            selectedTypes.add('all');
                        } else {
                            selectedTypes.delete('all');
                            if (selectedTypes.has(key)) {
                                selectedTypes.delete(key);
                            } else {
                                selectedTypes.add(key);
                            }

                            const specificCount = Array.from(selectedTypes).filter(k => k !== 'all').length;
                            if (specificCount === 0 || specificCount >= totalSpecificTypes) {
                                selectedTypes.clear();
                                selectedTypes.add('all');
                            }
                        }

                        // Update check icons and styles
                        typeOptionBtns.forEach(b => {
                            const bKey = b.getAttribute('data-type');
                            const check = b.querySelector('.active-check');
                            const isSel = selectedTypes.has(bKey) || (selectedTypes.has('all') && bKey === 'all');
                            if (isSel) {
                                b.classList.add('text-[#106c38]', 'bg-green-50/60', 'font-bold');
                                b.classList.remove('text-slate-700');
                                if (check) check.classList.remove('hidden');
                            } else {
                                b.classList.remove('text-[#106c38]', 'bg-green-50/60', 'font-bold');
                                b.classList.add('text-slate-700');
                                if (check) check.classList.add('hidden');
                            }
                        });

                        // Update label text
                        if (selectedTypeLabel) {
                            if (selectedTypes.has('all') || selectedTypes.size === 0) {
                                selectedTypeLabel.textContent = "{{ __('Semua Tipe') }}";
                            } else {
                                const labels = [];
                                typeOptionBtns.forEach(b => {
                                    const bKey = b.getAttribute('data-type');
                                    if (bKey !== 'all' && selectedTypes.has(bKey)) {
                                        labels.push(b.getAttribute('data-label'));
                                    }
                                });
                                if (labels.length === 1) {
                                    selectedTypeLabel.textContent = labels[0];
                                } else if (labels.length === 2) {
                                    selectedTypeLabel.textContent = labels.join(', ');
                                } else {
                                    selectedTypeLabel.textContent = `${labels[0]}, ${labels[1]} (+${labels.length - 2})`;
                                }
                            }
                        }

                        performGallerySearch();
                    });
                });
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