<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Koleksi Terbaru') }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8fafc;
        }
        body, input, select, button, textarea {
            font-family: 'Inter', sans-serif !important;
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
        .!hidden {
            display: none !important;
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
<body class="min-h-screen flex flex-col text-slate-800 antialiased">

    @include('partials.navbar')

    <!-- Header Section -->
    <div class="relative pt-24 pb-16 overflow-hidden bg-white shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center border border-green-100">
                        <i class="ph ph-book-open text-2xl font-bold"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight" style="font-family: 'Outfit', sans-serif;">{{ __('Koleksi Terbaru') }}</h1>
                        <p class="text-sm text-slate-500 font-medium">{{ __('Jelajahi seluruh koleksi literatur terbaru kami.') }}</p>
                    </div>
                </div>

                <!-- Search -->
                <form action="{{ route('koleksi.terbaru') }}" method="GET" class="w-full md:w-96 relative">
                    <input type="text" name="q" id="live-search" value="{{ request('q') }}" placeholder="{{ __('Cari Koleksi...') }}" 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-100 border-0 rounded-xl focus:ring-2 focus:ring-[#106c38]/20 focus:bg-white transition-all text-sm font-medium outline-none">
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#106c38] transition cursor-pointer bg-transparent border-0 outline-none flex items-center justify-center">
                        <i class="ph ph-magnifying-glass text-lg font-bold"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-[1400px] w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        <!-- Helper Functions and Subject Mapping -->
        @php
            $ddcCategories = \App\Models\Book::getDdcCategories();
            $existingBigCategories = array_values(array_map(fn($cat) => $cat['name'], $ddcCategories));
            $iconMap = array_combine($existingBigCategories, array_column($ddcCategories, 'icon'));
            $terlarisBookIds = \Illuminate\Support\Facades\Cache::remember('buku_terlaris_ids', 86400, function () {
                return \Illuminate\Support\Facades\DB::table('tbltransaksi_pinjam')
                    ->select('idmaster', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_pinjam'))
                    ->whereNotNull('idmaster')
                    ->where('idmaster', '!=', '')
                    ->groupBy('idmaster')
                    ->orderByDesc('total_pinjam')
                    ->limit(200)
                    ->pluck('idmaster')
                    ->map(fn($id) => (string)$id)
                    ->toArray();
            });
        @endphp

        <!-- Dynamic Quick Filter Chips -->
        <div class="mb-8 max-w-6xl mx-auto px-2">
            <style>
                .chip-collapsible {
                    display: none !important;
                }
                @media (min-width: 640px) {
                    .chip-collapsible.sm-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 768px) {
                    .chip-collapsible.md-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 1024px) {
                    .chip-collapsible.lg-visible {
                        display: inline-flex !important;
                    }
                }
                @media (min-width: 1280px) {
                    .chip-collapsible.xl-visible {
                        display: inline-flex !important;
                    }
                }
                .expanded-mode .chip-collapsible {
                    display: inline-flex !important;
                }
            </style>
            <div id="chips-container" class="flex flex-wrap gap-2 sm:gap-3 mb-2 justify-center items-center transition-all duration-300">
                <!-- Semua Kategori -->
                <button data-filter="all" class="filter-chip active-chip group relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 bg-green-50 border-[#106c38] text-[#106c38] font-bold shadow-md ring-2 ring-[#106c38]/40 whitespace-nowrap">
                    <i class="ph ph-squares-four text-base sm:text-lg"></i>
                    <span>{{ __('Semua Kategori') }}</span>
                </button>

                <!-- Diminati -->
                <button data-filter="subject" data-value="terlaris" class="filter-chip group relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 bg-white border-slate-200 text-slate-700 font-medium hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:border-orange-400 hover:text-orange-600 hover:shadow-md hover:shadow-orange-200/60 hover:ring-2 hover:ring-orange-400/50 whitespace-nowrap">
                    <i class="ph ph-fire text-amber-500 group-hover:text-orange-500 text-base sm:text-lg"></i>
                    <span>{{ __('Diminati') }}</span>
                </button>

                @foreach($existingBigCategories as $index => $cat)
                    @php
                        $visibilityClass = 'chip-collapsible';
                        if ($index < 1) $visibilityClass = 'chip-collapsible md-visible';
                        elseif ($index < 2) $visibilityClass = 'chip-collapsible lg-visible';
                        elseif ($index < 3) $visibilityClass = 'chip-collapsible xl-visible';

                        $iconClass = $iconMap[$cat] ?? 'ph-books';
                    @endphp
                    <button data-filter="subject" data-value="{{ strtolower(trim($cat)) }}" 
                        class="filter-chip {{ $visibilityClass }} group relative inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border transition-all duration-300 text-xs sm:text-sm cursor-pointer transform hover:-translate-y-0.5 bg-white border-slate-200 text-slate-700 font-medium hover:bg-green-50/80 hover:border-[#106c38] hover:text-[#106c38] hover:shadow-md hover:shadow-green-100 hover:ring-2 hover:ring-[#106c38]/40 whitespace-nowrap">
                        <i class="ph {{ $iconClass }} text-base sm:text-lg"></i>
                        <span>{{ __($cat) }}</span>
                    </button>
                @endforeach

                <!-- Toggle Button -->
                @if(count($existingBigCategories) > 2)
                    <button id="toggle-chips-btn" class="group flex-shrink-0 text-xs sm:text-sm font-semibold text-[#106c38] hover:text-[#0b4d27] inline-flex items-center gap-1 transition-all duration-300 bg-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-full shadow-sm border border-[#106c38]/30 hover:border-[#106c38] hover:ring-2 hover:ring-[#106c38]/40 hover:shadow-md hover:shadow-green-100 cursor-pointer transform hover:-translate-y-0.5">
                        <span id="toggle-chips-text">{{ __('Lainnya') }}</span>
                        <i id="toggle-chips-icon" class="ph ph-caret-down transition-transform duration-300 group-hover:scale-110"></i>
                    </button>
                @endif
            </div>
        </div>

        <!-- Collections Header Count -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">
                <span id="collections-heading-label">{{ __('Semua Kategori') }}</span> (<span id="visible-count">{{ count($latestBooks) }}</span> {{ __('Koleksi') }})
            </h2>
        </div>

        <!-- Results List -->
        <div class="space-y-4 mb-8" id="collections-list">
            @forelse($latestBooks as $book)
                @php
                    $totalCopies = $book->items->count();
                    $availableCopies = $book->items->where('status', 'Tersedia')->count();
                    
                    $bigCategoryName = $book->category ?: 'Umum';
                    $subjValue = strtolower(trim($bigCategoryName));
                @endphp
                <a href="{{ route('books.show', $book->id) }}" class="result-card bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-3.5 sm:p-6 flex gap-3 sm:gap-6 items-start shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group cursor-pointer block"
                     data-title="{{ strtolower($book->title) }}" 
                     data-author="{{ strtolower($book->author) }}" 
                     data-publisher="{{ strtolower($book->publisher) }}" 
                     data-subject="{{ $subjValue }}"
                     data-terlaris="{{ in_array((string)$book->idmaster, $terlarisBookIds ?? []) ? 'true' : 'false' }}"
                     data-available="{{ $availableCopies > 0 ? 'true' : 'false' }}">
                    
                    <!-- Card Numbering Index -->
                    <div class="flex-shrink-0 text-base sm:text-2xl font-black text-slate-200 group-hover:text-[#106c38]/30 transition-colors select-none w-6 sm:w-8 text-center pt-1.5 sm:pt-4">
                        {{ sprintf('%02d', $loop->iteration) }}
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
                        <span class="absolute top-2 left-2 {{ $book->jenis_badge_color }} text-[8px] font-bold px-1.5 py-0.5 rounded shadow">
                            {{ $book->jenis_label }}
                        </span>
                    </div>

                    <!-- Book Details -->
                    <div class="flex-grow flex flex-col h-full">
                        <div class="mb-2">
                            <!-- Category Badge -->
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 tracking-wider uppercase">
                                {{ __($bigCategoryName) }}
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-[#106c38] group-hover:underline transition leading-snug">
                                {{ $book->title ?: __('Judul Tidak Tersedia') }}
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
                            

                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                        <i class="ph ph-warning-circle"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __('Koleksi tidak ditemukan') }}</h3>
                    <p class="text-sm text-slate-500 max-w-md mx-auto">
                        {{ __('Saat ini belum ada koleksi terbaru yang tersedia.') }}
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination & Limit Control Bar -->
        <div id="pagination-controls" class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-200">
            <!-- Limit Selector -->
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span>{{ __('Tampilkan:') }}</span>
                <div class="relative inline-block text-left" id="custom-dropdown">
                    <!-- Dropdown Trigger Button -->
                    <button type="button" id="dropdown-trigger" class="flex items-center justify-between gap-4 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-full pl-4 pr-3 py-2 outline-none cursor-pointer hover:border-[#106c38] focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all shadow-sm min-w-[75px]">
                        <span id="dropdown-selected-label">5</span>
                        <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
                    </button>
                    <!-- Hidden input to store value -->
                    <input type="hidden" id="limit-select" value="5">
                    
                    <!-- Dropdown Options Menu -->
                    <div id="dropdown-menu" class="hidden absolute left-0 bottom-full mb-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 transition-all">
                        <button type="button" data-value="5" class="dropdown-option w-full text-left px-4 py-2.5 text-xs font-bold text-[#106c38] bg-green-50/50 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                            <span>5</span>
                            <i class="ph ph-check text-[12px] active-check"></i>
                        </button>
                        <button type="button" data-value="10" class="dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                            <span>10</span>
                            <i class="ph ph-check text-[12px] active-check hidden"></i>
                        </button>
                        <button type="button" data-value="all" class="dropdown-option w-full text-left px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                            <span>{{ __('Semua') }}</span>
                            <i class="ph ph-check text-[12px] active-check hidden"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Navigation Buttons -->
            <div class="flex items-center gap-1.5" id="page-buttons-container">
                <!-- Page buttons generated dynamically -->
            </div>
        </div>

        <!-- Empty Search State -->
        <div id="empty-state" class="hidden text-center py-16 bg-white rounded-3xl border border-slate-200 border-dashed">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4 text-[#106c38]">
                <i class="ph ph-magnifying-glass text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ __('Koleksi tidak ditemukan') }}</h3>
            <p class="text-slate-505 text-sm max-w-sm mx-auto">{{ __('Kami tidak dapat menemukan buku dengan kata kunci tersebut di koleksi terbaru ini.') }}</p>
        </div>

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('live-search');
            const bookCards = document.querySelectorAll('.result-card');
            const emptyState = document.getElementById('empty-state');
            const visibleCountSpan = document.getElementById('visible-count');
            const headingLabel = document.getElementById('collections-heading-label');
            const filterChips = document.querySelectorAll('.filter-chip');
            const limitSelect = document.getElementById('limit-select');
            const buttonsContainer = document.getElementById('page-buttons-container');
            const paginationBar = document.getElementById('pagination-controls');
            const totalCount = bookCards.length;
            
            // Toggle Chips Logic
            const chipsContainer = document.getElementById('chips-container');
            const toggleChipsBtn = document.getElementById('toggle-chips-btn');
            const toggleChipsText = document.getElementById('toggle-chips-text');
            const toggleChipsIcon = document.getElementById('toggle-chips-icon');
            
            if (toggleChipsBtn && chipsContainer) {
                let chipsExpanded = false;
                toggleChipsBtn.addEventListener('click', () => {
                    chipsExpanded = !chipsExpanded;
                    if (chipsExpanded) {
                        chipsContainer.classList.add('expanded-mode');
                        toggleChipsText.textContent = '{{ __("Sembunyikan") }}';
                        toggleChipsIcon.classList.add('rotate-180');
                    } else {
                        chipsContainer.classList.remove('expanded-mode');
                        toggleChipsText.textContent = '{{ __("Lainnya") }}';
                        toggleChipsIcon.classList.remove('rotate-180');
                    }
                });
            }

            let activeSearch = searchInput ? searchInput.value.toLowerCase().trim() : '';
            let activeFilter = 'all'; // 'all', 'available', or 'subject'
            let activeSubjectValue = '';

            let currentPage = 1;
            let itemsPerPage = 5;

            function applyFilters() {
                let matchedCards = [];

                bookCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const author = card.getAttribute('data-author') || '';
                    const publisher = card.getAttribute('data-publisher') || '';
                    
                    const isAvailable = card.getAttribute('data-available') === 'true';
                    const subject = card.getAttribute('data-subject') || '';

                    let matchesSearch = false;
                    if (typeof window.isFuzzyMatch === 'function') {
                        matchesSearch = window.isFuzzyMatch(title, activeSearch) || 
                                        window.isFuzzyMatch(author, activeSearch) || 
                                        window.isFuzzyMatch(publisher, activeSearch);
                    } else {
                        matchesSearch = title.includes(activeSearch) || author.includes(activeSearch) || publisher.includes(activeSearch);
                    }
                    
                    let matchesFilter = true;
                    if (activeFilter === 'available') {
                        matchesFilter = isAvailable;
                    } else if (activeFilter === 'subject') {
                        if (activeSubjectValue === 'terlaris') {
                            matchesFilter = (card.getAttribute('data-terlaris') === 'true');
                        } else {
                            matchesFilter = (subject === activeSubjectValue);
                        }
                    }

                    if (matchesSearch && matchesFilter) {
                        matchedCards.push(card);
                    } else {
                        card.classList.add('!hidden');
                    }
                });

                if (activeSearch) {
                    matchedCards.sort((a, b) => {
                        const titleA = (a.getAttribute('data-title') || '').toLowerCase();
                        const titleB = (b.getAttribute('data-title') || '').toLowerCase();
                        const authorA = (a.getAttribute('data-author') || '').toLowerCase();
                        const authorB = (b.getAttribute('data-author') || '').toLowerCase();

                        const scoreA = titleA.startsWith(activeSearch) ? 100 : (titleA.includes(' ' + activeSearch) ? 80 : (authorA.startsWith(activeSearch) ? 60 : 10));
                        const scoreB = titleB.startsWith(activeSearch) ? 100 : (titleB.includes(' ' + activeSearch) ? 80 : (authorB.startsWith(activeSearch) ? 60 : 10));

                        return scoreB - scoreA;
                    });

                    const listContainer = document.getElementById('collections-list');
                    if (listContainer) {
                        matchedCards.forEach(card => listContainer.appendChild(card));
                    }
                }

                const totalMatched = matchedCards.length;

                if (visibleCountSpan) {
                    visibleCountSpan.textContent = totalMatched;
                }

                // Update heading label text dynamically
                if (headingLabel) {
                    if (activeFilter === 'all') {
                        headingLabel.textContent = "{{ __('Semua Kategori') }}";
                    } else if (activeFilter === 'available') {
                        headingLabel.textContent = "{{ __('Buku Tersedia Sekarang') }}";
                    } else if (activeFilter === 'subject') {
                        const activeChip = document.querySelector('.filter-chip.active-chip');
                        if (activeChip) {
                            headingLabel.textContent = "{{ __('Buku:') }} " + activeChip.textContent.trim();
                        }
                    }
                }

                // Pagination Calculations
                const totalPages = itemsPerPage === 'all' ? 1 : Math.ceil(totalMatched / itemsPerPage);
                if (currentPage > totalPages) {
                    currentPage = Math.max(1, totalPages);
                }

                const startIndex = itemsPerPage === 'all' ? 0 : (currentPage - 1) * itemsPerPage;
                const endIndex = itemsPerPage === 'all' ? totalMatched : startIndex + itemsPerPage;

                // Show/hide matched cards based on current page
                matchedCards.forEach((card, idx) => {
                    if (idx >= startIndex && idx < endIndex) {
                        card.classList.remove('!hidden');
                    } else {
                        card.classList.add('!hidden');
                    }
                });

                // Render Pagination Controls
                renderPagination(totalPages);

                if (totalMatched === 0 && totalCount > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            // Render Pagination Controls Handler
            function renderPagination(totalPages) {
                if (!paginationBar || !buttonsContainer) return;

                if (totalPages <= 1) {
                    paginationBar.classList.add('hidden');
                    return;
                }
                
                paginationBar.classList.remove('hidden');
                buttonsContainer.innerHTML = '';

                // Prev Page Button
                const prevBtn = document.createElement('button');
                prevBtn.className = `px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-[#106c38] hover:text-[#106c38] transition text-xs font-semibold flex items-center gap-1 cursor-pointer disabled:opacity-40 disabled:pointer-events-none`;
                prevBtn.innerHTML = `<i class="ph ph-caret-left"></i> {{ __('Sebelumnya') }}`;
                prevBtn.disabled = (currentPage === 1);
                prevBtn.addEventListener('click', () => {
                    currentPage--;
                    applyFilters();
                    const liveSearchEl = document.getElementById('live-search');
                    if (liveSearchEl) liveSearchEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
                buttonsContainer.appendChild(prevBtn);

                // Page Number Buttons
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    const isActive = (i === currentPage);
                    pageBtn.className = `w-8 h-8 rounded-full border transition text-xs font-bold flex items-center justify-center cursor-pointer ${
                        isActive 
                            ? 'bg-[#106c38] border-[#106c38] text-white shadow-sm' 
                            : 'border-slate-200 bg-white text-slate-600 hover:border-[#106c38] hover:text-[#106c38]'
                    }`;
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', () => {
                        if (i !== currentPage) {
                            currentPage = i;
                            applyFilters();
                            const liveSearchEl = document.getElementById('live-search');
                            if (liveSearchEl) liveSearchEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    });
                    buttonsContainer.appendChild(pageBtn);
                }

                // Next Page Button
                const nextBtn = document.createElement('button');
                nextBtn.className = `px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-[#106c38] hover:text-[#106c38] transition text-xs font-semibold flex items-center gap-1 cursor-pointer disabled:opacity-40 disabled:pointer-events-none`;
                nextBtn.innerHTML = `{{ __('Berikutnya') }} <i class="ph ph-caret-right"></i>`;
                nextBtn.disabled = (currentPage === totalPages);
                nextBtn.addEventListener('click', () => {
                    currentPage++;
                    applyFilters();
                    const liveSearchEl = document.getElementById('live-search');
                    if (liveSearchEl) liveSearchEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
                buttonsContainer.appendChild(nextBtn);
            }

            // Live Search Input Handler
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    activeSearch = e.target.value.toLowerCase().trim();
                    currentPage = 1;
                    applyFilters();
                });
            }

            // Filter Chip Click Handler
            filterChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    filterChips.forEach(c => {
                        c.classList.remove('active-chip', 'bg-green-50', 'border-[#106c38]', 'text-[#106c38]', 'font-bold');
                        c.classList.add('bg-white', 'border-slate-200', 'text-slate-700', 'font-medium');
                    });
                    
                    chip.classList.remove('bg-white', 'border-slate-200', 'text-slate-700', 'font-medium');
                    chip.classList.add('active-chip', 'bg-green-50', 'border-[#106c38]', 'text-[#106c38]', 'font-bold');

                    const filterType = chip.getAttribute('data-filter');
                    activeFilter = filterType;

                    if (filterType === 'subject') {
                        activeSubjectValue = chip.getAttribute('data-value');
                    } else {
                        activeSubjectValue = '';
                    }

                    currentPage = 1;
                    applyFilters();
                });
            });

            // Limit Selector Handler
            if (limitSelect) {
                limitSelect.addEventListener('change', (e) => {
                    const val = e.target.value;
                    itemsPerPage = val === 'all' ? 'all' : parseInt(val, 10);
                    currentPage = 1;
                    applyFilters();
                });
            }

            // Custom Dropdown UI Handler
            const dropdownTrigger = document.getElementById('dropdown-trigger');
            const dropdownMenu = document.getElementById('dropdown-menu');
            const dropdownOptions = document.querySelectorAll('.dropdown-option');
            const dropdownLabel = document.getElementById('dropdown-selected-label');

            if (dropdownTrigger && dropdownMenu) {
                dropdownTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', () => {
                    dropdownMenu.classList.add('hidden');
                });

                dropdownOptions.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        const val = opt.getAttribute('data-value');
                        const labelText = opt.querySelector('span').textContent.trim();
                        
                        dropdownLabel.textContent = labelText;
                        limitSelect.value = val;
                        
                        // Update active state in UI
                        dropdownOptions.forEach(o => {
                            const check = o.querySelector('.active-check');
                            if (o === opt) {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });

                        // Trigger change event programmatically
                        const changeEvent = new Event('change');
                        limitSelect.dispatchEvent(changeEvent);
                        
                        dropdownMenu.classList.add('hidden');
                    });
                });
            }

            // Initialize view
            applyFilters();
        });
    </script>
</body>
</html>

