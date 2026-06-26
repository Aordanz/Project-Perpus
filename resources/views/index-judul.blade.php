<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Index Judul') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <!-- Header Section with Image Background -->
    <div class="relative pt-24 pb-24 lg:pt-28 lg:pb-32 overflow-hidden bg-slate-900">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('kolam_perpustakaan.jpg') }}" alt="Perpustakaan USU" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-[#064e3b]/80 via-[#064e3b]/60 to-[#f8fafc]"></div>
        </div>
        


        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white mb-6 shadow-xl">
                <i class="ph ph-books text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">{{ __('Index Judul') }}</h1>
            <p class="text-lg md:text-xl text-green-50/90 max-w-2xl mx-auto font-light leading-relaxed">
                {{ __('Temukan buku berdasarkan abjad atau angka pertama dari judul buku. Klik pada karakter di bawah ini untuk memulai pencarian.') }}
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-20">
        <div class="bg-white rounded-3xl p-8 md:p-12 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.08)] relative">
            
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-slate-800">{{ __('Cari Berdasarkan Awalan') }}</h2>
                <div class="w-20 h-1 bg-[#106c38] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Numbers Section -->
            <div class="mb-10">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 text-center">{{ __('Angka') }}</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach(range(0, 9) as $number)
                        <a href="{{ route('search', ['starts_with' => $number]) }}" 
                           class="w-12 h-12 flex items-center justify-center bg-slate-50 hover:bg-[#106c38] text-slate-700 hover:text-white rounded-xl font-bold text-lg border border-slate-200 hover:border-[#106c38] shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                            {{ $number }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="w-full h-px bg-slate-100 mb-10"></div>

            <!-- Alphabet Section -->
            <div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 text-center">{{ __('Abjad') }}</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach(range('A', 'Z') as $letter)
                        <a href="{{ route('search', ['starts_with' => $letter]) }}" 
                           class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center bg-slate-50 hover:bg-[#106c38] text-slate-700 hover:text-white rounded-xl font-bold text-lg sm:text-xl border border-slate-200 hover:border-[#106c38] shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                            {{ $letter }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')

</body>
</html>
