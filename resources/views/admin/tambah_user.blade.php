<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Tambah User - Portal Admin OPAC USU</title>

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
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #106c38;
            box-shadow: 0 0 0 3px rgba(16, 108, 56, 0.15);
        }
        .input-field::placeholder { font-weight: 400; color: #94a3b8; }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50 flex flex-col">

    @include('partials.admin_sidebar')

    <div class="w-full flex-grow flex flex-col min-w-0">
        <main class="flex-grow p-3 sm:p-6 lg:p-8 pb-10 sm:pb-14 flex flex-col gap-4 sm:gap-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 sm:gap-4 bg-white border border-slate-100 p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm">
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                        <i class="ph ph-user-plus text-usu-green text-2xl sm:text-3xl"></i>
                        <span>Tambah User Baru</span>
                    </h1>
                    <p class="text-slate-500 text-[10px] sm:text-sm mt-1">Tambahkan akun pustakawan baru ke sistem. Hanya dapat diakses oleh <strong>Pengolahan / IT Admin</strong>.</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 flex items-center gap-2 text-amber-700 text-xs font-semibold flex-shrink-0">
                    <i class="ph ph-shield-check text-base"></i>
                    <span>Akses Terbatas: idgroup 3</span>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        html: `{!! addslashes(session('success')) !!}`,
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#106c38',
                    });
                });
            </script>
            @endif

            {{-- Form Card --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                        <i class="ph ph-identification-card"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Form Data User</h2>
                        <p class="text-xs text-slate-500">Password default akan dibuat otomatis: <code class="bg-slate-100 px-1 rounded">username + 123</code></p>
                    </div>
                </div>

                {{-- Validation Errors --}}
                @if($errors->any())
                <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium">
                    <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                    <div>
                        <p class="font-bold">Terjadi Kesalahan:</p>
                        <ul class="list-disc pl-5 mt-1 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form action="{{ route('admin.tambah-user.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="username">
                            Username <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Contoh: budi.santoso"
                            class="input-field {{ $errors->has('username') ? 'border-rose-400 bg-rose-50' : '' }}"
                            required
                            autocomplete="off"
                        >
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-slate-400 text-[10px] mt-1">Gunakan huruf kecil, angka, titik, atau underscore. Tidak boleh ada spasi.</p>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="nama_lengkap">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Contoh: Budi Santoso, S.Sos."
                            class="input-field {{ $errors->has('nama_lengkap') ? 'border-rose-400 bg-rose-50' : '' }}"
                            required
                        >
                        @error('nama_lengkap')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan / Jabatan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="keterangan">
                            Keterangan / Jabatan
                        </label>
                        <input
                            type="text"
                            id="keterangan"
                            name="keterangan"
                            value="{{ old('keterangan') }}"
                            placeholder="Contoh: Pustakawan, Kepala Bagian Pengolahan"
                            class="input-field {{ $errors->has('keterangan') ? 'border-rose-400 bg-rose-50' : '' }}"
                        >
                        @error('keterangan')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-slate-400 text-[10px] mt-1">Opsional. Isi jabatan atau keterangan akun ini.</p>
                    </div>

                    {{-- Divisi / idgroup --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5" for="idgroup">
                            Divisi / Kelompok Akses <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="idgroup"
                            name="idgroup"
                            class="input-field {{ $errors->has('idgroup') ? 'border-rose-400 bg-rose-50' : '' }}"
                            required
                        >
                            <option value="">— Pilih Divisi —</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->idgroup_user }}" {{ old('idgroup') == $group->idgroup_user ? 'selected' : '' }}>
                                    [{{ $group->idgroup_user }}] {{ $group->nama_group }}
                                </option>
                            @endforeach
                        </select>
                        @error('idgroup')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Info Password --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3 text-sm">
                        <i class="ph ph-info text-blue-500 text-xl flex-shrink-0 mt-0.5"></i>
                        <div class="text-blue-700 text-xs font-medium leading-relaxed">
                            <p class="font-bold mb-1">Informasi Password</p>
                            <p>Password default akan diset secara otomatis menjadi: <strong>[username]123</strong></p>
                            <p class="mt-1">Contoh: jika username = <code class="bg-blue-100 px-1 rounded">budi.santoso</code>, maka password default = <code class="bg-blue-100 px-1 rounded">budi.santoso123</code></p>
                            <p class="mt-1 text-blue-600">⚠️ Minta user untuk segera mengganti password setelah login pertama kali.</p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button
                            type="submit"
                            class="flex-1 bg-[#106c38] hover:bg-[#0b4d27] text-white font-bold text-sm px-6 py-3.5 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer border-none shadow-sm"
                        >
                            <i class="ph ph-user-plus text-lg"></i>
                            <span>Simpan User Baru</span>
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

            {{-- Daftar User Aktif (preview) --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                        <i class="ph ph-users-three"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">User Pustakawan Aktif</h2>
                        <p class="text-xs text-slate-500">Daftar akun yang sudah terdaftar sebagai pustakawan di sistem.</p>
                    </div>
                </div>

                @php
                    $existingUsers = \Illuminate\Support\Facades\DB::table('tbluser')
                        ->leftJoin('tblgroup_user', 'tbluser.idgroup', '=', 'tblgroup_user.idgroup_user')
                        ->where('tbluser.status_administrator', 1)
                        ->select('tbluser.iduser', 'tbluser.username', 'tbluser.nama_lengkap', 'tbluser.keterangan', 'tbluser.idgroup', 'tblgroup_user.nama_group', 'tbluser.status')
                        ->orderBy('tbluser.idgroup')
                        ->orderBy('tbluser.nama_lengkap')
                        ->get();
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-2 pr-4">Username</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-2 pr-4">Nama Lengkap</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-2 pr-4 hidden sm:table-cell">Jabatan</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-2 pr-4 hidden md:table-cell">Divisi</th>
                                <th class="text-center text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($existingUsers as $u)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 pr-4">
                                    <span class="font-bold text-slate-800 text-xs">{{ $u->username }}</span>
                                </td>
                                <td class="py-2.5 pr-4">
                                    <span class="text-xs text-slate-700">{{ $u->nama_lengkap ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 pr-4 hidden sm:table-cell">
                                    <span class="text-xs text-slate-500">{{ $u->keterangan ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 pr-4 hidden md:table-cell">
                                    <span class="inline-flex items-center gap-1 bg-[#106c38]/10 text-[#106c38] text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ $u->nama_group ?? 'Group ' . $u->idgroup }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-center">
                                    @if(Auth::check() && Auth::user()->iduser == $u->iduser)
                                        <span class="inline-flex items-center gap-1 text-[10px] bg-slate-100 text-slate-500 font-semibold px-2.5 py-1 rounded-lg">
                                            <i class="ph ph-user"></i> Akun Anda
                                        </span>
                                    @else
                                        <form id="form-delete-{{ $u->iduser }}" action="{{ route('admin.tambah-user.destroy', $u->iduser) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                onclick="confirmDeleteUser({{ $u->iduser }}, '{{ addslashes($u->username) }}')"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2.5 py-1 rounded-lg transition border-none cursor-pointer"
                                                title="Hapus user ini"
                                            >
                                                <i class="ph ph-trash text-sm"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        @include('partials.admin_footer')
    </div>

    <script>
        function confirmDeleteUser(userId, username) {
            Swal.fire({
                title: 'Hapus User?',
                html: `Apakah Anda yakin ingin menghapus user <strong>"${username}"</strong>?<br><span class="text-xs text-rose-500">Akun akan dihapus dari sistem dan tidak bisa digunakan untuk login lagi.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + userId).submit();
                }
            });
        }
    </script>

</body>
</html>

