<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Daftar Lokasi - Portal Admin OPAC USU</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .admin-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-8">

                <!-- Page Header -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                            <i class="ph ph-map-pin text-usu-green text-3xl"></i>
                            <span>Daftar Lokasi</span>
                        </h1>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">Kelola daftar lokasi penyimpanan buku fisik atau unit fakultas perpustakaan.</p>
                    </div>
                </div>

                <!-- Success & Error Alerts -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm animate-pulse">
                        <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                        <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">
                            <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                            <ul class="list-disc pl-5 mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Content Area -->
                <div class="flex flex-col gap-8 items-start w-full">

                    <!-- Lokasi List Panel -->
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6 w-full">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="ph ph-database text-usu-green"></i>
                                    <span>Daftar Lokasi Buku</span>
                                </h2>
                                <p class="text-slate-500 text-xs mt-0.5">Menampilkan seluruh lokasi penyimpanan buku beserta jumlah eksemplar fisiknya.</p>
                            </div>

                            <!-- Search Box & Button -->
                            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                                <form id="lokasi-search-form" action="{{ route('admin.lokasi.index') }}" method="GET" class="w-full sm:w-64 relative flex items-center">
                                    <input type="hidden" name="limit" id="lokasi-limit-value" value="{{ request('limit', 10) }}">
                                    <div class="absolute left-3.5 text-slate-400">
                                        <i class="ph ph-magnifying-glass text-lg"></i>
                                    </div>
                                    <input type="text" name="search" id="lokasi-search-input" value="{{ request('search') }}" placeholder="Cari nama atau kode lokasi..." class="w-full pl-10 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-xs outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                                    <button type="button" id="lokasi-clear-btn" class="absolute right-3.5 text-slate-400 hover:text-slate-600 {{ request('search') ? '' : 'hidden' }} bg-transparent border-none cursor-pointer p-0 flex items-center">
                                        <i class="ph ph-x-circle text-base"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="openAddModal()" class="w-full sm:w-auto bg-[#106c38] hover:bg-green-800 text-white font-bold py-2 px-4 rounded-xl transition flex items-center justify-center gap-2 text-xs shadow-sm border-none cursor-pointer whitespace-nowrap">
                                    <i class="ph ph-plus-circle text-base"></i> Tambah Lokasi Baru
                                </button>
                            </div>
                        </div>

                        <!-- Limit + Table -->
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <p class="text-xs text-slate-400 font-medium">
                                Menampilkan <span class="font-bold text-slate-600">{{ $locations->firstItem() ?? 0 }}–{{ $locations->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-600">{{ $locations->total() }}</span> lokasi
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-400 font-semibold">Tampilkan:</span>
                                <!-- Custom Select untuk limit -->
                                <div class="relative custom-select-container">
                                    <button type="button" class="w-auto min-w-[90px] px-3 py-1.5 text-left bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs flex items-center justify-between gap-2 cursor-pointer custom-select-trigger font-semibold text-slate-600">
                                        <span class="custom-select-label">{{ request('limit', 10) == 'all' ? 'Semua' : request('limit', 10).' baris' }}</span>
                                        <i class="ph ph-caret-down text-slate-400 text-[10px] transition-transform duration-200"></i>
                                    </button>
                                    <input type="hidden" id="lokasi-limit-hidden" value="{{ request('limit', 10) }}">
                                    <div class="custom-select-menu hidden absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-[1000]">
                                        @foreach([10 => '10 baris', 25 => '25 baris', 50 => '50 baris', 'all' => 'Semua'] as $val => $label)
                                            @php $isActive = (string)request('limit', 10) === (string)$val; @endphp
                                            <button type="button" data-value="{{ $val }}" class="custom-select-option w-full text-left px-3 py-2 text-[11px] transition flex items-center justify-between {{ $isActive ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                <span>{{ $label }}</span>
                                                <i class="ph ph-check text-[10px] select-active-check {{ $isActive ? '' : 'hidden' }}"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Locations Table -->
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                        <th class="px-5 py-4 text-center w-12">No.</th>
                                        <th class="px-5 py-4">Nama Lokasi</th>
                                        <th class="px-5 py-4">Kode</th>
                                        <th class="px-5 py-4 text-center">Ikon</th>
                                        <th class="px-5 py-4 text-center">Jumlah Eksemplar</th>
                                        <th class="px-5 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
                                    @forelse($locations as $loc)
                                        <tr class="hover:bg-slate-50/30 transition">
                                            <!-- Number -->
                                            <td class="px-5 py-4 text-center text-xs font-semibold text-slate-400 w-12">
                                                {{ $loop->iteration + ($locations->firstItem() - 1) }}
                                            </td>
                                            <!-- Name -->
                                            <td class="px-5 py-4">
                                                <div class="font-bold text-slate-800">{{ $loc->name }}</div>
                                            </td>
                                            <!-- Code -->
                                            <td class="px-5 py-4">
                                                <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $loc->code }}</span>
                                            </td>
                                            <!-- Icon -->
                                            <td class="px-5 py-4 text-center">
                                                <div class="inline-flex w-9 h-9 items-center justify-center rounded-xl bg-[#106c38]/5 text-usu-green">
                                                    <i class="ph {{ $loc->icon }} text-lg"></i>
                                                </div>
                                            </td>
                                            <!-- Items Count -->
                                            <td class="px-5 py-4 text-center">
                                                <span class="inline-flex items-center gap-1 bg-[#106c38]/5 text-usu-green font-bold px-2.5 py-0.5 rounded-full text-xs">
                                                    {{ number_format($loc->items_count) }} eksemplar
                                                </span>
                                            </td>
                                            <!-- Actions -->
                                            <td class="px-5 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    @if($loc->items_count > 0)
                                                        <button type="button" disabled title="Tidak bisa dihapus: digunakan oleh {{ $loc->items_count }} eksemplar" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-300 flex items-center justify-center border border-slate-200/60 cursor-not-allowed">
                                                            <i class="ph ph-trash text-base"></i>
                                                        </button>
                                                    @else
                                                        <form action="{{ route('admin.lokasi.destroy', $loc->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" onclick="confirmDeleteLokasi(this)" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-600 flex items-center justify-center border border-slate-200/60 transition cursor-pointer" title="Hapus Lokasi">
                                                                <i class="ph ph-trash text-base"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                                <i class="ph ph-warning-circle text-4xl mb-2 text-slate-300"></i>
                                                <p class="text-sm font-semibold">Tidak ada lokasi yang ditemukan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $locations->links('admin.partials.pagination') }}
                        </div>
                    </div>
                </div>

            </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal: Tambah Lokasi Baru -->
    <div id="addModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="bg-white rounded-3xl w-full max-w-md mx-4 shadow-2xl relative z-10 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="addModalContent">
            <!-- Modal Header -->
            <div class="p-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between rounded-t-3xl">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Tambah Lokasi Baru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Tambahkan fakultas atau ruang koleksi buku baru.</p>
                </div>
                <button type="button" onclick="closeAddModal()" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 transition cursor-pointer border-none">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
            <!-- Modal Body (scrollable) -->
            <form action="{{ route('admin.lokasi.store') }}" method="POST" class="overflow-y-auto flex-1 p-6 flex flex-col gap-4 rounded-b-3xl">
                @csrf
                <!-- Location Name -->
                <div class="flex flex-col gap-1.5">
                    <label for="modal-name" class="text-xs font-bold text-slate-500 uppercase">Nama Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="modal-name" required placeholder="Contoh: Fakultas Ilkom-TI" oninput="autoGenerateCode(this.value)" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] transition-all">
                </div>
                <!-- Location Code -->
                <div class="flex flex-col gap-1.5">
                    <label for="modal-code" class="text-xs font-bold text-slate-500 uppercase">Kode Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="modal-code" required placeholder="Contoh: ilkom_ti" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#106c38]/20 focus:border-[#106c38] transition-all">
                    <p class="text-[10px] text-slate-400">Kode unik database (hanya huruf kecil, angka, dan garis bawah/tanda hubung).</p>
                </div>
                <!-- Icon Selection — icon-only grid -->
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase">Pilih Ikon Lokasi <span class="text-red-500">*</span></label>
                    <input type="hidden" name="icon" id="modal-icon" value="ph-books">
                    @php
                        $iconOptions = [
                            'ph-books'           => 'Perpustakaan',
                            'ph-book-open'       => 'Buku Terbuka',
                            'ph-book-bookmark'   => 'Referensi',
                            'ph-newspaper'       => 'Jurnal',
                            'ph-buildings'       => 'Gedung Besar',
                            'ph-house'           => 'Gedung Kecil',
                            'ph-graduation-cap'  => 'Akademik',
                            'ph-users-three'     => 'Sosial / ISIP',
                            'ph-scales'          => 'Hukum',
                            'ph-briefcase'       => 'Bisnis',
                            'ph-globe'           => 'HI / Global',
                            'ph-map-pin'         => 'Lokasi',
                            'ph-stethoscope'     => 'Kedokteran',
                            'ph-heartbeat'       => 'Kesehatan',
                            'ph-first-aid'       => 'Keperawatan',
                            'ph-pill'            => 'Farmasi',
                            'ph-tooth'           => 'Kedokteran Gigi',
                            'ph-brain'           => 'Psikologi',
                            'ph-eye'             => 'Optometri',
                            'ph-heart'           => 'Kardiologi',
                            'ph-test-tube'       => 'Lab / MIPA',
                            'ph-flask'           => 'Kimia',
                            'ph-atom'            => 'Fisika',
                            'ph-leaf'            => 'Biologi',
                            'ph-plant'           => 'Pertanian',
                            'ph-tree'            => 'Kehutanan',
                            'ph-sun'             => 'Lingkungan',
                            'ph-drop'            => 'Kelautan',
                            'ph-desktop'         => 'Ilmu Komputer',
                            'ph-cpu'             => 'Teknik Elektro',
                            'ph-wrench'          => 'Teknik Mesin',
                            'ph-hammer'          => 'Teknik Sipil',
                            'ph-paint-brush'     => 'Seni / Desain',
                            'ph-music-notes'     => 'Musik',
                            'ph-film-strip'      => 'Film',
                            'ph-megaphone'       => 'Komunikasi',
                            'ph-archive-tray'    => 'Arsip',
                            'ph-folder-open'     => 'Koleksi',
                            'ph-database'        => 'Digital',
                            'ph-hard-drives'     => 'Server',
                        ];
                    @endphp
                    <div class="border border-slate-200 rounded-xl p-3">
                        <div style="display:grid; grid-template-columns:repeat(8,36px); gap:6px;">
                            @foreach($iconOptions as $iconVal => $iconLabel)
                                <button type="button"
                                    onclick="selectIcon('{{ $iconVal }}', '{{ $iconLabel }}')"
                                    data-icon="{{ $iconVal }}"
                                    title="{{ $iconLabel }}"
                                    class="icon-option flex items-center justify-center rounded-lg transition-all text-xl {{ $iconVal === 'ph-books' ? 'bg-[#106c38] text-white' : 'text-slate-400 hover:bg-green-50 hover:text-[#106c38]' }}"
                                    style="width:36px;height:36px;flex-shrink:0;">
                                    <i class="ph {{ $iconVal }}"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <!-- Preview selected -->
                    <div class="flex items-center gap-2 mt-0.5">
                        <div class="w-7 h-7 rounded-lg bg-green-50 text-usu-green flex items-center justify-center text-base flex-shrink-0">
                            <i class="ph ph-books" id="icon-preview"></i>
                        </div>
                        <span id="icon-preview-label" class="text-xs font-semibold text-slate-600">Perpustakaan / Buku</span>
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex gap-3 mt-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeAddModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl transition text-xs border-none cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-[#106c38] hover:bg-green-800 text-white font-bold py-2.5 rounded-xl transition text-xs border-none cursor-pointer shadow-md shadow-green-100">
                        Simpan Lokasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Confirm Modal (sama persis dengan koleksi buku) -->
    <div id="confirm-modal" class="fixed inset-0 z-[10000] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="hideCustomConfirm()"></div>
        <div class="relative bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 transform transition-all scale-95 opacity-0 duration-200" id="confirm-modal-card">
            <div class="flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mb-4">
                    <i class="ph ph-warning-circle text-3xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
                <p id="confirm-modal-message" class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                <div class="flex items-center gap-3 w-full">
                    <button type="button" id="confirm-modal-cancel" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition text-xs border-none cursor-pointer">Batal</button>
                    <button type="button" id="confirm-modal-confirm" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-xl transition text-xs border-none cursor-pointer shadow-md shadow-red-200">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ─── Modal Tambah Lokasi ───────────────────────────────────────────────
        const addModal = document.getElementById('addModal');
        const addModalContent = document.getElementById('addModalContent');

        function openAddModal() {
            addModal.classList.remove('hidden');
            setTimeout(() => {
                addModal.classList.remove('opacity-0');
                addModalContent.classList.remove('scale-95');
                addModalContent.classList.add('scale-100');
            }, 10);
        }

        function closeAddModal() {
            addModal.classList.add('opacity-0');
            addModalContent.classList.remove('scale-100');
            addModalContent.classList.add('scale-95');
            setTimeout(() => { addModal.classList.add('hidden'); }, 300);
        }

        function autoGenerateCode(nameVal) {
            document.getElementById('modal-code').value = nameVal.trim().toLowerCase()
                .replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
        }

        function selectIcon(iconVal, iconLabel) {
            // Update hidden input
            document.getElementById('modal-icon').value = iconVal;
            // Update preview
            document.getElementById('icon-preview').className = 'ph ' + iconVal;
            const previewLabel = document.getElementById('icon-preview-label');
            if (previewLabel) previewLabel.textContent = iconLabel;
            // Update active state on all icon-option buttons
            document.querySelectorAll('.icon-option').forEach(btn => {
                const isActive = btn.getAttribute('data-icon') === iconVal;
                if (isActive) {
                    btn.className = btn.className
                        .replace(/text-slate-400|hover:bg-green-50|hover:text-\[#106c38\]/g, '')
                        .replace('icon-option', 'icon-option');
                    btn.classList.remove('text-slate-400', 'hover:bg-green-50');
                    btn.classList.add('bg-[#106c38]', 'text-white', 'ring-2', 'ring-[#106c38]', 'ring-offset-1');
                } else {
                    btn.classList.remove('bg-[#106c38]', 'text-white', 'ring-2', 'ring-[#106c38]', 'ring-offset-1');
                    btn.classList.add('text-slate-400', 'hover:bg-green-50', 'hover:text-[#106c38]');
                }
            });
        }

        // ─── Confirm Modal ─────────────────────────────────────────────────────
        let confirmCallback = null;

        window.showCustomConfirm = function(message, callback) {
            const modal = document.getElementById('confirm-modal');
            const card  = document.getElementById('confirm-modal-card');
            const msgEl = document.getElementById('confirm-modal-message');
            if (!modal || !card || !msgEl) return;
            msgEl.innerText = message;
            confirmCallback = callback;
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        window.hideCustomConfirm = function() {
            const modal = document.getElementById('confirm-modal');
            const card  = document.getElementById('confirm-modal-card');
            if (!modal || !card) return;
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); confirmCallback = null; }, 200);
        }

        window.confirmDeleteLokasi = function(button) {
            const form = button.closest('form');
            if (form) {
                showCustomConfirm('Apakah Anda yakin ingin menghapus lokasi ini dari database?', () => { form.submit(); });
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            // ─── Confirm Modal Buttons ─────────────────────────────────────────
            const cancelBtn  = document.getElementById('confirm-modal-cancel');
            const confirmBtn = document.getElementById('confirm-modal-confirm');
            if (cancelBtn)  cancelBtn.addEventListener('click', hideCustomConfirm);
            if (confirmBtn) confirmBtn.addEventListener('click', () => { if (confirmCallback) confirmCallback(); hideCustomConfirm(); });

            // ─── Custom Select (sama persis dengan koleksi buku) ───────────────
            window.initCustomSelects = function(parent) {
                const selectContainers = parent.querySelectorAll('.custom-select-container');
                selectContainers.forEach(container => {
                    if (container.dataset.initialized === 'true') return;
                    container.dataset.initialized = 'true';

                    const trigger     = container.querySelector('.custom-select-trigger');
                    const menu        = container.querySelector('.custom-select-menu');
                    const options     = container.querySelectorAll('.custom-select-option');
                    const hiddenInput = container.querySelector('input[type="hidden"]');
                    const label       = container.querySelector('.custom-select-label');
                    const caret       = container.querySelector('.ph-caret-down');

                    if (!trigger || !menu) return;

                    trigger.addEventListener('click', (e) => {
                        e.stopPropagation();
                        document.querySelectorAll('.custom-select-menu').forEach(m => {
                            if (m !== menu) {
                                m.classList.add('hidden');
                                const c = m.parentElement.querySelector('.ph-caret-down');
                                if (c) c.classList.remove('rotate-180');
                            }
                        });
                        menu.classList.toggle('hidden');
                        if (caret) caret.classList.toggle('rotate-180');
                    });

                    options.forEach(opt => {
                        opt.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const val  = opt.getAttribute('data-value');
                            const text = opt.querySelector('span').textContent.trim();

                            if (label) label.textContent = text;
                            if (hiddenInput) {
                                hiddenInput.value = val;
                                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                            }

                            options.forEach(o => {
                                const check = o.querySelector('.select-active-check');
                                if (o === opt) {
                                    o.classList.remove('text-slate-600', 'font-semibold');
                                    o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                    if (check) check.classList.remove('hidden');
                                } else {
                                    o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                    o.classList.add('text-slate-600', 'font-semibold');
                                    if (check) check.classList.add('hidden');
                                }
                            });

                            menu.classList.add('hidden');
                            if (caret) caret.classList.remove('rotate-180');
                        });
                    });
                });
            }
            window.initCustomSelects(document);

            document.addEventListener('click', () => {
                document.querySelectorAll('.custom-select-menu').forEach(m => {
                    m.classList.add('hidden');
                    const c = m.parentElement.querySelector('.ph-caret-down');
                    if (c) c.classList.remove('rotate-180');
                });
            });

            // ─── Limit select: redirect on change ──────────────────────────────
            const limitHidden = document.getElementById('lokasi-limit-hidden');
            if (limitHidden) {
                limitHidden.addEventListener('change', () => {
                    const search = document.getElementById('lokasi-search-input')?.value || '';
                    const limit  = limitHidden.value;
                    const base   = '{{ route('admin.lokasi.index') }}';
                    window.location.href = `${base}?search=${encodeURIComponent(search)}&limit=${limit}`;
                });
            }

            // ─── Icon preview on modal select change ───────────────────────────
            const modalIcon = document.getElementById('modal-icon');
            if (modalIcon) {
                modalIcon.addEventListener('change', () => {
                    document.getElementById('icon-preview').className = 'ph ' + modalIcon.value;
                });
            }

            // ─── Search ────────────────────────────────────────────────────────
            const searchInput = document.getElementById('lokasi-search-input');
            const clearBtn    = document.getElementById('lokasi-clear-btn');
            const searchForm  = document.getElementById('lokasi-search-form');

            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    if (searchInput) searchInput.value = '';
                    clearBtn.classList.add('hidden');
                    if (searchForm) searchForm.submit();
                });
            }
        });
    </script>
</body>
</html>
