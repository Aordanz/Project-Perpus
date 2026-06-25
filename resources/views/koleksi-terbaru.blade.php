<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Koleksi Terbaru') }} - OPAC USU Library</title>

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
            background-color: #ffffff;
            font-family: 'Inter', sans-serif !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased">

    @include('partials.navbar')

    <!-- Main Content Area -->
    <main class="flex-grow w-full pt-16">
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Back to Home Link (Below Navbar) -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10">
                    <i class="ph ph-arrow-left"></i> {{ __('Kembali ke Beranda') }}
                </a>
            </div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-light text-slate-800 tracking-widest" style="font-family: 'Inter', sans-serif;">{{ __('Koleksi Terbaru') }}</h2>
            </div>

            <!-- Filter Section -->
            <div class="mb-8 flex justify-end">
                <form method="GET" action="{{ route('koleksi.terbaru') }}" class="flex items-center gap-3">
                    <label for="location" class="text-sm font-medium text-slate-700 whitespace-nowrap">{{ __('Filter Lokasi') }}:</label>
                    <div class="relative">
                        <select name="location" id="location" onchange="this.form.submit()" class="appearance-none bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] block w-full pl-4 pr-10 py-2.5 outline-none cursor-pointer shadow-sm transition-all hover:border-[#106c38]">
                            <option value="">{{ __('Semua Kategori (Beranda)') }}</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->code }}" {{ request('location') == $loc->code ? 'selected' : '' }}>
                                    {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="ph ph-caret-down"></i>
                        </div>
                    </div>
                </form>
            </div>

        <div class="space-y-6">
            @forelse($latestBooks as $index => $book)
                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Number -->
                    <div class="w-8 flex-shrink-0 text-center">
                        <span class="text-xl font-bold text-red-700">{{ $index + 1 }}.</span>
                    </div>

                    <!-- White Card Link -->
                    <a href="{{ route('books.show', $book->id) }}" class="flex-grow flex items-start gap-5 sm:gap-6 bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-[#106c38]/30 transition-all duration-300 group">
                        
                        <!-- Book Cover/Icon -->
                        <div class="w-24 sm:w-28 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative">
                            @if($book->cover_image)
                                <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-2 group-hover:text-[#106c38] transition-colors">
                                    <i class="ph ph-book-open text-3xl mb-1.5"></i>
                                    <span class="text-[9px] font-bold text-center leading-tight">{{ __('Cover Buku') }}</span>
                                </div>
                            @endif
                            
                            <!-- NEW Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="inline-block px-1.5 py-0.5 bg-red-600 text-white text-[9px] font-bold rounded shadow-sm tracking-wider">NEW</span>
                            </div>
                        </div>

                        <!-- Book Details -->
                        <div class="flex-grow flex flex-col justify-center h-full pt-1">
                            <h3 class="text-lg md:text-xl font-bold text-slate-800 group-hover:text-[#106c38] transition-colors mb-2 leading-tight">
                                {{ $book->title }}
                            </h3>
                            <p class="text-sm text-slate-700 mb-1 font-medium">{{ $book->classification }} {{ $book->author }}</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">{{ $book->subject }}</p>
                            <p class="text-sm text-slate-500">{{ $book->publisher }}{{ $book->publish_year ? ', ' . $book->publish_year : '' }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                        <i class="ph ph-books text-3xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-800 mb-2">{{ __('Tidak ada koleksi') }}</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto">{{ __('Saat ini belum ada koleksi terbaru yang tersedia untuk lokasi yang dipilih.') }}</p>
                </div>
            @endforelse
        </div>
        </div>

    </main>

    @include('partials.footer')

</body>
</html>
