<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Ganti Password - Portal Admin OPAC USU</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .bg-usu-green  { background-color: #106c38; }
        .text-usu-green { color: #106c38; }
        .input-field {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #106c38;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(16, 108, 56, 0.15);
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50 flex flex-col">

    @include('partials.admin_sidebar')

    <div class="w-full flex-grow flex flex-col min-w-0">
        <main class="flex-grow p-3 sm:p-6 lg:p-8 pb-10 sm:pb-14 flex flex-col gap-4 sm:gap-6 max-w-3xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-white border border-slate-100 p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm">
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                        <i class="ph ph-key text-usu-green text-2xl sm:text-3xl"></i>
                        <span>Ganti Password Akun</span>
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Perbarui kata sandi Anda untuk menjaga keamanan akses portal.</p>
                </div>
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-3 py-2 flex items-center gap-2 text-emerald-700 text-xs font-semibold flex-shrink-0">
                    <i class="ph ph-user-circle text-base"></i>
                    <span>{{ Auth::check() ? (Auth::user()->username) : 'Pustakawan' }}</span>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#106c38',
                    });
                });
            </script>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium">
                <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                <div>
                    <p class="font-bold">Gagal memperbarui password:</p>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6 lg:p-8">
                <form action="{{ route('admin.ganti-password.update') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Password Saat Ini --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="current_password">
                            Password Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                placeholder="Masukkan password lama Anda"
                                class="input-field {{ $errors->has('current_password') ? 'border-rose-400 bg-rose-50' : '' }}"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" onclick="togglePasswordVisibility('current_password', 'eye_current')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer">
                                <i class="ph ph-eye text-lg" id="eye_current"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 my-2"></div>

                    {{-- Password Baru --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="password">
                            Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 6 karakter"
                                class="input-field {{ $errors->has('password') ? 'border-rose-400 bg-rose-50' : '' }}"
                                required
                                autocomplete="new-password"
                            >
                            <button type="button" onclick="togglePasswordVisibility('password', 'eye_new')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer">
                                <i class="ph ph-eye text-lg" id="eye_new"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-slate-400 text-[10px] mt-1">Gunakan kombinasi huruf dan angka agar password lebih aman.</p>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="password_confirmation">
                            Konfirmasi Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password baru Anda"
                                class="input-field"
                                required
                                autocomplete="new-password"
                            >
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye_confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 bg-transparent border-none cursor-pointer">
                                <i class="ph ph-eye text-lg" id="eye_confirm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3 text-sm">
                        <i class="ph ph-shield-check text-blue-500 text-xl flex-shrink-0 mt-0.5"></i>
                        <div class="text-blue-700 text-xs font-medium leading-relaxed">
                            <p class="font-bold mb-1">Sinkronisasi Sistem</p>
                            <p>Password yang Anda ubah di sini akan langsung disinkronkan sehingga dapat digunakan untuk login ke <strong>Portal Web OPAC</strong> maupun sistem desktop <strong>LIBAS Delphi</strong>.</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button
                            type="submit"
                            class="flex-1 bg-[#106c38] hover:bg-[#0b4d27] text-white font-bold text-sm px-6 py-3.5 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer border-none shadow-sm active:scale-95"
                        >
                            <i class="ph ph-check-circle text-lg"></i>
                            <span>Simpan Password Baru</span>
                        </button>
                        <a
                            href="{{ route('admin.index') }}"
                            class="flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm px-6 py-3.5 rounded-xl transition flex items-center justify-center gap-2"
                        >
                            <i class="ph ph-arrow-left text-lg"></i>
                            <span>Batal</span>
                        </a>
                    </div>
                </form>
            </div>

        </main>

        @include('partials.admin_footer')
    </div>

    <script>
        function togglePasswordVisibility(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            if (!input || !eye) return;

            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.remove('ph-eye');
                eye.classList.add('ph-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.remove('ph-eye-slash');
                eye.classList.add('ph-eye');
            }
        }
    </script>
</body>
</html>

