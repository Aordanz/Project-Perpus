<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official Public Access Catalog (OPAC) Universitas Sumatera Utara. Temukan koleksi buku, jurnal, dan karya ilmiah perpustakaan.">

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Masuk') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

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
        .login-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        }
        .role-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(16, 108, 56, 0.25), 0 4px 6px -2px rgba(16, 108, 56, 0.15);
        }
        
        /* Hide default browser eye icon for password inputs */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
            position: absolute;
            right: 0;
        }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-0">
    <main class="w-full flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl w-full grid grid-cols-1 md:grid-cols-12 min-h-[600px]">
        
        <!-- Left Side: Hero Brand Area -->
        <div class="hidden md:flex md:col-span-5 login-gradient p-12 flex-col justify-between relative overflow-hidden text-white">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-25" style="background-image: url('{{ asset('kolam_perpustakaan.webp') }}');"></div>
            
            <!-- Floating Circles -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-green-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-emerald-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition">
                    <img src="{{ asset('logousu.webp') }}" alt="USU Logo" class="h-10 w-10 object-contain">
                    <div class="flex flex-col">
                        <span class="font-bold tracking-tight text-white leading-none text-xs uppercase">{{ __('Perpustakaan') }}</span>
                        <span class="font-bold tracking-tight text-white leading-none text-sm uppercase">USU OPAC</span>
                    </div>
                </a>
            </div>

            <div class="relative z-10 my-auto py-10">
                <h2 class="text-3xl font-bold tracking-tight leading-tight mb-4">
                    {{ __('Jendela Menuju Pustaka Dunia') }}
                </h2>
                <p class="text-green-150 text-sm font-light leading-relaxed mb-6">
                    {{ __('Akses jutaan katalog online, kelola peminjaman, dan jelajahi hasil riset terbaru secara instan.') }}
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>{{ __('Cari & pesan buku kapan saja') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>{{ __('Kelola peminjaman mandiri') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>{{ __('Integrasi satu akun universitas') }}</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-xs text-green-200">
                &copy; {{ date('Y') }} {{ __('Universitas Sumatera Utara') }}. {{ __('All rights reserved.') }}
            </div>
        </div>

        <!-- Right Side: Interaction Area -->
        <div class="md:col-span-7 p-8 md:p-12 flex flex-col justify-center relative">
            
            <!-- Back Button to Home (visible initially or on role selection) -->
            <a href="{{ route('home') }}" id="btn-back-home" class="absolute top-6 right-8 text-slate-400 hover:text-[#106c38] flex items-center gap-1.5 text-xs font-semibold tracking-wide transition uppercase">
                <i class="ph ph-house text-base"></i> {{ __('Beranda') }}
            </a>

            <!-- SECTION 2: LOGIN FORM -->
            <div id="section-login-form">

                <div class="mb-6">
                    <span id="form-role-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2 bg-green-50 text-[#106c38]">
                        <i class="ph ph-user-gear"></i> Pustakawan
                    </span>
                    <h2 id="form-role-title" class="text-2xl font-bold text-slate-800 tracking-tight">
                        Masuk sebagai Pustakawan
                    </h2>
                    <p class="text-slate-500 text-xs mt-1">{{ __('Masukkan kredensial Anda untuk melanjutkan ke aplikasi.') }}</p>
                </div>

                <!-- Form Errors -->
                @if ($errors->any())
                    <div class="mb-5 bg-rose-50 border border-rose-150 rounded-2xl p-4 flex gap-3 text-rose-800">
                        <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                        <div class="text-xs leading-normal">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif



                <form id="login-form" action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    @php
                        $savedLogin = request()->cookie('saved_login') ?: old('login');
                        $savedPassword = request()->cookie('saved_password') ?: '';
                        $rememberChecked = request()->cookie('remember_checked') === 'true' ? 'checked' : '';
                    @endphp
                    <input type="hidden" name="role" id="input-role" value="pustakawan">

                    <!-- Username / Email Input -->
                    <div>
                        <label for="login" id="label-login" class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1.5">Username </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ph ph-user text-lg" id="icon-login"></i>
                            </div>
                            <input type="text" name="login" id="login" value="{{ $savedLogin }}" autocomplete="username" required placeholder="username" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#106c38] focus:bg-white focus:ring-4 focus:ring-green-100 transition-all">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wide">{{ __('Kata Sandi') }}</label>
                            <a href="#" class="text-xs font-semibold text-[#106c38] hover:underline">{{ __('Lupa Sandi?') }}</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ph ph-lock text-lg"></i>
                            </div>
                            <input type="password" name="password" id="password" value="{{ $savedPassword }}" autocomplete="current-password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-10 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#106c38] focus:bg-white focus:ring-4 focus:ring-green-100 transition-all">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer">
                                <i class="ph ph-eye-slash text-lg" id="icon-toggle-password"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" {{ $rememberChecked }} class="w-4.5 h-4.5 rounded border-slate-300 text-[#106c38] focus:ring-[#106c38]">
                        <label for="remember" class="ml-2 text-xs text-slate-500 font-medium select-none cursor-pointer">{{ __('Ingat saya di perangkat ini') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="btn-login-submit" class="w-full bg-gradient-to-r from-[#106c38] to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl py-3 font-semibold text-sm transition-all shadow-md shadow-green-700/20 hover:shadow-lg hover:shadow-green-700/30 flex items-center justify-center gap-1.5 cursor-pointer mt-6 border-none">
                        {{ __('Masuk Sistem') }} <i class="ph ph-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Script for Dynamic Role Swapping -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('icon-toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'ph ph-eye text-lg';
            } else {
                passwordInput.type = 'password';
                icon.className = 'ph ph-eye-slash text-lg';
            }
        }
    </script>
    
    <!-- SweetAlert2 for Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}<br>';
            @endforeach
            
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                html: errorMessages,
                confirmButtonColor: '#106c38',
                confirmButtonText: 'Tutup'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#106c38',
                confirmButtonText: 'Tutup'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#106c38',
                confirmButtonText: 'Lanjut'
            });
        @endif
    </script>
</main>
</body>
</html>
