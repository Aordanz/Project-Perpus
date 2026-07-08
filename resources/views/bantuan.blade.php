<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

    <title>{{ __('Bantuan') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <main>

    <!-- Header Section with Image Background -->
    <div class="relative pt-24 pb-24 lg:pt-28 lg:pb-32 overflow-hidden bg-slate-900">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('kolam_perpustakaan.webp') }}" alt="Perpustakaan USU" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-[#064e3b]/80 via-[#064e3b]/60 to-[#f8fafc]"></div>
        </div>
        


        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white mb-6 shadow-xl">
                <i class="ph ph-question text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">{{ __('Pusat Bantuan') }}</h1>
            <p class="text-lg md:text-xl text-green-50/90 max-w-2xl mx-auto font-light leading-relaxed">
                {{ __('Panduan lengkap untuk memaksimalkan penggunaan layanan Online Public Access Catalog (OPAC) Perpustakaan USU.') }}
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-20">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-slate-100 overflow-hidden">
            
            <div class="p-8 md:p-12">
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-magnifying-glass text-2xl font-bold"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">{{ __('Bantuan Pencarian') }}</h2>
                        <p class="text-slate-500 mt-1">{{ __('Pelajari metode pencarian untuk menemukan koleksi dengan cepat') }}</p>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none prose-p:text-slate-600 prose-p:leading-relaxed prose-strong:text-[#106c38]">
                    <p class="text-lg mb-8">
                        {{ __('Ada 2 metode pencarian yang tersedia pada pencarian OPAC perpustakaan. Pilihlah metode yang paling sesuai dengan kebutuhan informasi Anda.') }}
                    </p>

                    <div class="grid md:grid-cols-2 gap-8 mt-8">
                        <!-- Pencarian Sederhana -->
                        <div class="bg-slate-50 rounded-2xl p-6 md:p-8 border border-slate-100 hover:border-green-200 transition-colors group">
                            <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center mb-6 text-[#106c38] group-hover:scale-110 transition-transform duration-300">
                                <i class="ph ph-cursor-click text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                                {{ __('Pencarian Sederhana') }}
                            </h3>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">
                                {{ __('Merupakan metode yang') }} <strong>{{ __('paling sederhana') }}</strong> {{ __('pencarian pada OPAC, Anda hanya memasukkan kata kunci apapun, baik itu yang terkandung dalam judul, pengarang, atau subyek tertentu.') }}
                            </p>
                            <div class="mt-4 p-4 bg-white rounded-xl border border-slate-200 text-sm text-slate-500">
                                <i class="ph ph-lightbulb text-amber-500 mr-2"></i><strong>{{ __('Tips:') }}</strong> {{ __('Anda dapat masukkan lebih dari satu kata kunci dalam metode Pencarian Sederhana dan akan memperluas hasil pencarian Anda.') }}
                            </div>
                        </div>

                        <!-- Pencarian Spesifik -->
                        <div class="bg-slate-50 rounded-2xl p-6 md:p-8 border border-slate-100 hover:border-green-200 transition-colors group">
                            <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center mb-6 text-[#106c38] group-hover:scale-110 transition-transform duration-300">
                                <i class="ph ph-funnel text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                                {{ __('Pencarian Spesifik') }}
                            </h3>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">
                                {{ __('Memungkinkan Anda menentukan kata kunci dalam') }} <strong>{{ __('bagian yang lebih spesifik.') }}</strong> {{ __('Jika Anda ingin kata kunci Anda hanya terdapat dalam bagian judul, kemudian ketik kata kunci di bagian Judul dan sistem akan mencari ruang lingkup itu hanya pada bagian Judul, bukan di bagian lain.') }}
                            </p>
                            <div class="mt-4 p-4 bg-white rounded-xl border border-slate-200 text-sm text-slate-500">
                                <i class="ph ph-map-pin text-[#106c38] mr-2"></i>{{ __('Lokasi field memungkinkan Anda') }} <strong>{{ __('mempersempit hasil pencarian') }}</strong> {{ __('dengan lokasi tertentu, sehingga hanya koleksi yang ada di lokasi yang dipilih ditampilkan oleh sistem.') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Call to action -->
                    <div class="mt-12 bg-gradient-to-r from-[#064e3b] to-[#106c38] rounded-2xl p-8 text-center text-white shadow-lg relative overflow-hidden">
                        <!-- Abstract Shapes -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        
                        <h3 class="text-2xl font-bold mb-3 relative z-10">{{ __('Siap untuk memulai pencarian?') }}</h3>
                        <p class="text-green-100 mb-6 relative z-10">{{ __('Kembali ke halaman utama untuk mulai mencari referensi yang Anda butuhkan.') }}</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white text-[#106c38] px-8 py-3 rounded-full font-bold hover:bg-green-50 transition-colors shadow-md relative z-10">
                            {{ __('Cari Sekarang') }} <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </main>

    @include('partials.footer')

</body>
</html>
