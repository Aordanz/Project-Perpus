<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pusat Informasi & Kontak Resmi Perpustakaan Universitas Sumatera Utara. Temukan lokasi, telepon, email, jam operasional, dan panduan kunjungan.">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Kontak Kami') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
            background-color: #f8fafc;
        }
        .glass-nav {
            background: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-grow">

        <!-- Hero Header Section -->
        <div class="relative pt-28 pb-24 lg:pt-32 lg:pb-36 overflow-hidden bg-slate-900">
            <!-- Background Image with Layered Gradients -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('kolam_perpustakaan.webp') }}" alt="Perpustakaan USU" class="w-full h-full object-cover opacity-35 scale-105 transform">
                <div class="absolute inset-0 bg-gradient-to-b from-[#064e3b]/90 via-[#064e3b]/75 to-[#f8fafc]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,108,56,0.4),transparent_50%)]"></div>
            </div>
            
            <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-green-100 text-xs sm:text-sm font-medium mb-6 shadow-lg">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ __('Pusat Layanan & Informasi Publik') }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                    {{ __('Hubungi & Kunjungi Kami') }}
                </h1>
                
                <p class="text-base sm:text-lg md:text-xl text-green-50/90 max-w-3xl mx-auto font-light leading-relaxed">
                    {{ __('Perpustakaan Universitas Sumatera Utara selalu siap membantu melayani kebutuhan literatur, riset akademik, konsultasi referensi, dan fasilitas belajar Anda.') }}
                </p>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-[90rem] mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-20 space-y-16">
            
            <!-- New White Container for Contact Info (Screenshot match) -->
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 pt-10 sm:p-10 lg:p-12 shadow-[0_15px_60px_rgb(0,0,0,0.08)] relative border border-slate-50 mt-12 sm:mt-16 lg:mt-24">
                
                <!-- Background decorations -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-emerald-50/80 to-transparent rounded-br-[100px] pointer-events-none"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-50/80 to-transparent rounded-bl-[100px] pointer-events-none"></div>
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-100/30 blur-3xl rounded-full"></div>
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-100/30 blur-3xl rounded-full"></div>
                
                <!-- Header -->
                <div class="relative z-10 text-center mb-12 sm:mb-16 lg:mb-20">
                    <h2 class="text-2xl sm:text-4xl lg:text-[2.6rem] font-extrabold text-[#115e32] mb-4 tracking-tight">{{ __('Informasi & Kontak Perpustakaan') }}</h2>
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="h-1 w-12 bg-emerald-200 rounded-full"></div>
                        <div class="h-1 w-3 bg-[#106c38] rounded-full"></div>
                    </div>
                    <p class="text-slate-500 font-medium text-sm sm:text-base">{{ __('Temukan informasi penting dan hubungi kami dengan mudah') }}</p>
                </div>

                <!-- 4 Cards Grid -->
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 gap-y-16">
                    
                    <!-- Card 1: Lokasi Utama -->
                    <div class="bg-white rounded-3xl p-6 pb-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 flex flex-col items-center text-center relative pt-12 hover:-translate-y-2 transition-transform duration-300">
                        <div class="absolute -top-9 w-18 h-18 rounded-full bg-white shadow-[0_8px_20px_rgb(0,0,0,0.08)] flex items-center justify-center border border-slate-50 p-1.5">
                            <div class="w-14 h-14 rounded-full bg-emerald-50/50 flex items-center justify-center">
                                <i class="ph ph-map-pin text-[26px] text-[#106c38]"></i>
                            </div>
                        </div>
                        <h3 class="text-[10px] font-extrabold uppercase tracking-widest text-[#106c38] mb-1.5">{{ __('Lokasi Utama') }}</h3>
                        <h4 class="text-xl font-extrabold text-slate-800 mb-6">{{ __('Alamat Kampus') }}</h4>
                        
                        <div class="flex items-center gap-3 text-left w-full mb-6">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                <i class="ph ph-buildings text-xl"></i>
                            </div>
                            <p class="text-slate-600 text-xs sm:text-[13px] leading-relaxed font-medium">
                                Jl. Perpustakaan No. 1<br>
                                Kampus USU Medan 20155<br>
                                Sumatera Utara, Indonesia
                            </p>
                        </div>
                        


                        <a href="https://maps.google.com/?q=Perpustakaan+Universitas+Sumatera+Utara" target="_blank" class="mt-auto w-full py-3 rounded-2xl border border-slate-200 text-[#106c38] font-bold text-xs sm:text-sm flex items-center justify-center gap-2 hover:bg-[#106c38] hover:text-white hover:border-[#106c38] transition-colors duration-300">
                            <i class="ph ph-map-pin text-base"></i> {{ __('Buka di Google Maps') }} <i class="ph ph-caret-right text-xs"></i>
                        </a>
                    </div>

                    <!-- Card 2: Telepon -->
                    <div class="bg-white rounded-3xl p-6 pb-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 flex flex-col items-center text-center relative pt-12 hover:-translate-y-2 transition-transform duration-300">
                        <div class="absolute -top-9 w-18 h-18 rounded-full bg-white shadow-[0_8px_20px_rgb(0,0,0,0.08)] flex items-center justify-center border border-slate-50 p-1.5">
                            <div class="w-14 h-14 rounded-full bg-emerald-50/50 flex items-center justify-center">
                                <i class="ph ph-phone text-[26px] text-[#106c38]"></i>
                            </div>
                        </div>
                        <h3 class="text-[10px] font-extrabold uppercase tracking-widest text-[#106c38] mb-1.5">{{ __('Hotline & Telefon') }}</h3>
                        <h4 class="text-xl font-extrabold text-slate-800 mb-6">{{ __('Telepon') }}</h4>
                        
                        <div class="flex flex-col gap-4 text-left w-full mb-6">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-phone-call text-base"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">{{ __('Reservasi Buku & Referensi') }}</p>
                                    <p class="text-[#106c38] font-extrabold text-sm">0812-6260-2129</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-phone-call text-base"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">{{ __('Reservasi Artikel') }}</p>
                                    <p class="text-[#106c38] font-extrabold text-sm">0813-9677-7904</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-phone-call text-base"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">{{ __('Layanan Bebas Pustaka') }}</p>
                                    <p class="text-[#106c38] font-extrabold text-sm">0813-6215-8587</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-phone-call text-base"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">{{ __('Telepon Kantor (Humas)') }}</p>
                                    <p class="text-[#106c38] font-extrabold text-sm">(+62) 61 813108</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="tel:+6261813108" class="mt-auto w-full py-3 rounded-2xl bg-[#106c38] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 hover:bg-emerald-700 transition-colors duration-300 shadow-md shadow-emerald-200">
                            <i class="ph ph-phone-call text-base"></i> {{ __('Hubungi Telepon') }}
                        </a>
                    </div>

                    <!-- Card 3: Email & Web -->
                    <div class="bg-white rounded-3xl p-6 pb-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 flex flex-col items-center text-center relative pt-12 hover:-translate-y-2 transition-transform duration-300">
                        <div class="absolute -top-9 w-18 h-18 rounded-full bg-white shadow-[0_8px_20px_rgb(0,0,0,0.08)] flex items-center justify-center border border-slate-50 p-1.5">
                            <div class="w-14 h-14 rounded-full bg-emerald-50/50 flex items-center justify-center">
                                <i class="ph ph-envelope-simple text-[26px] text-[#106c38]"></i>
                            </div>
                        </div>
                        <h3 class="text-[10px] font-extrabold uppercase tracking-widest text-[#106c38] mb-1.5">{{ __('Korespondensi Digital') }}</h3>
                        <h4 class="text-xl font-extrabold text-slate-800 mb-6">{{ __('Email & Portal') }}</h4>
                        
                        <div class="flex flex-col gap-3.5 w-full mb-6">
                            <div class="flex items-center gap-3.5 border border-slate-100 p-4 rounded-2xl bg-white shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-envelope-simple text-lg"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">Email</p>
                                    <p class="text-[#106c38] font-extrabold text-[13px]">library@usu.ac.id</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3.5 border border-slate-100 p-4 rounded-2xl bg-white shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                    <i class="ph ph-globe text-lg"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-[11px] text-slate-500 font-bold mb-0.5">Web</p>
                                    <p class="text-[#106c38] font-extrabold text-[13px]">library.usu.ac.id</p>
                                </div>
                            </div>
                        </div>
                        


                        <a href="mailto:library@usu.ac.id" class="mt-auto w-full py-3 rounded-2xl border border-slate-200 text-[#106c38] font-bold text-xs sm:text-sm flex items-center justify-center gap-2 hover:bg-[#106c38] hover:text-white hover:border-[#106c38] transition-colors duration-300">
                            <i class="ph ph-envelope-simple text-base"></i> {{ __('Kirim Email') }} <i class="ph ph-caret-right text-xs"></i>
                        </a>
                    </div>

                    <!-- Card 4: Jam Operasional -->
                    <div class="bg-white rounded-3xl p-6 pb-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 flex flex-col items-center text-center relative pt-12 hover:-translate-y-2 transition-transform duration-300">
                        <div class="absolute -top-9 w-18 h-18 rounded-full bg-white shadow-[0_8px_20px_rgb(0,0,0,0.08)] flex items-center justify-center border border-slate-50 p-1.5">
                            <div class="w-14 h-14 rounded-full bg-emerald-50/50 flex items-center justify-center">
                                <i class="ph ph-clock text-[26px] text-[#106c38]"></i>
                            </div>
                        </div>
                        <h3 class="text-[10px] font-extrabold uppercase tracking-widest text-[#106c38] mb-1.5">{{ __('Waktu Kunjungan') }}</h3>
                        <h4 class="text-xl font-extrabold text-slate-800 mb-4">{{ __('Jam Operasional') }}</h4>
                        
                        <div class="flex flex-col gap-2.5 text-left w-full mb-3.5">
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-[#106c38]">
                                        <i class="ph ph-calendar-blank text-base"></i>
                                    </div>
                                    <span class="text-[13px] font-semibold text-slate-700">{{ __('Senin – Kamis') }}</span>
                                </div>
                                <span class="text-[13px] font-black text-[#106c38]">08.00 - 20.00</span>
                            </div>
                            <div class="flex items-center justify-between pb-2.5 border-b border-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-[#106c38]">
                                        <i class="ph ph-calendar-blank text-base"></i>
                                    </div>
                                    <span class="text-[13px] font-semibold text-slate-700">{{ __('Jumat') }}</span>
                                </div>
                                <span class="text-[13px] font-black text-[#106c38]">08.00 - 17.00</span>
                            </div>
                            <div class="flex items-center justify-between pt-0.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-[#106c38]">
                                        <i class="ph ph-calendar-blank text-base"></i>
                                    </div>
                                    <span class="text-[13px] font-semibold text-slate-600">{!! __('Sabtu, Minggu<br> & Libur') !!}</span>
                                </div>
                                <span class="text-[11px] font-extrabold text-rose-500 bg-rose-50 px-3 py-1 rounded-md">{{ __('Tutup') }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto w-full bg-emerald-50 rounded-2xl p-3 flex items-center gap-3 border border-emerald-100/60">
                            <i class="ph ph-info text-xl text-[#106c38] shrink-0"></i>
                            <div class="text-left w-full space-y-1">
                                <div class="flex items-center justify-between gap-1 text-[11px]">
                                    <span class="font-bold text-slate-600">{{ __('Istirahat Senin – Kamis:') }}</span>
                                    <span class="font-extrabold text-[#106c38] whitespace-nowrap">12.00 - 13.00</span>
                                </div>
                                <div class="flex items-center justify-between gap-1 text-[11px] pt-1 border-t border-emerald-200/50">
                                    <span class="font-bold text-slate-600">{{ __('Istirahat Jumat:') }}</span>
                                    <span class="font-extrabold text-[#106c38] whitespace-nowrap">12.00 - 13.30</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Banner inside container -->
                <div class="mt-12 flex items-center justify-center relative z-10 border-t border-slate-100 pt-10">
                    <div class="inline-flex items-center gap-4 bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-[#106c38] text-white flex items-center justify-center shrink-0 shadow-md">
                            <i class="ph-fill ph-bank text-lg"></i>
                        </div>
                        <p class="text-[13px] sm:text-sm font-semibold text-slate-700 leading-snug">
                            {!! __('Perpustakaan USU berkomitmen memberikan layanan terbaik<br class="hidden sm:block"> untuk mendukung kebutuhan akademik Anda.') !!} <i class="ph-fill ph-heart text-emerald-500"></i>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Section 2: Interactive Map & Visiting Access Guide -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-100 shadow-[0_10px_40px_rgb(0,0,0,0.06)]">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Map Frame (Lg: 7 Cols) -->
                    <div class="lg:col-span-7 flex flex-col space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#106c38] flex items-center justify-center font-bold">
                                    <i class="ph ph-map-trifold text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800">{{ __('Peta Lokasi Interaktif') }}</h3>
                                    <p class="text-xs text-slate-500">{{ __('Gedung Utama Perpustakaan USU Medan') }}</p>
                                </div>
                            </div>
                            <a href="https://maps.google.com/?q=Perpustakaan+Universitas+Sumatera+Utara" target="_blank" class="text-xs font-semibold text-[#106c38] hover:underline inline-flex items-center gap-1">
                                <span>{{ __('Layar Penuh') }}</span>
                                <i class="ph ph-arrow-square-out text-sm"></i>
                            </a>
                        </div>

                        <div class="relative w-full h-[360px] sm:h-[420px] rounded-2xl overflow-hidden border border-slate-200 shadow-inner group">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.1158654877713!2d98.65349547501755!3d3.560756796414163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312fe016a243d9%3A0x6b7724a682f64f43!2sPerpustakaan%20Universitas%20Sumatera%20Utara!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                                class="w-full h-full border-0 grayscale hover:grayscale-0 transition-all duration-700" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <!-- Access & Visit Guide (Lg: 5 Cols) -->
                    <div class="lg:col-span-5 flex flex-col justify-center space-y-6">
                        <div>
                            <span class="text-xs font-bold text-[#106c38] tracking-widest uppercase bg-green-50 px-3 py-1 rounded-full">{{ __('Panduan Pengunjung') }}</span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-3 mb-2">{{ __('Petunjuk Akses Kunjungan') }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ __('Ikuti panduan ringkas berikut untuk mempermudah alur kunjungan Anda ke Gedung Perpustakaan USU:') }}</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-emerald-50/50 transition">
                                <div class="w-8 h-8 rounded-lg bg-[#106c38] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    1
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Akses Pintu Masuk Kampus') }}</h4>
                                    <p class="text-slate-600 text-xs leading-normal">{{ __('Masuk melalui Pintu Utama 1 atau Pintu 3 Kampus USU Medan, lalu menuju area bundaran perpustakaan.') }}</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-emerald-50/50 transition">
                                <div class="w-8 h-8 rounded-lg bg-[#106c38] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    2
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Area Parkir Pengunjung') }}</h4>
                                    <p class="text-slate-600 text-xs leading-normal">{{ __('Parkir kendaraan roda dua dan roda empat tersedia tepat di area parkir depan dan samping gedung.') }}</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-emerald-50/50 transition">
                                <div class="w-8 h-8 rounded-lg bg-[#106c38] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    3
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Registrasi Presensi Masuk') }}</h4>
                                    <p class="text-slate-600 text-xs leading-normal">{{ __('Tunjukkan Kartu Tanda Mahasiswa (KTM) atau scan identitas pengunjung di gate presensi lobby utama.') }}</p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="flex items-start gap-4 p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-emerald-50/50 transition">
                                <div class="w-8 h-8 rounded-lg bg-[#106c38] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    4
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm mb-0.5">{{ __('Meja Informasi & Layanan') }}</h4>
                                    <p class="text-slate-600 text-xs leading-normal">{{ __('Petunjuk sirkulasi, penyerahan skripsi/tesis, dan penelusuran koleksi siap dilayani di Lantai 1.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Section 3: Official Social Media & Online Portals -->
            <div class="space-y-6">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-2">{{ __('Kanal Layanan Digital & Media Sosial') }}</h2>
                    <p class="text-slate-500 text-sm">{{ __('Terhubung dengan Perpustakaan USU melalui berbagai media informasi dan repositori ilmiah resmi.') }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Portal 1: TikTok -->
                    <a href="https://www.tiktok.com/@usulibrary?is_from_webapp=1&sender_device=pc" target="_blank" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-black flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-sm">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.589 6.686a4.793 4.793 0 0 1-3.77-4.245V2h-3.445v13.672a2.896 2.896 0 1 1-2.896-2.896c.244 0 .484.03.715.086V9.38a6.34 6.34 0 0 0-.715-.04 6.341 6.341 0 1 0 6.341 6.341V9.756a8.214 8.214 0 0 0 4.77 1.516V7.828a4.83 4.83 0 0 1-1.000-1.142z" fill="#FE2C55" transform="translate(0.7, 0.7)"/>
                                <path d="M19.589 6.686a4.793 4.793 0 0 1-3.77-4.245V2h-3.445v13.672a2.896 2.896 0 1 1-2.896-2.896c.244 0 .484.03.715.086V9.38a6.34 6.34 0 0 0-.715-.04 6.341 6.341 0 1 0 6.341 6.341V9.756a8.214 8.214 0 0 0 4.77 1.516V7.828a4.83 4.83 0 0 1-1.000-1.142z" fill="#25F4EE" transform="translate(-0.7, -0.7)"/>
                                <path d="M19.589 6.686a4.793 4.793 0 0 1-3.77-4.245V2h-3.445v13.672a2.896 2.896 0 1 1-2.896-2.896c.244 0 .484.03.715.086V9.38a6.34 6.34 0 0 0-.715-.04 6.341 6.341 0 1 0 6.341 6.341V9.756a8.214 8.214 0 0 0 4.77 1.516V7.828a4.83 4.83 0 0 1-1.000-1.142z" fill="#FFFFFF"/>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 text-sm group-hover:text-[#106c38] transition truncate">TikTok Official</h4>
                            <p class="text-slate-400 text-xs truncate">@usulibrary</p>
                        </div>
                    </a>

                    <!-- Portal 2: X (Twitter) -->
                    <a href="https://x.com/usulibrary" target="_blank" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 text-sm group-hover:text-[#106c38] transition truncate">X (Twitter) Official</h4>
                            <p class="text-slate-400 text-xs truncate">@usulibrary</p>
                        </div>
                    </a>

                    <!-- Portal 3: Instagram -->
                    <a href="https://www.instagram.com/usulibraryofficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="ph ph-instagram-logo"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 text-sm group-hover:text-[#106c38] transition truncate">Instagram Official</h4>
                            <p class="text-slate-400 text-xs truncate">@usulibraryofficial</p>
                        </div>
                    </a>

                    <!-- Portal 4: Website Utama USU -->
                    <a href="https://www.usu.ac.id/" target="_blank" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#106c38] flex items-center justify-center text-2xl flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="ph ph-globe"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 text-sm group-hover:text-[#106c38] transition truncate">Universitas Sumatera Utara</h4>
                            <p class="text-slate-400 text-xs truncate">www.usu.ac.id</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Section 4: AI Chatbot / Assistance Banner -->
            <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-[#064e3b] to-[#106c38] text-white p-8 sm:p-10 lg:p-12 shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="space-y-3 text-center lg:text-left max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold backdrop-blur-md">
                            <i class="ph ph-robot text-sm"></i>
                            <span>{{ __('Asisten AI Virtual') }}</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ __('Butuh Bantuan Cepat atau Informasi Tambahan?') }}</h3>
                        <p class="text-green-100/90 text-sm sm:text-base font-light leading-relaxed">
                            {{ __('Asisten AI kami siap membantu Anda 24/7 mencari informasi katalog buku, syarat bebas pustaka, hingga lokasi rak koleksi. Klik widget obrolan di pojok kanan bawah!') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center justify-center gap-4 flex-shrink-0">
                        <a href="{{ route('bantuan') }}" class="px-6 py-3.5 rounded-xl bg-white text-[#106c38] font-bold text-sm hover:bg-green-50 transition shadow-lg hover:-translate-y-0.5 inline-flex items-center gap-2">
                            <i class="ph ph-info text-lg"></i>
                            <span>{{ __('Pusat Bantuan') }}</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </main>

    @include('partials.footer')
</body>
</html>
