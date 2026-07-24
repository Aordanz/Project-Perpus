@extends('admin.information_center.layout')

@section('title', 'Tong Sampah - Information Center')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
            <i class="ph ph-trash-simple text-rose-600 text-3xl"></i>
            <span>Tong Sampah (Dihapus)</span>
        </h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Daftar informasi yang telah dihapus sementara. Anda dapat memulihkan atau menghapus secara permanen.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.information-center.index') }}" class="px-5 py-2.5 bg-white text-slate-600 font-semibold border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
            <i class="ph ph-arrow-left font-bold"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
    <!-- Tabs Header Navigation -->
    <div class="border-b border-slate-100 bg-slate-50/80 px-6 pt-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.information-center.index', ['tab' => 'active']) }}" 
           class="px-4 py-2.5 rounded-t-2xl text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-all">
            <i class="ph ph-check-circle text-base"></i>
            <span>Informasi Aktif & Draf</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-slate-200 text-slate-600">
                {{ $countActive }}
            </span>
        </a>
        <a href="{{ route('admin.information-center.index', ['tab' => 'history']) }}" 
           class="px-4 py-2.5 rounded-t-2xl text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-all">
            <i class="ph ph-clock-counter-clockwise text-base"></i>
            <span>History & Arsip Kadaluwarsa</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-slate-200 text-slate-600">
                {{ $countHistory }}
            </span>
        </a>
        <a href="{{ route('admin.information-center.trash') }}" 
           class="px-4 py-2.5 rounded-t-2xl text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 bg-white text-rose-600 border-rose-600 shadow-sm transition-all">
            <i class="ph ph-trash text-base"></i>
            <span>Tong Sampah</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700">
                {{ $countTrash }}
            </span>
        </a>
    </div>

    <!-- Filters -->
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <form action="{{ route('admin.information-center.trash') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-grow min-w-[200px]">
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Cari Judul</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-slate-400 text-lg"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all" placeholder="Ketik judul...">
                </div>
            </div>
            
            <div class="w-full sm:w-48">
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Kategori</label>
                <select name="category" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="event" {{ request('category') == 'event' ? 'selected' : '' }}>Event / Kegiatan</option>
                    <option value="announcement" {{ request('category') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan (Maintenance)</option>
                    <option value="new_collection" {{ request('category') == 'new_collection' ? 'selected' : '' }}>Buku / Koleksi Baru</option>
                    <option value="tips" {{ request('category') == 'tips' ? 'selected' : '' }}>Tips & Trik</option>
                    <option value="promotion" {{ request('category') == 'promotion' ? 'selected' : '' }}>Promo / Penawaran</option>
                    <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>Informasi Umum</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center gap-2 cursor-pointer border-none">
                    <i class="ph ph-funnel text-base"></i> Filter
                </button>
                <a href="{{ route('admin.information-center.trash') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-600 font-bold rounded-xl text-sm transition-all border border-slate-200 flex items-center gap-1.5">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                    <th class="py-3.5 px-4 w-10 text-center">
                        <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500 cursor-pointer">
                    </th>
                    <th class="py-3.5 px-4">Gambar</th>
                    <th class="py-3.5 px-4">Judul & Kategori</th>
                    <th class="py-3.5 px-4">Waktu Dihapus</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                @forelse($trashItems as $info)
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" name="ids[]" value="{{ $info->id }}" class="item-checkbox w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500 cursor-pointer">
                        </td>
                        <td class="py-4 px-4 w-20">
                            @php
                                $imgSrc = asset('perpustakaan_depan.webp');
                                if ($info->images && count($info->images) > 0) {
                                    $imgSrc = str_starts_with($info->images[0], '/') ? $info->images[0] : asset($info->images[0]);
                                } elseif ($info->image_path) {
                                    $imgSrc = str_starts_with($info->image_path, '/') ? $info->image_path : asset($info->image_path);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $info->title }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200 shadow-xs">
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800 line-clamp-1 group-hover:text-rose-600 transition-colors">{{ $info->title }}</div>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-600">
                                    {{ str_replace('_', ' ', $info->category) }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500 text-xs">
                            {{ $info->deleted_at ? $info->deleted_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Restore Button -->
                                <form action="{{ route('admin.information-center.restore', $info->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm cursor-pointer border-none">
                                        <i class="ph ph-arrow-counter-clockwise text-sm"></i>
                                        <span>Pulihkan</span>
                                    </button>
                                </form>

                                <!-- Force Delete Button -->
                                <form action="{{ route('admin.information-center.force-delete', $info->id) }}" method="POST" class="inline force-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition-colors btn-force-delete" data-tooltip="Hapus Permanen">
                                        <i class="ph ph-x-circle text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="ph ph-trash text-5xl text-slate-300"></i>
                                <p class="text-sm font-medium text-slate-500">Tong sampah kosong. Tidak ada data informasi yang dihapus.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($trashItems->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $trashItems->links() }}
        </div>
    @endif
</div>

<!-- FLOATING BULK ACTIONS BAR -->
<div id="bulk-action-bar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/95 text-white px-6 py-3.5 rounded-2xl shadow-2xl z-50 flex items-center gap-5 border border-slate-700/80 backdrop-blur-md transition-all duration-300">
    <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-rose-400 animate-pulse"></span>
        <span id="bulk-selected-count" class="text-xs font-bold text-slate-200">0 item terpilih</span>
    </div>

    <div class="h-4 w-px bg-slate-700"></div>

    <div class="flex items-center gap-3">
        <!-- Form Bulk Restore -->
        <form id="form-bulk-restore" action="{{ route('admin.information-center.bulk-restore') }}" method="POST" class="inline">
            @csrf
            <div id="bulk-restore-inputs"></div>
            <button type="button" id="btn-bulk-restore" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-md transition-all cursor-pointer border-none">
                <i class="ph ph-arrow-counter-clockwise text-sm"></i>
                Pulihkan Sekaligus
            </button>
        </form>

        <!-- Form Bulk Force Delete -->
        <form id="form-bulk-force-delete" action="{{ route('admin.information-center.bulk-force-delete') }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <div id="bulk-force-delete-inputs"></div>
            <button type="button" id="btn-bulk-force-delete" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-md transition-all cursor-pointer border-none">
                <i class="ph ph-x-circle text-sm"></i>
                Hapus Permanen Sekaligus
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const bulkBar = document.getElementById('bulk-action-bar');
        const countText = document.getElementById('bulk-selected-count');

        function updateBulkBar() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            if (checked.length > 0) {
                bulkBar.classList.remove('hidden');
                countText.textContent = `${checked.length} item terpilih`;
            } else {
                bulkBar.classList.add('hidden');
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateBulkBar();
            });
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

        // Bulk Restore
        const btnBulkRestore = document.getElementById('btn-bulk-restore');
        if (btnBulkRestore) {
            btnBulkRestore.addEventListener('click', function () {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                if (checked.length === 0) return;
                
                const container = document.getElementById('bulk-restore-inputs');
                container.innerHTML = '';
                checked.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    container.appendChild(input);
                });
                document.getElementById('form-bulk-restore').submit();
            });
        }

        // Bulk Force Delete
        const btnBulkForceDelete = document.getElementById('btn-bulk-force-delete');
        if (btnBulkForceDelete) {
            btnBulkForceDelete.addEventListener('click', function () {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                if (checked.length === 0) return;

                Swal.fire({
                    title: 'Hapus Permanen?',
                    text: `Apakah Anda yakin ingin menghapus permanen ${checked.length} data informasi terpilih? Data tidak dapat dipulihkan lagi!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus Permanen',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const container = document.getElementById('bulk-force-delete-inputs');
                        container.innerHTML = '';
                        checked.forEach(cb => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = cb.value;
                            container.appendChild(input);
                        });
                        document.getElementById('form-bulk-force-delete').submit();
                    }
                });
            });
        }

        // Single Force Delete confirmation
        document.querySelectorAll('.btn-force-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('.force-delete-form');
                Swal.fire({
                    title: 'Hapus Permanen?',
                    text: 'Data informasi ini akan dihapus permanen dari database dan tidak dapat dipulihkan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus Permanen',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
