<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $book->title }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
            background: #ffffff;
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

    @if(!request()->has('popup'))
        @include('partials.navbar')
    @endif

    <!-- Main Content Area -->
    @php
        $bigCategoryName = $book->category ?: 'Umum';

        $totalCopies = $book->items->count();
        $availableCopies = $book->items->where('kodestatus_eksemplar', 'TSD')->count();
        $borrowedCopies = $totalCopies - $availableCopies;
    @endphp
    <main class="flex-grow max-w-[1400px] w-full mx-auto px-2 sm:px-6 lg:px-8 pt-24 pb-6 sm:pb-12">
        
        <!-- Back button (Below Navbar) -->
        <div class="mb-4 sm:mb-6 lg:hidden">
            <button onclick="window.history.back()" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10 cursor-pointer">
                <i class="ph ph-arrow-left"></i> {{ __('Kembali') }}
            </button>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 xl:gap-8">
            <!-- Left Side: Book Cover & Quick Status -->
            <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                <!-- Book Cover Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-4 sm:p-6 flex flex-col items-center shadow-sm w-full max-w-[280px] mx-auto">
                    @php
                        $allImages = [];
                        if ($book->images && $book->images->isNotEmpty()) {
                            foreach ($book->images as $img) {
                                $allImages[] = asset('covers/' . $img->image_path);
                            }
                        } elseif ($book->cover_image) {
                            $allImages[] = asset('covers/' . $book->cover_image);
                        }
                        $allImages = array_values(array_unique($allImages));
                    @endphp

                    <div class="relative w-full aspect-[2/3] mb-6 group select-none">
                        <!-- Cover Container -->
                        <div class="w-full h-full bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden cover-glow relative">
                            @if(count($allImages) > 0)
                                <!-- Slideshow wrapper -->
                                <div class="w-full h-full relative shadow-inner cursor-zoom-in" id="book-slideshow">
                                    @foreach($allImages as $index => $imgUrl)
                                        <img src="{{ $imgUrl }}" 
                                             alt="Cover {{ $index + 1 }}" 
                                             class="slideshow-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                                             data-slide-index="{{ $index }}">
                                    @endforeach
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4">
                                    <i class="ph ph-book-open text-6xl mb-3"></i>
                                    <span class="text-xs font-bold text-center leading-normal">{{ __('NO COVER IMAGE') }}</span>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 {{ $book->jenis_badge_color }} text-[10px] font-bold px-2 py-0.5 rounded shadow z-20">
                                {{ $book->jenis_label }}
                            </span>
                        </div>

                        @if(count($allImages) > 1)
                            <!-- Navigation buttons (positioned inside the cover image, left and right) -->
                            <button type="button" id="btn-slide-prev" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full w-8 h-8 flex items-center justify-center transition-all z-20 cursor-pointer shadow-md opacity-90 hover:opacity-100">
                                <i class="ph ph-caret-left text-base font-bold"></i>
                            </button>
                            <button type="button" id="btn-slide-next" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-white text-white hover:text-[#106c38] border border-white/10 rounded-full w-8 h-8 flex items-center justify-center transition-all z-20 cursor-pointer shadow-md opacity-90 hover:opacity-100">
                                <i class="ph ph-caret-right text-base font-bold"></i>
                            </button>

                            <!-- Navigation dots indicator -->
                            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5 z-20 bg-black/30 px-2 py-1 rounded-full backdrop-blur-[2px]">
                                @foreach($allImages as $index => $_)
                                    <span class="slide-dot w-1.5 h-1.5 rounded-full bg-white/50 transition cursor-pointer {{ $index === 0 ? '!bg-white scale-110' : '' }}"
                                          data-dot-index="{{ $index }}"></span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="w-full text-center py-4 border-t border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Ketersediaan Fisik') }}</span>
                        @if($totalCopies == 0)
                            <div class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-700 font-bold px-4 py-1.5 rounded-full border border-slate-200/50 text-xs">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                {{ __('Belum Ada Salinan') }}
                            </div>
                        @elseif($availableCopies > 0)
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

                    <!-- E-Book PDF Download Button if exists -->
                    {{-- @if($book->pdf_file)
                        <div class="w-full text-center py-4 border-t border-slate-100 flex flex-col gap-2">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Format Digital') }}</span>
                            <a href="{{ asset('ebooks/' . $book->pdf_file) }}" target="_blank" download class="inline-flex items-center justify-center gap-2 bg-[#106c38] hover:bg-green-800 text-white font-bold px-4 py-2.5 rounded-xl border border-transparent shadow hover:shadow-md transition text-xs cursor-pointer w-full">
                                <i class="ph ph-file-pdf text-base"></i>
                                {{ __('Unduh E-Book (PDF)') }}
                            </a>
                        </div>
                    @endif --}}
                </div>

                <!-- Contact / Help info (Desktop only) -->
                <div class="bg-[#106c38] rounded-3xl p-6 text-white shadow-md hidden lg:flex flex-col gap-4 border border-emerald-700/50">
                    <!-- Header -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-emerald-200 shrink-0 border border-white/20">
                            <i class="ph ph-info text-xl font-bold"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-sm text-white tracking-wide">{{ __('Keterangan Ketersediaan') }}</h4>
                            <p class="text-[11px] text-emerald-200/80 font-medium">{{ __('Panduan istilah koleksi') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-white/15 pt-4 space-y-4">
                        <!-- Tipe Koleksi -->
                        <div>
                            <span class="font-extrabold text-[11px] uppercase tracking-wider text-emerald-200 block mb-2.5">{{ __('Tipe Koleksi:') }}</span>
                            <div class="space-y-2.5">
                                <div class="flex items-start gap-2.5 text-xs">
                                    <span class="font-extrabold text-[10px] bg-white text-[#106c38] px-2 py-0.5 rounded-md font-mono shrink-0 mt-0.5 shadow-sm">STD</span>
                                    <p class="text-[11.5px] text-emerald-50 leading-snug">
                                        <strong class="font-bold text-white">Standard:</strong> {{ __('Jangka waktu pinjam normal') }}
                                    </p>
                                </div>
                                <div class="flex items-start gap-2.5 text-xs">
                                    <span class="font-extrabold text-[10px] bg-white text-[#106c38] px-2 py-0.5 rounded-md font-mono shrink-0 mt-0.5 shadow-sm">KPS</span>
                                    <p class="text-[11.5px] text-emerald-50 leading-snug">
                                        <strong class="font-bold text-white">Pinjam Singkat:</strong> {{ __('Jangka waktu pinjam terbatas/singkat') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Eksemplar -->
                        <div class="pt-3 border-t border-white/10">
                            <span class="font-extrabold text-[11px] uppercase tracking-wider text-emerald-200 block mb-1.5">{{ __('Eksemplar:') }}</span>
                            <p class="text-[11.5px] text-emerald-50 leading-relaxed">
                                {{ __('Jumlah salinan atau unit fisik buku yang tersedia di perpustakaan.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Detailed Tables inside Tabs -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Book Title header -->
                <div class="bg-white rounded-3xl border border-slate-100 p-4 sm:p-6 lg:p-8 shadow-sm">
                    <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[10px] font-bold px-3 py-1 rounded-full mb-3 tracking-wider uppercase">
                        {{ __($bigCategoryName) }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-800 leading-snug mb-3">{{ $book->title ?: __('Judul Tidak Tersedia') }}</h1>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $book->author }}
                    </p>
                </div>

                <!-- Tabs Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-4 sm:p-6 lg:p-8 shadow-sm">
                    <!-- Tab Headers -->
                    <div class="border-b border-slate-200 mb-6 w-full">
                        <nav class="flex gap-2 -mb-px overflow-x-auto scrollbar-hide whitespace-nowrap pb-1" aria-label="Tabs">
                            <button id="btn-tab-ketersediaan" onclick="switchTab('ketersediaan')" class="border-t border-x border-slate-200 border-b-white bg-white text-[#106c38] font-bold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none flex-shrink-0">
                                {{ __('Ketersediaan') }}
                            </button>
                            <button id="btn-tab-bibliografi" onclick="switchTab('bibliografi')" class="border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none flex-shrink-0">
                                {{ __('Informasi Detail') }}
                            </button>
                            <button id="btn-tab-ringkasan" onclick="switchTab('ringkasan')" class="border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none flex-shrink-0">
                                {{ __('Ringkasan Buku') }}
                            </button>
                            <button id="btn-tab-rekomendasi" onclick="switchTab('rekomendasi')" class="border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none flex-shrink-0">
                                {{ __('Rekomendasi') }}
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
                                        <th class="px-5 py-4">{{ __('Lokasi') }}</th>
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
                                                @elseif($item->status == 'Dipinjam')
                                                    @php
                                                        // Cari transaksi peminjaman aktif untuk eksemplar ini
                                                        $activeLoan = \Illuminate\Support\Facades\DB::table('tbltransaksi_pinjam')
                                                            ->where('nomor_eksemplar', $item->barcode)
                                                            ->latest('tglpinjam')
                                                            ->first();
                                                        
                                                        $dueDate = $activeLoan ? \Carbon\Carbon::parse($activeLoan->tglkembali)->translatedFormat('d M Y') : 'Menunggu data';
                                                    @endphp
                                                    <div class="flex flex-col items-center justify-center gap-1">
                                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 font-bold px-2.5 py-0.5 rounded-full border border-amber-200/50 text-xs">
                                                            {{ $item->status }}
                                                        </span>
                                                        @if($activeLoan)
                                                            <span class="text-[10px] text-slate-500 font-medium leading-tight mt-0.5">
                                                                Sampai : <span class="font-bold text-amber-600">{{ $dueDate }}</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 font-bold px-2.5 py-0.5 rounded-full border border-rose-200/50 text-xs">
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
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
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

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Pane: Ringkasan Buku -->
                    <div id="pane-ringkasan" class="tab-pane hidden">
                        @if($book->ringkasanbuku)
                            <div class="prose prose-sm prose-slate max-w-none p-4 sm:p-6 bg-slate-50/50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-left">
                                {!! $book->ringkasanbuku !!}
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-8 sm:p-12 bg-slate-50/50 rounded-2xl border border-slate-100 border-dashed text-slate-400">
                                <i class="ph ph-text-align-left text-4xl mb-3 text-slate-300"></i>
                                <span class="font-medium text-sm">{{ __('Belum ada ringkasan buku') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Tab Pane: Rekomendasi -->
                    <div id="pane-rekomendasi" class="tab-pane hidden">
                        @if($recommendations && $recommendations->count() > 0)
                            <h3 class="font-bold text-slate-800 mb-3">{{ __('Buku Terkait') }}</h3>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($recommendations as $recBook)
                                    <a href="{{ route('books.show', $recBook->idmaster) }}" target="_blank" class="p-4 bg-white hover:bg-slate-50 border border-slate-200 rounded-2xl transition flex items-center justify-between group shadow-sm hover:shadow-md cursor-pointer decoration-none">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-sm text-[#106c38] group-hover:text-green-800 transition line-clamp-2">{{ $recBook->title ?: __('Judul Tidak Tersedia') }}</span>
                                        </div>
                                        <i class="ph ph-arrow-right text-slate-300 group-hover:text-[#106c38] group-hover:translate-x-1 transition-all"></i>
                                    </a>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-6 flex justify-center">
                                {{ $recommendations->appends(array_merge(request()->query(), ['tab' => 'rekomendasi']))->links('pagination::tailwind') }}
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-8 sm:p-12 bg-slate-50/50 rounded-2xl border border-slate-100 border-dashed text-slate-400">
                                <i class="ph ph-books text-4xl mb-3 text-slate-300"></i>
                                <span class="font-medium text-sm">{{ __('Belum ada rekomendasi terkait') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact / Help info (Mobile only) -->
                <div class="bg-[#106c38] rounded-3xl p-5 sm:p-6 text-white shadow-md flex lg:hidden flex-col gap-4 border border-emerald-700/50">
                    <!-- Header -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-emerald-200 shrink-0 border border-white/20">
                            <i class="ph ph-info text-xl font-bold"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-sm text-white tracking-wide">{{ __('Keterangan Ketersediaan') }}</h4>
                            <p class="text-[11px] text-emerald-200/80 font-medium">{{ __('Panduan istilah koleksi') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-white/15 pt-4 space-y-4">
                        <!-- Tipe Koleksi -->
                        <div>
                            <span class="font-extrabold text-[11px] uppercase tracking-wider text-emerald-200 block mb-2.5">{{ __('Tipe Koleksi:') }}</span>
                            <div class="space-y-2.5">
                                <div class="flex items-start gap-2.5 text-xs">
                                    <span class="font-extrabold text-[10px] bg-white text-[#106c38] px-2 py-0.5 rounded-md font-mono shrink-0 mt-0.5 shadow-sm">STD</span>
                                    <p class="text-[11.5px] text-emerald-50 leading-snug">
                                        <strong class="font-bold text-white">Standard:</strong> {{ __('Jangka waktu pinjam normal') }}
                                    </p>
                                </div>
                                <div class="flex items-start gap-2.5 text-xs">
                                    <span class="font-extrabold text-[10px] bg-white text-[#106c38] px-2 py-0.5 rounded-md font-mono shrink-0 mt-0.5 shadow-sm">KPS</span>
                                    <p class="text-[11.5px] text-emerald-50 leading-snug">
                                        <strong class="font-bold text-white">Pinjam Singkat:</strong> {{ __('Jangka waktu pinjam terbatas/singkat') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Eksemplar -->
                        <div class="pt-3 border-t border-white/10">
                            <span class="font-extrabold text-[11px] uppercase tracking-wider text-emerald-200 block mb-1.5">{{ __('Eksemplar:') }}</span>
                            <p class="text-[11.5px] text-emerald-50 leading-relaxed">
                                {{ __('Jumlah salinan atau unit fisik buku yang tersedia di perpustakaan.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        function switchTab(tabId) {
            const panes = {
                'ketersediaan': document.getElementById('pane-ketersediaan'),
                'bibliografi': document.getElementById('pane-bibliografi'),
                'ringkasan': document.getElementById('pane-ringkasan'),
                'rekomendasi': document.getElementById('pane-rekomendasi')
            };
            const btns = {
                'ketersediaan': document.getElementById('btn-tab-ketersediaan'),
                'bibliografi': document.getElementById('btn-tab-bibliografi'),
                'ringkasan': document.getElementById('btn-tab-ringkasan'),
                'rekomendasi': document.getElementById('btn-tab-rekomendasi')
            };

            const inactiveClass = "border-t border-x border-transparent hover:text-slate-700 text-slate-500 font-semibold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none";
            const activeClass = "border-t border-x border-slate-200 border-b-white bg-white text-[#106c38] font-bold text-xs sm:text-sm px-3 sm:px-5 py-2.5 sm:py-3 rounded-t-xl -mb-[1px] cursor-pointer transition-all focus:outline-none";

            for (const key in panes) {
                if (panes[key]) panes[key].classList.add('hidden');
                if (btns[key]) btns[key].className = inactiveClass;
            }

            if (panes[tabId]) panes[tabId].classList.remove('hidden');
            if (btns[tabId]) btns[tabId].className = activeClass;
        }

        // On page load, check if there's a tab query param and switch to it
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'rekomendasi') {
                switchTab('rekomendasi');
            }
        });

        // Interactive Slideshow/Carousel for Book Cover Images
        document.addEventListener('DOMContentLoaded', () => {
            const slideshow = document.getElementById('book-slideshow');
            if (!slideshow) return;

            const slides = document.querySelectorAll('.slideshow-slide');
            const dots = document.querySelectorAll('.slide-dot');
            const btnPrev = document.getElementById('btn-slide-prev');
            const btnNext = document.getElementById('btn-slide-next');
            
            const totalSlides = slides.length;
            
            let currentIdx = 0;
            let slideInterval;

            // Lightbox functionality
            const lightbox = document.getElementById('image-lightbox-modal');
            const lightboxImg = document.getElementById('lightbox-img');
            const closeBtn = document.getElementById('close-lightbox');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');

            const allImageSources = Array.from(slides).map(img => img.src);
            let lightboxCurrentIdx = 0;

            function updateLightboxImage() {
                if (!lightboxImg || allImageSources.length === 0) return;
                lightboxImg.src = allImageSources[lightboxCurrentIdx];
                
                if (allImageSources.length > 1) {
                    if (lightboxPrev) lightboxPrev.classList.remove('hidden');
                    if (lightboxNext) lightboxNext.classList.remove('hidden');
                } else {
                    if (lightboxPrev) lightboxPrev.classList.add('hidden');
                    if (lightboxNext) lightboxNext.classList.add('hidden');
                }
            }

            slideshow.addEventListener('click', (e) => {
                if (e.target.closest('#btn-slide-prev') || e.target.closest('#btn-slide-next') || e.target.closest('.slide-dot')) {
                    return;
                }
                const activeImg = slides[currentIdx];
                if (activeImg) {
                    lightboxCurrentIdx = currentIdx;
                    updateLightboxImage();

                    lightbox.classList.remove('hidden');
                    lightbox.offsetHeight; // trigger reflow
                    lightbox.classList.add('opacity-100', 'flex');
                    lightbox.classList.remove('opacity-0');
                    document.body.style.overflow = 'hidden';
                }
            });

            function closeLightbox() {
                if (!lightbox) return;
                lightbox.classList.add('opacity-0');
                lightbox.classList.remove('opacity-100');
                setTimeout(() => {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }, 300);
            }

            function nextLightboxSlide() {
                if (allImageSources.length <= 1) return;
                lightboxCurrentIdx = (lightboxCurrentIdx + 1) % allImageSources.length;
                updateLightboxImage();
            }

            function prevLightboxSlide() {
                if (allImageSources.length <= 1) return;
                lightboxCurrentIdx = (lightboxCurrentIdx - 1 + allImageSources.length) % allImageSources.length;
                updateLightboxImage();
            }

            if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
            if (lightboxPrev) {
                lightboxPrev.addEventListener('click', (e) => {
                    e.stopPropagation();
                    prevLightboxSlide();
                });
            }
            if (lightboxNext) {
                lightboxNext.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nextLightboxSlide();
                });
            }
            if (lightbox) {
                lightbox.addEventListener('click', (e) => {
                    if (e.target === lightbox || e.target.closest('#close-lightbox')) {
                        closeLightbox();
                    }
                });
            }

            document.addEventListener('keydown', (e) => {
                if (!lightbox || lightbox.classList.contains('hidden')) return;
                
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowRight') {
                    nextLightboxSlide();
                } else if (e.key === 'ArrowLeft') {
                    prevLightboxSlide();
                }
            });

            // Carousel functionality
            if (totalSlides > 1) {
                function showSlide(index) {
                    if (index >= totalSlides) {
                        currentIdx = 0;
                    } else if (index < 0) {
                        currentIdx = totalSlides - 1;
                    } else {
                        currentIdx = index;
                    }

                    slides.forEach((slide, i) => {
                        if (i === currentIdx) {
                            slide.classList.remove('opacity-0', 'z-0');
                            slide.classList.add('opacity-100', 'z-10');
                        } else {
                            slide.classList.remove('opacity-100', 'z-10');
                            slide.classList.add('opacity-0', 'z-0');
                        }
                    });

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
                    stopAutoPlay();
                    slideInterval = setInterval(nextSlide, 3500);
                }

                function stopAutoPlay() {
                    if (slideInterval) {
                        clearInterval(slideInterval);
                    }
                }

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

                dots.forEach((dot) => {
                    dot.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const index = parseInt(dot.getAttribute('data-dot-index'));
                        showSlide(index);
                        startAutoPlay();
                    });
                });

                startAutoPlay();
            }
        });
    </script>

    <!-- Lightbox Modal -->
    <div id="image-lightbox-modal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0 select-none">
        <!-- Close Button -->
        <button id="close-lightbox" class="absolute top-6 right-6 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-2.5 rounded-full transition cursor-pointer z-[10000]">
            <i class="ph ph-x text-2xl font-bold"></i>
        </button>

        <!-- Previous Button -->
        <button id="lightbox-prev" class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-3 rounded-full transition cursor-pointer z-[10000] hidden">
            <i class="ph ph-caret-left text-2xl font-bold"></i>
        </button>

        <!-- Modal Content (Zoomed Image) -->
        <div class="relative max-w-full max-h-[85vh] flex flex-col items-center">
            <img id="lightbox-img" src="" alt="Cover Zoom" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl border border-white/10 transition-all duration-350">
        </div>

        <!-- Next Button -->
        <button id="lightbox-next" class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-3 rounded-full transition cursor-pointer z-[10000] hidden">
            <i class="ph ph-caret-right text-2xl font-bold"></i>
        </button>
    </div>

    </div>

    @include('partials.footer')

</body>
</html>
