<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Koleksi Terbaru') }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

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
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased">

    @include('partials.navbar')

    <!-- Main Content Area -->
    <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        
        <!-- Back to Home Link (Below Navbar) -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10">
                <i class="ph ph-arrow-left"></i> {{ __('Kembali ke Beranda') }}
            </a>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight" style="font-family: 'Outfit', sans-serif;">{{ __('Koleksi Terbaru') }}</h2>
        </div>

        <!-- Helper Functions and Subject Mapping -->
        @php
            $getBigCategory = function($subj) {
                $lower = strtolower(trim($subj));
                
                // Agama
                if (str_contains($lower, 'religion') || str_contains($lower, 'islam') || str_contains($lower, 'faith') || str_contains($lower, 'agama')) {
                    return 'Agama';
                }
                
                // Kesehatan & Kedokteran
                if (
                    str_contains($lower, 'medicine') || 
                    str_contains($lower, 'nursing') || 
                    str_contains($lower, 'public health') || 
                    str_contains($lower, 'pharmacy') || 
                    str_contains($lower, 'dentistry') ||
                    str_contains($lower, 'kedokteran') ||
                    str_contains($lower, 'keperawatan') ||
                    str_contains($lower, 'kesehatan') ||
                    str_contains($lower, 'farmasi')
                ) {
                    return 'Kesehatan & Kedokteran';
                }
                
                // Sains & Teknologi
                if (
                    str_contains($lower, 'engineering') || 
                    str_contains($lower, 'chemical') || 
                    str_contains($lower, 'mathematics') || 
                    str_contains($lower, 'biology') || 
                    str_contains($lower, 'computer') || 
                    str_contains($lower, 'forestry') || 
                    str_contains($lower, 'agriculture') ||
                    str_contains($lower, 'teknik') ||
                    str_contains($lower, 'matematika') ||
                    str_contains($lower, 'biologi') ||
                    str_contains($lower, 'komputer') ||
                    str_contains($lower, 'kehutanan') ||
                    str_contains($lower, 'pertanian')
                ) {
                    return 'Sains & Teknologi';
                }
                
                // Sosial & Humaniora
                if (
                    str_contains($lower, 'social') || 
                    str_contains($lower, 'economics') || 
                    str_contains($lower, 'management') || 
                    str_contains($lower, 'law') || 
                    str_contains($lower, 'wisdom') ||
                    str_contains($lower, 'ekonomi') ||
                    str_contains($lower, 'manajemen') ||
                    str_contains($lower, 'hukum') ||
                    str_contains($lower, 'sosial') ||
                    str_contains($lower, 'kearifan')
                ) {
                    return 'Sosial & Humaniora';
                }
                
                return 'Umum';
            };

            // Dynamically gather only the BIG categories that exist in the loaded books
            $existingBigCategories = $latestBooks->map(function($book) use ($getBigCategory) {
                return $getBigCategory($book->category ?: ($book->subject ?: 'General'));
            })->unique()->filter()->values();
        @endphp

        <!-- Student-Friendly Search & Filter Panel -->
        <div class="flex flex-col gap-4 mb-8 max-w-2xl mx-auto">
            <!-- Search Row (Modern Rounded-Full Layout) -->
            <div class="flex items-center gap-3">
                <!-- Search Input -->
                <div class="relative flex-grow shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="ph ph-magnifying-glass text-lg"></i>
                    </div>
                    <input type="text" id="live-search" placeholder="{{ __('Ketik kata kunci untuk mencari (judul, pengarang, penerbit)...') }}" 
                        class="w-full pl-11 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-full outline-none focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all placeholder:text-slate-400">
                </div>
            </div>

            <!-- Dynamic Quick Filter Chips with wrap layout -->
            <div class="flex flex-wrap items-center justify-center gap-2.5">
                <button data-filter="all" class="filter-chip px-4 py-2 text-xs font-bold rounded-full transition-all border border-[#106c38] bg-[#106c38] text-white shadow-sm whitespace-nowrap cursor-pointer">
                    {{ __('Semua Buku') }}
                </button>
                <button data-filter="available" class="filter-chip px-4 py-2 text-xs font-semibold rounded-full transition-all border border-slate-200 bg-white text-slate-600 hover:border-[#106c38]/40 hover:text-[#106c38] whitespace-nowrap cursor-pointer">
                    {{ __('Tersedia Sekarang') }}
                </button>
                @foreach($existingBigCategories as $cat)
                    <button data-filter="subject" data-value="{{ strtolower(trim($cat)) }}" class="filter-chip px-4 py-2 text-xs font-semibold rounded-full transition-all border border-slate-200 bg-white text-slate-600 hover:border-[#106c38]/40 hover:text-[#106c38] whitespace-nowrap cursor-pointer">
                        {{ __($cat) }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Collections Header Count -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">
                <span id="collections-heading-label">{{ __('Semua Buku') }}</span> (<span id="visible-count">{{ count($latestBooks) }}</span> {{ __('Koleksi') }})
            </h2>
        </div>

        <!-- Results List -->
        <div class="space-y-4 mb-8" id="collections-list">
            @forelse($latestBooks as $book)
                @php
                    $totalCopies = $book->items->count();
                    $availableCopies = $book->items->where('status', 'Tersedia')->count();
                    
                    $dbSubject = $book->category ?: ($book->subject ?: 'General');
                    $bigCategoryName = $getBigCategory($dbSubject);
                    $subjValue = strtolower(trim($bigCategoryName));
                @endphp
                <div class="result-card bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 flex gap-4 sm:gap-6 items-start shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group"
                     data-title="{{ strtolower($book->title) }}" 
                     data-author="{{ strtolower($book->author) }}" 
                     data-publisher="{{ strtolower($book->publisher) }}" 
                     data-subject="{{ $subjValue }}"
                     data-available="{{ $availableCopies > 0 ? 'true' : 'false' }}">
                    
                    <!-- Card Numbering Index -->
                    <div class="flex-shrink-0 text-xl sm:text-2xl font-black text-slate-200 group-hover:text-[#106c38]/30 transition-colors select-none w-8 text-center pt-2 sm:pt-4">
                        {{ sprintf('%02d', $loop->iteration) }}
                    </div>

                    <!-- Book Cover -->
                    <div class="w-24 sm:w-28 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-2">
                                <i class="ph ph-book-open text-3xl mb-1.5"></i>
                                <span class="text-[9px] font-bold text-center leading-tight">NO COVER</span>
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 bg-[#106c38] text-white text-[8px] font-bold px-1.5 py-0.5 rounded shadow">
                            {{ strtoupper($book->type ?: 'buku') }}
                        </span>
                    </div>

                    <!-- Book Details -->
                    <div class="flex-grow flex flex-col h-full">
                        <div class="mb-2">
                            <!-- Category Badge -->
                            <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 tracking-wider uppercase">
                                {{ __($bigCategoryName) }}
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
                                <span>{{ __('No. Klasifikasi:') }} <strong class="text-slate-700">{{ $book->classification }}</strong></span>
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
                                    {{ __('Penyimpanan:') }} 
                                    @php
                                        $locNames = $book->items->map(function($i) { return __($i->location->name); })->unique();
                                    @endphp
                                    <strong class="text-slate-700">{{ $locNames->implode(', ') ?: __('Tidak ditentukan') }}</strong>
                                </span>
                            </div>
                            
                            <!-- Available count -->
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
                        <span id="dropdown-selected-label">10</span>
                        <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
                    </button>
                    <!-- Hidden input to store value -->
                    <input type="hidden" id="limit-select" value="10">
                    
                    <!-- Dropdown Options Menu -->
                    <div id="dropdown-menu" class="hidden absolute left-0 bottom-full mb-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 transition-all">
                        <button type="button" data-value="10" class="dropdown-option w-full text-left px-4 py-2.5 text-xs font-bold text-[#106c38] bg-green-50/50 hover:bg-green-50 hover:text-[#106c38] transition flex items-center justify-between">
                            <span>10</span>
                            <i class="ph ph-check text-[12px] active-check"></i>
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

            let activeSearch = '';
            let activeFilter = 'all'; // 'all', 'available', or 'subject'
            let activeSubjectValue = '';

            let currentPage = 1;
            let itemsPerPage = 10;

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
                        matchesFilter = (subject === activeSubjectValue);
                    }

                    if (matchesSearch && matchesFilter) {
                        matchedCards.push(card);
                    } else {
                        card.classList.add('!hidden');
                    }
                });

                const totalMatched = matchedCards.length;

                if (visibleCountSpan) {
                    visibleCountSpan.textContent = totalMatched;
                }

                // Update heading label text dynamically
                if (headingLabel) {
                    if (activeFilter === 'all') {
                        headingLabel.textContent = "{{ __('Semua Buku') }}";
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

                // Render Page Control Buttons
                renderPagination(totalMatched, totalPages);

                if (totalMatched === 0 && totalCount > 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }

            function renderPagination(totalMatched, totalPages) {
                if (totalMatched === 0) {
                    paginationBar.classList.add('hidden');
                    return;
                }
                
                paginationBar.classList.remove('hidden');
                buttonsContainer.innerHTML = '';

                if (itemsPerPage === 'all' || totalPages <= 1) {
                    buttonsContainer.classList.add('hidden');
                    return;
                }
                
                buttonsContainer.classList.remove('hidden');

                // Previous Page Button
                const prevBtn = document.createElement('button');
                prevBtn.className = `px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-[#106c38] hover:text-[#106c38] transition text-xs font-semibold flex items-center gap-1 cursor-pointer disabled:opacity-40 disabled:pointer-events-none`;
                prevBtn.innerHTML = `<i class="ph ph-caret-left"></i> {{ __('Sebelumnya') }}`;
                prevBtn.disabled = (currentPage === 1);
                prevBtn.addEventListener('click', () => {
                    currentPage--;
                    applyFilters();
                    document.getElementById('live-search').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
                buttonsContainer.appendChild(prevBtn);

                // Numbered Buttons
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    if (i === currentPage) {
                        pageBtn.className = `w-8 h-8 rounded-full bg-[#106c38] text-white font-bold text-xs flex items-center justify-center shadow-sm cursor-default`;
                    } else {
                        pageBtn.className = `w-8 h-8 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-[#106c38] hover:text-[#106c38] transition font-semibold text-xs flex items-center justify-center cursor-pointer`;
                    }
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', () => {
                        if (i !== currentPage) {
                            currentPage = i;
                            applyFilters();
                            document.getElementById('live-search').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
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
                    document.getElementById('live-search').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
                buttonsContainer.appendChild(nextBtn);
            }

            // Live Search Input Handler
            searchInput.addEventListener('input', (e) => {
                activeSearch = e.target.value.toLowerCase().trim();
                currentPage = 1;
                applyFilters();
            });

            // Filter Chip Click Handler
            filterChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    filterChips.forEach(c => {
                        c.classList.remove('active-chip', 'bg-[#106c38]', 'text-white', 'border-[#106c38]', 'font-bold');
                        c.classList.add('bg-white', 'text-slate-600', 'border-slate-200', 'font-semibold');
                    });
                    
                    chip.classList.remove('bg-white', 'text-slate-600', 'border-slate-200', 'font-semibold');
                    chip.classList.add('active-chip', 'bg-[#106c38]', 'text-white', 'border-[#106c38]', 'font-bold');

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

