<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Kontak Kami') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
    <div class="relative pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden bg-slate-900">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('kolam_perpustakaan.jpg') }}" alt="Perpustakaan USU" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-[#064e3b]/80 via-[#064e3b]/60 to-[#f8fafc]"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white mb-6 shadow-xl">
                <i class="ph ph-phone-call text-3xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">{{ __('Hubungi Kami') }}</h1>
            <p class="text-lg md:text-xl text-green-50/90 max-w-2xl mx-auto font-light leading-relaxed">
                {{ __('Punya pertanyaan atau butuh bantuan? Kami siap membantu melayani kebutuhan informasi dan literatur Anda.') }}
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Info Cards (Left Side) -->
            <div class="lg:col-span-5 flex flex-col space-y-6">
                <!-- Main Info Card -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.08)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-bl-full -mr-16 -mt-16 opacity-50"></div>
                    
                    <h3 class="text-2xl font-bold text-slate-800 mb-6">{{ __('Informasi Kontak') }}</h3>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-map-pin text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-400 uppercase tracking-wider mb-1">{{ __('Alamat Utama') }}</h4>
                                <p class="text-slate-700 font-medium leading-snug">
                                    Jl. Perpustakaan No. 1<br>
                                    Kampus USU Medan 20155<br>
                                    Sumatera Utara, Indonesia
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-phone text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-400 uppercase tracking-wider mb-1">{{ __('Telepon & Fax') }}</h4>
                                <p class="text-slate-700 font-medium leading-snug">
                                    Phone: (+62)61 813526, 811112, 811113<br>
                                    Fax: (+62)61 813108
                                </p>
                            </div>
                        </div>

                        <!-- Email & Web -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-envelope-simple text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-400 uppercase tracking-wider mb-1">{{ __('Email & Website') }}</h4>
                                <p class="text-slate-700 font-medium leading-snug">
                                    Email: <a href="mailto:library@usu.ac.id" class="text-[#106c38] hover:underline">library@usu.ac.id</a><br>
                                    Website: <a href="http://library.usu.ac.id" target="_blank" class="text-[#106c38] hover:underline">library.usu.ac.id</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="bg-white rounded-3xl p-3 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex-grow min-h-[300px] overflow-hidden group">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.1158654877713!2d98.65349547501755!3d3.560756796414163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312fe016a243d9%3A0x6b7724a682f64f43!2sPerpustakaan%20Universitas%20Sumatera%20Utara!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                        class="w-full h-full rounded-2xl grayscale group-hover:grayscale-0 transition-all duration-500 border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form (Right Side) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 md:p-10 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.08)] flex flex-col">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ __('Kirim Pesan') }}</h2>
                    <p class="text-slate-500">{{ __('Isi formulir di bawah ini dan tim kami akan merespons secepat mungkin.') }}</p>
                </div>

                <form action="#" method="POST" class="space-y-6 flex flex-col flex-grow" onsubmit="event.preventDefault(); alert('Pesan Anda telah berhasil dikirim!');">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-600">{{ __('Nama Lengkap') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="ph ph-user text-lg"></i>
                                </div>
                                <input type="text" required placeholder="{{ __('Masukkan nama Anda') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400">
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-600">{{ __('Alamat Email') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="ph ph-envelope text-lg"></i>
                                </div>
                                <input type="email" required placeholder="{{ __('contoh@email.com') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400">
                            </div>
                        </div>
                    </div>

                    <!-- Subjek -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-600">{{ __('Subjek Pesan') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="ph ph-text-aa text-lg"></i>
                            </div>
                            <input type="text" required placeholder="{{ __('Apa yang ingin Anda tanyakan?') }}" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Pesan -->
                    <div class="space-y-2 flex-grow flex flex-col">
                        <label class="text-sm font-bold text-slate-600">{{ __('Pesan Anda') }}</label>
                        <textarea required placeholder="{{ __('Tuliskan detail pertanyaan atau keluhan Anda di sini...') }}" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] outline-none transition text-slate-700 placeholder-slate-400 resize-none flex-grow min-h-[150px]"></textarea>
                    </div>

                    <!-- Tombol Kirim -->
                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto bg-[#106c38] hover:bg-green-800 text-white px-10 py-4 rounded-xl font-bold tracking-wide transition-all shadow-lg shadow-green-900/20 hover:shadow-green-900/40 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            {{ __('Kirim Pesan') }} <i class="ph ph-paper-plane-tilt text-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
