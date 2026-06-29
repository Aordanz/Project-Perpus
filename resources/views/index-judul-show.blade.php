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
            border-color: #106c38/30;
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
        
        <!-- Search Summary -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">
                {{ __('Koleksi Berawalan') }} "{{ $initial }}" ({{ $books->total() }} {{ __('Koleksi') }})
            </h2>
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

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $books->links() }}
        </div>

    </div>

    @include('partials.footer')

    <button id="desktop-back-button" onclick="window.history.back();" 
            class="fixed left-4 lg:left-8 xl:left-12 2xl:left-24 top-28 z-40 hidden md:flex items-center justify-start w-12 hover:w-32 h-12 bg-[#106c38] hover:bg-[#0e5c30] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer select-none group overflow-hidden pl-3.5 border border-transparent"
            title="Back">
        <div class="flex items-center gap-2.5 whitespace-nowrap">
            <i class="ph ph-arrow-left text-xl font-bold transition-transform group-hover:-translate-x-0.5"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-bold text-xs uppercase tracking-wider">Back</span>
        </div>
    </button>
</body>
</html>
