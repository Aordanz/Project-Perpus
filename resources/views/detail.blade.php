<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} - OPAC USU Library</title>

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
            background-color: #f8fafc;
        }
        body, input, select, button, textarea {
            font-family: 'Inter', sans-serif !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .cover-glow {
            box-shadow: 0 20px 40px -15px rgba(16, 108, 56, 0.15), 0 15px 25px -10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive table for bibliografi on mobile */
        @media (max-width: 639px) {
            #pane-bibliografi table,
            #pane-bibliografi tbody,
            #pane-bibliografi tr,
            #pane-bibliografi td {
                display: block;
                width: 100%;
            }
            #pane-bibliografi tr {
                padding: 0.65rem 0.85rem;
                border-bottom: 1px solid #f1f5f9;
            }
            #pane-bibliografi td {
                padding: 0.15rem 0 !important;
                background: transparent !important;
                border: none !important;
            }
            #pane-bibliografi td:first-child {
                width: 100% !important;
                font-size: 10px;
                padding-bottom: 0.1rem !important;
            }
            #pane-bibliografi td:last-child {
                font-size: 13px;
            }

            #pane-ketersediaan th,
            #pane-ketersediaan td {
                padding-left: 0.65rem !important;
                padding-right: 0.65rem !important;
                padding-top: 0.65rem !important;
                padding-bottom: 0.65rem !important;
                font-size: 12px;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    @include('partials.navbar')

    <!-- Main Content Area -->
    @php
        $bigCategoryName = $book->category ?: 'Umum';

        $totalCopies = $book->items->count();
        $availableCopies = $book->items->where('status', 'Tersedia')->count();
        $borrowedCopies = $totalCopies - $availableCopies;
    @endphp
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        
        <!-- Back button (Below Navbar) -->
        <div class="mb-6 md:hidden">
            <button onclick="history.back()" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10 cursor-pointer">
                <i class="ph ph-arrow-left"></i> {{ __('Kembali') }}
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Side: Book Cover & Quick Status -->
            <div class="md:col-span-1 space-y-6">
                <!-- Book Cover Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col items-center shadow-sm">
                    @php
                        $allImages = [];
                        if ($book->cover_image) {
                            $allImages[] = asset('covers/' . $book->cover_image);
                        }
                        if ($book->images) {
                            foreach ($book->images as $img) {
                                $allImages[] = asset('covers/' . $img->image_path);
                            }
                        }
                    @endphp

                    <div class="w-36 sm:w-48 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden cover-glow mb-6 relative group select-none">
                        @if(count($allImages) > 0)
                            <!-- Slideshow wrapper -->
                            <div class="w-full h-full relative shadow-inner {{ count($allImages) > 1 ? 'cursor-pointer' : '' }}" id="book-slideshow">
                                @foreach($allImages as $index => $imgUrl)
                                    <img src="{{ $imgUrl }}" 
                                         alt="Cover {{ $index + 1 }}" 
                                         class="slideshow-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                                         data-slide-index="{{ $index }}">
                                @endforeach
                            </div>

                            @if(count($allImages) > 1)
                                <!-- Navigation buttons -->
                                <button type="button" id="btn-slide-prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-7 h-7 rounded-full flex items-center justify-center transition opacity-0 group-hover:opacity-100 z-20 cursor-pointer border-none text-xs">
                                    <i class="ph ph-caret-left-bold"></i>
                                </button>
                                <button type="button" id="btn-slide-next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-7 h-7 rounded-full flex items-center justify-center transition opacity-0 group-hover:opacity-100 z-20 cursor-pointer border-none text-xs">
                                    <i class="ph ph-caret-right-bold"></i>
                                </button>

                                <!-- Navigation dots indicator -->
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5 z-20 bg-black/30 px-2 py-1 rounded-full backdrop-blur-[2px]">
                                    @foreach($allImages as $index => $_)
                                        <span class="slide-dot w-1.5 h-1.5 rounded-full bg-white/50 transition cursor-pointer {{ $index === 0 ? '!bg-white scale-110' : '' }}"
                                              data-dot-index="{{ $index }}"></span>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4">
                                <i class="ph ph-book-open text-6xl mb-3"></i>
                                <span class="text-xs font-bold text-center leading-normal">{{ __('NO COVER IMAGE') }}</span>
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 bg-[#106c38] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow z-20">
                            {{ strtoupper(__($book->jenis)) }}
                        </span>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="w-full text-center py-4 border-t border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Ketersediaan Fisik') }}</span>
                        @if($availableCopies > 0)
                            <div class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 font-bold px-4 py-1.5 rounded-full border border-green-200/50 text-xs">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                {{ $availableCopies }} {{ __('dari') }} {{ $totalCopies }} {{ __('Eksemplar') }}
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 font-bold px-4 py-1.5 rounded-full border border-red-200/50 text-xs">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                {{ __('Semua Salinan Dipinjam') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact / Help info -->
                <div class="bg-gradient-to-br from-[#064e3b] to-[#106c38] rounded-3xl p-6 text-white shadow-sm flex flex-col gap-3">
                    <i class="ph ph-info text-2xl text-green-200"></i>
                    <h4 class="font-bold text-sm">{{ __('Butuh bantuan mencari buku?') }}</h4>
                    <p class="text-xs text-green-100/80 leading-relaxed">
                        {{ __('Silakan hubungi pustakawan kami di meja informasi atau gunakan layanan pesan instan perpustakaan untuk memandu pencarian Anda di rak buku.') }}
                    </p>
                </div>
            </div>

            <!-- Right Side: Detailed Tables inside Tabs -->
            <div class="md:col-span-2 space-y-6">
                <!-- Book Title header -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                    <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[10px] font-bold px-3 py-1 rounded-full mb-3 tracking-wider uppercase">
                        {{ __($bigCategoryName) }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-800 leading-snug mb-3">{{ $book->title }}</h1>
                    <p class="text-sm font-semibold text-slate-500 flex items-center gap-1.5">
                        <i class="ph ph-user text-base text-slate-400"></i> {{ __('Oleh:') }} <span class="text-slate-800">{{ $book->author }}</span>
                    </p>
                </div>

                <!-- Tabs Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                    <!-- Tab Headers -->
                    <div class="border-b border-slate-200 mb-6">
                        <nav class="flex gap-2 -mb-px" aria-label="Tabs">
                            <button id="btn-tab-ketersediaan" onclick="switchTab('ketersediaan')" class="border-t border-x border-slate-200 border-b-white bg-white text-[#106c38] font-bold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none">
                                {{ __('Ketersediaan') }}
                            </button>
                            <button id="btn-tab-bibliografi" onclick="switchTab('bibliografi')" class="border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none">
                                {{ __('Informasi Detail') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Pane: Ketersediaan -->
                    <div id="pane-ketersediaan" class="tab-pane">
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                        <th class="px-5 py-4">{{ __('No. Barcode') }}</th>
                                        <th class="px-5 py-4">{{ __('Tipe') }}</th>
                                        <th class="px-5 py-4">{{ __('Lokasi Rak') }}</th>
                                        <th class="px-5 py-4 text-center">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
                                    @forelse($book->items as $item)
                                        <tr class="hover:bg-slate-50/30 transition">
                                            <td class="px-5 py-4 font-mono text-slate-500">{{ $item->barcode }}</td>
                                            <td class="px-5 py-4 text-slate-700">
                                                <span class="inline-flex items-center bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md text-[10px] font-bold border border-slate-200/50">
                                                    {{ $item->type }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 text-slate-700">{{ $item->location->name }}</td>
                                            <td class="px-5 py-4 text-center">
                                                @if($item->status == 'Tersedia')
                                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 font-bold px-2.5 py-0.5 rounded-full border border-green-200/50 text-xs">
                                                        {{ $item->status }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 font-bold px-2.5 py-0.5 rounded-full border border-amber-200/50 text-xs">
                                                        {{ $item->status }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-6 text-center text-slate-400">
                                                {{ __('Belum ada salinan fisik terdaftar untuk koleksi ini.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Pane: Informasi Detail -->
                    <div id="pane-bibliografi" class="tab-pane hidden">
                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-slate-100 text-sm font-medium">
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Judul') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->title ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('No Panggil') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->call_number ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Penerbit') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->publisher ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Kota') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->publication_city ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Edisi') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->edition ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Tahun') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->publish_year ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('ISBN') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->isbn ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Deskripsi') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->physical_description ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('No. Klasifikasi') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->classification ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Golongan') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->golongan ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Subyek') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->subject ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Bahasa') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->language ? __($book->language) : '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Jenis') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->jenis ? __(ucfirst($book->jenis)) : '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Catatan Umum') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $book->general_note ?: '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Jumlah Eksemplar') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $totalCopies }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Terpinjam') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $borrowedCopies }}</td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Tersedia') }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $availableCopies }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        function switchTab(tabId) {
            const paneKetersediaan = document.getElementById('pane-ketersediaan');
            const paneBibliografi = document.getElementById('pane-bibliografi');
            const btnKetersediaan = document.getElementById('btn-tab-ketersediaan');
            const btnBibliografi = document.getElementById('btn-tab-bibliografi');

            // Reset styles for inactive state
            const inactiveClass = "border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-sm px-5 py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none";
            const activeClass = "border-t border-x border-slate-200 border-b-white bg-white text-[#106c38] font-bold text-sm px-5 py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none";

            if (tabId === 'ketersediaan') {
                paneKetersediaan.classList.remove('hidden');
                paneBibliografi.classList.add('hidden');
                btnKetersediaan.className = activeClass;
                btnBibliografi.className = inactiveClass;
            } else {
                paneKetersediaan.classList.add('hidden');
                paneBibliografi.classList.remove('hidden');
                btnKetersediaan.className = inactiveClass;
                btnBibliografi.className = activeClass;
            }
        }

        // Interactive Slideshow/Carousel for Book Cover Images
        document.addEventListener('DOMContentLoaded', () => {
            const slideshow = document.getElementById('book-slideshow');
            if (!slideshow) return;

            const slides = document.querySelectorAll('.slideshow-slide');
            const dots = document.querySelectorAll('.slide-dot');
            const btnPrev = document.getElementById('btn-slide-prev');
            const btnNext = document.getElementById('btn-slide-next');
            
            const totalSlides = slides.length;
            if (totalSlides <= 1) {
                // If only 1 image (or none), do absolutely nothing. No autoplay, no events.
                return;
            }

            let currentIdx = 0;
            let slideInterval;

            function showSlide(index) {
                // Handle index wrapping
                if (index >= totalSlides) {
                    currentIdx = 0;
                } else if (index < 0) {
                    currentIdx = totalSlides - 1;
                } else {
                    currentIdx = index;
                }

                // Update slides opacity & z-index
                slides.forEach((slide, i) => {
                    if (i === currentIdx) {
                        slide.classList.remove('opacity-0', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                    }
                });

                // Update dots active status
                dots.forEach((dot, i) => {
                    if (i === currentIdx) {
                        dot.classList.add('!bg-white', 'scale-110');
                    } else {
                        dot.classList.remove('!bg-white', 'scale-110');
                    }
                });
            }

            function nextSlide() {
                showSlide(currentIdx + 1);
            }

            function prevSlide() {
                showSlide(currentIdx - 1);
            }

            function startAutoPlay() {
                stopAutoPlay(); // Prevent duplicates
                slideInterval = setInterval(nextSlide, 3500); // 3.5 seconds
            }

            function stopAutoPlay() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
            }

            // Click on image container to advance to next slide
            slideshow.addEventListener('click', () => {
                nextSlide();
                startAutoPlay(); // Restart timer
            });

            // Nav buttons
            if (btnNext) {
                btnNext.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nextSlide();
                    startAutoPlay();
                });
            }

            if (btnPrev) {
                btnPrev.addEventListener('click', (e) => {
                    e.stopPropagation();
                    prevSlide();
                    startAutoPlay();
                });
            }

            // Dot indicators click
            dots.forEach((dot) => {
                dot.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const index = parseInt(dot.getAttribute('data-dot-index'));
                    showSlide(index);
                    startAutoPlay();
                });
            });

            // Auto-rotate
            startAutoPlay();
        });
    </script>

    @include('partials.footer')

</body>
</html>
