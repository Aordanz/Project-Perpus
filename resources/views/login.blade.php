<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - OPAC Universitas Sumatera Utara</title>

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
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-0">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl w-full grid grid-cols-1 md:grid-cols-12 min-h-[600px]">
        
        <!-- Left Side: Hero Brand Area -->
        <div class="hidden md:flex md:col-span-5 login-gradient p-12 flex-col justify-between relative overflow-hidden text-white">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0 bg-cover bg-center mix-blend-multiply opacity-25" style="background-image: url('{{ asset('kolam_perpustakaan.jpg') }}');"></div>
            
            <!-- Floating Circles -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-green-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-emerald-500 rounded-full mix-blend-screen filter blur-3xl opacity-20"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition">
                    <img src="{{ asset('logo-usu.png') }}" alt="USU Logo" class="h-10 w-auto bg-white rounded-full p-0.5">
                    <div class="flex flex-col">
                        <span class="font-bold tracking-tight text-white leading-none text-xs uppercase">Perpustakaan</span>
                        <span class="font-bold tracking-tight text-white leading-none text-sm uppercase">USU OPAC</span>
                    </div>
                </a>
            </div>

            <div class="relative z-10 my-auto py-10">
                <h2 class="text-3xl font-bold tracking-tight leading-tight mb-4">
                    Jendela Menuju Pustaka Dunia
                </h2>
                <p class="text-green-150 text-sm font-light leading-relaxed mb-6">
                    Akses jutaan katalog online, kelola peminjaman, dan jelajahi hasil riset terbaru secara instan.
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>Cari & pesan buku kapan saja</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>Kelola peminjaman mandiri</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <i class="ph ph-check-circle text-lg text-emerald-400"></i>
                        <span>Integrasi satu akun universitas</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-xs text-green-200">
                &copy; {{ date('Y') }} Universitas Sumatera Utara. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Interaction Area -->
        <div class="md:col-span-7 p-8 md:p-12 flex flex-col justify-center relative">
            
            <!-- Back Button to Home (visible initially or on role selection) -->
            <a href="{{ route('home') }}" id="btn-back-home" class="absolute top-6 right-8 text-slate-400 hover:text-[#106c38] flex items-center gap-1.5 text-xs font-semibold tracking-wide transition uppercase">
                <i class="ph ph-house text-base"></i> Beranda
            </a>

            <!-- SECTION 1: ROLE SELECTION -->
            <div id="section-role-select" class="{{ $selectedRole ? 'hidden' : '' }}">
                <div class="mb-8">
                    <span class="text-[#106c38] font-bold text-xs uppercase tracking-wider block mb-2">Selamat Datang</span>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight mb-2">Pilih Metode Masuk</h1>
                    <p class="text-slate-500 text-sm">Masuk ke sistem OPAC untuk pengalaman penuh sesuai peran Anda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <!-- Option Pustakawan -->
                    <button type="button" onclick="selectRole('pustakawan')" class="role-card w-full text-left p-6 rounded-2xl border-2 border-slate-100 bg-white hover:border-[#106c38] flex flex-col justify-between min-h-[170px] outline-none cursor-pointer">
                        <div class="w-12 h-12 bg-green-50 text-[#106c38] rounded-xl flex items-center justify-center mb-4 transition-colors">
                            <i class="ph ph-user-gear text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pustakawan</h3>
                            <p class="text-xs text-slate-550 leading-normal">Kelola sirkulasi, data buku, anggota, dan administrasi perpus.</p>
                        </div>
                    </button>

                    <!-- Option Anggota -->
                    <button type="button" onclick="selectRole('anggota')" class="role-card w-full text-left p-6 rounded-2xl border-2 border-slate-100 bg-white hover:border-[#106c38] flex flex-col justify-between min-h-[170px] outline-none cursor-pointer">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 transition-colors">
                            <i class="ph ph-identification-card text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Anggota</h3>
                            <p class="text-xs text-slate-550 leading-normal">Untuk Mahasiswa, Dosen, Alumni, dan Anggota Terdaftar.</p>
                        </div>
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-slate-400 text-xs">Butuh bantuan masuk? <a href="#" class="text-[#106c38] font-semibold hover:underline">Hubungi IT Helpdesk</a></p>
                </div>
            </div>

            <!-- SECTION 2: LOGIN FORM -->
            <div id="section-login-form" class="{{ $selectedRole ? '' : 'hidden' }}">
                
                <!-- Back to Role Selection -->
                <button type="button" onclick="backToRoleSelect()" class="text-slate-400 hover:text-slate-600 flex items-center gap-1 text-xs font-semibold transition mb-6 bg-transparent border-none cursor-pointer p-0">
                    <i class="ph ph-arrow-left text-sm"></i> Ganti Peran
                </button>

                <div class="mb-6">
                    <span id="form-role-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2">
                        <!-- Filled by JS -->
                    </span>
                    <h2 id="form-role-title" class="text-2xl font-bold text-slate-800 tracking-tight">
                        <!-- Filled by JS -->
                    </h2>
                    <p class="text-slate-500 text-xs mt-1">Masukkan kredensial Anda untuk melanjutkan ke aplikasi.</p>
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
                    <input type="hidden" name="role" id="input-role" value="{{ $selectedRole ?? '' }}">

                    <!-- Email Input -->
                    <div>
                        <label for="email" id="label-email" class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ph ph-envelope text-lg" id="icon-email"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@usu.ac.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#106c38] focus:bg-white focus:ring-4 focus:ring-green-100 transition-all">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wide">Kata Sandi</label>
                            <a href="#" class="text-xs font-semibold text-[#106c38] hover:underline">Lupa Sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ph ph-lock text-lg"></i>
                            </div>
                            <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-10 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#106c38] focus:bg-white focus:ring-4 focus:ring-green-100 transition-all">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer">
                                <i class="ph ph-eye text-lg" id="icon-toggle-password"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-4.5 h-4.5 rounded border-slate-300 text-[#106c38] focus:ring-[#106c38]">
                        <label for="remember" class="ml-2 text-xs text-slate-500 font-medium select-none cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-[#106c38] to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl py-3 font-semibold text-sm transition-all shadow-md shadow-green-700/20 hover:shadow-lg hover:shadow-green-700/30 flex items-center justify-center gap-1.5 cursor-pointer mt-6 border-none">
                        Masuk Sistem <i class="ph ph-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Script for Dynamic Role Swapping -->
    <script>
        const sectionRoleSelect = document.getElementById('section-role-select');
        const sectionLoginForm = document.getElementById('section-login-form');
        const inputRole = document.getElementById('input-role');
        const formRoleBadge = document.getElementById('form-role-badge');
        const formRoleTitle = document.getElementById('form-role-title');
        const labelEmail = document.getElementById('label-email');
        const emailInput = document.getElementById('email');
        const iconEmail = document.getElementById('icon-email');

        function selectRole(role) {
            inputRole.value = role;

            if (role === 'pustakawan') {
                formRoleBadge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2 bg-green-50 text-[#106c38]";
                formRoleBadge.innerHTML = '<i class="ph ph-user-gear"></i> Pustakawan';
                formRoleTitle.textContent = "Masuk sebagai Pustakawan";
                labelEmail.textContent = "Email Resmi (Staf)";
                emailInput.placeholder = "admin@usu.ac.id";
                emailInput.type = "email";
                iconEmail.className = "ph ph-envelope text-lg";
            } else {
                formRoleBadge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2 bg-emerald-50 text-emerald-700";
                formRoleBadge.innerHTML = '<i class="ph ph-identification-card"></i> Anggota';
                formRoleTitle.textContent = "Masuk sebagai Anggota";
                labelEmail.textContent = "Email / Nomor Anggota";
                emailInput.placeholder = "anggota@usu.ac.id";
                emailInput.type = "text";
                iconEmail.className = "ph ph-identification-card text-lg";
            }

            sectionRoleSelect.classList.add('hidden');
            sectionLoginForm.classList.remove('hidden');
        }

        function backToRoleSelect() {
            sectionLoginForm.classList.add('hidden');
            sectionRoleSelect.classList.remove('hidden');
            inputRole.value = '';
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('icon-toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'ph ph-eye-slash text-lg';
            } else {
                passwordInput.type = 'password';
                icon.className = 'ph ph-eye text-lg';
            }
        }

        // Initialize if role is already selected via query parameter
        document.addEventListener('DOMContentLoaded', () => {
            const currentRole = inputRole.value;
            if (currentRole === 'pustakawan' || currentRole === 'anggota') {
                selectRole(currentRole);
            }
        });
    </script>
</body>
</html>
