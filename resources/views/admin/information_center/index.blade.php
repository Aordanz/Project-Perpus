@extends('admin.information_center.layout')

@section('title', 'Information Center')

@push('styles')
<style>
    .action-tooltip {
        position: relative;
    }
    .action-tooltip::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-6px);
        padding: 5px 10px;
        background: #0f172a;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
        border-radius: 8px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
        z-index: 50;
    }
    .action-tooltip::after {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(2px);
        border-width: 5px;
        border-style: solid;
        border-color: #0f172a transparent transparent transparent;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 50;
    }
    .action-tooltip:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-8px);
    }
    .action-tooltip:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-3px);
    }
</style>
@endpush

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
            <i class="ph ph-megaphone text-usu-green text-3xl"></i>
            <span>Information Center</span>
        </h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Kelola seluruh informasi perpustakaan yang akan ditampilkan kepada pengguna.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.information-center.create') }}" class="btn-gold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center gap-2">
            <i class="ph ph-plus font-bold"></i> Tambah Informasi
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
    <!-- Tabs Header Navigation -->
    <div class="border-b border-slate-100 bg-slate-50/80 px-6 pt-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.information-center.index', array_merge(request()->query(), ['tab' => 'active'])) }}" 
           class="px-4 py-2.5 rounded-t-2xl text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 transition-all {{ $tab === 'active' ? 'bg-white text-usu-green border-usu-green shadow-sm' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
            <i class="ph ph-check-circle text-base"></i>
            <span>Informasi Aktif & Draf</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $tab === 'active' ? 'bg-green-100 text-usu-green' : 'bg-slate-200 text-slate-600' }}">
                {{ $countActive }}
            </span>
        </a>
        <a href="{{ route('admin.information-center.index', array_merge(request()->query(), ['tab' => 'history'])) }}" 
           class="px-4 py-2.5 rounded-t-2xl text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 transition-all {{ $tab === 'history' ? 'bg-white text-rose-600 border-rose-600 shadow-sm' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
            <i class="ph ph-clock-counter-clockwise text-base"></i>
            <span>History & Arsip Kadaluwarsa</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $tab === 'history' ? 'bg-rose-100 text-rose-700' : 'bg-slate-200 text-slate-600' }}">
                {{ $countHistory }}
            </span>
        </a>
    </div>

    <!-- Filters -->
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <form action="{{ route('admin.information-center.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <input type="hidden" name="tab" value="{{ $tab }}">

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

            <div class="w-full sm:w-48">
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-usu-green/20 focus:border-usu-green transition-all">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draf (Disimpan)</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Diterbitkan (Aktif)</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa (Expired)</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan (Arsip)</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white font-semibold rounded-xl text-sm hover:bg-slate-700 transition-colors shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.information-center.index', ['tab' => $tab]) }}" class="px-5 py-2.5 bg-white text-slate-600 font-semibold border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                Reset
            </a>
        </form>
    </div>

    <!-- Banner Info Tab History jika aktif -->
    @if($tab === 'history')
        <div class="bg-rose-50/70 border-b border-rose-100 px-6 py-3.5 text-xs text-rose-800 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <i class="ph ph-info text-rose-600 text-lg flex-shrink-0"></i>
                <span>Menampilkan daftar informasi yang <strong>sudah melewati tanggal tayang (kadaluwarsa)</strong> atau <strong>diarsipkan</strong>. Klik tombol <strong class="text-green-700">"Tampilkan Kembali"</strong> untuk mengatur jadwal tayang baru.</span>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                    @if($tab === 'history')
                        <th class="px-4 py-4 w-10 text-center">
                            <input type="checkbox" id="select-all-checkbox" class="w-4 h-4 accent-emerald-600 rounded cursor-pointer" title="Pilih Semua">
                        </th>
                    @endif
                    <th class="px-5 py-4 font-semibold w-16">No</th>
                    <th class="px-5 py-4 font-semibold">Gambar</th>
                    <th class="px-5 py-4 font-semibold">Judul & Kategori</th>
                    <th class="px-5 py-4 font-semibold">Tampilan</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 font-semibold">Jadwal Tampil</th>
                    <th class="px-5 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($informationCenters as $index => $info)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        @if($tab === 'history')
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" name="ids[]" value="{{ $info->id }}" class="history-checkbox w-4 h-4 accent-emerald-600 rounded cursor-pointer">
                            </td>
                        @endif
                        <td class="px-5 py-4 text-slate-500">{{ $informationCenters->firstItem() + $index }}</td>
                        <td class="px-5 py-4">
                            @if($info->image_path)
                                <img src="{{ asset($info->image_path) }}" alt="{{ $info->title }}" class="h-12 w-20 object-cover rounded shadow-sm border border-slate-200 {{ $info->computed_status === 'expired' ? 'grayscale opacity-80' : '' }}" onerror="this.onerror=null; this.src='{{ asset('perpustakaan_depan.webp') }}';">
                            @else
                                <img src="{{ asset('perpustakaan_depan.webp') }}" alt="{{ $info->title }}" class="h-12 w-20 object-cover rounded shadow-sm border border-slate-200 {{ $info->computed_status === 'expired' ? 'grayscale opacity-80' : '' }}">
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-800 mb-1 line-clamp-1">{{ $info->title }}</div>
                            @php
                                $categoryName = match($info->category) {
                                    'event' => 'Event / Kegiatan',
                                    'announcement' => 'Pengumuman',
                                    'maintenance' => 'Pemeliharaan',
                                    'new_collection' => 'Koleksi Baru',
                                    'tips' => 'Tips & Trik',
                                    'promotion' => 'Promo / Penawaran',
                                    'general' => 'Informasi Umum',
                                    default => $info->category
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider">
                                {{ $categoryName }}
                            </span>
                        </td>
                        <td class="px-5 py-4 space-y-1">
                            @if($info->show_popup)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded">
                                    <i class="ph ph-app-window"></i> Popup (P:{{ $info->popup_priority }})
                                </span>
                            @endif
                            @if($info->show_navbar)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">
                                    <i class="ph ph-navigation-arrow"></i> Navbar
                                </span>
                            @endif
                            @if($info->is_featured)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">
                                    <i class="ph ph-star"></i> Featured
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $status = $info->computed_status;
                                $statusLabel = match($status) {
                                    'published' => 'Diterbitkan',
                                    'draft' => 'Draf',
                                    'expired' => 'Kedaluwarsa',
                                    'archived' => 'Diarsipkan',
                                    default => $status
                                };
                                $statusColor = match($status) {
                                    'published' => 'bg-green-100 text-green-700',
                                    'draft' => 'bg-slate-100 text-slate-700',
                                    'expired' => 'bg-red-100 text-red-700',
                                    'archived' => 'bg-orange-100 text-orange-700',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-xs">
                            <div class="font-medium text-slate-700">{{ $info->publish_start_at ? $info->publish_start_at->format('d M Y H:i') : '-' }}</div>
                            <div>s/d</div>
                            <div class="font-medium text-slate-700">{{ $info->publish_end_at ? $info->publish_end_at->format('d M Y H:i') : 'Selamanya' }}</div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($info->computed_status === 'expired' || $info->status === 'archived' || ($info->publish_end_at && $info->publish_end_at->isPast()))
                                    <button type="button" 
                                            class="action-tooltip px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm btn-republish-info cursor-pointer border-none"
                                            data-id="{{ $info->id }}"
                                            data-title="{{ e($info->title) }}"
                                            data-start-date="{{ $info->publish_start_at ? $info->publish_start_at->format('Y-m-d') : '' }}"
                                            data-start-time="{{ $info->publish_start_at ? $info->publish_start_at->format('H:i') : '08:00' }}"
                                            data-end-date="{{ $info->publish_end_at ? $info->publish_end_at->format('Y-m-d') : '' }}"
                                            data-end-time="{{ $info->publish_end_at ? $info->publish_end_at->format('H:i') : '12:00' }}"
                                            data-tooltip="Tampilkan Kembali di Beranda">
                                        <i class="ph ph-arrow-counter-clockwise text-sm font-bold"></i>
                                        <span class="hidden sm:inline">Tampilkan Kembali</span>
                                    </button>
                                @endif

                                @if($tab !== 'history' && $info->status !== 'archived')
                                    <form action="{{ route('admin.information-center.archive', $info->id) }}" method="POST" class="archive-info-form inline">
                                        @csrf
                                        <button type="button" class="action-tooltip w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center hover:bg-orange-100 transition-colors btn-archive-info" data-tooltip="Pindahkan ke Arsip">
                                            <i class="ph ph-archive text-lg"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.information-center.show', $info->id) }}" class="action-tooltip w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" data-tooltip="Lihat Detail Informasi">
                                    <i class="ph ph-eye text-lg"></i>
                                </a>
                                <a href="{{ route('admin.information-center.edit', $info->id) }}" class="action-tooltip w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors" data-tooltip="Edit Informasi">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>

                                @if($tab === 'history')
                                    <form action="{{ route('admin.information-center.destroy', $info->id) }}" method="POST" class="delete-info-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-tooltip w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors btn-delete-info" data-tooltip="Hapus Informasi">
                                            <i class="ph ph-trash text-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $tab === 'history' ? 8 : 7 }}" class="px-5 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="ph ph-empty text-5xl text-slate-300"></i>
                                <p class="text-sm font-medium text-slate-500">Tidak ada data informasi yang ditemukan dalam kategori ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($informationCenters->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $informationCenters->links() }}
        </div>
    @endif
</div>

{{-- FLOATING BULK ACTIONS BAR (HISTORI & ARSIP) --}}
@if($tab === 'history')
    <div id="bulk-action-bar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/95 text-white px-6 py-3.5 rounded-2xl shadow-2xl z-50 flex items-center gap-5 border border-slate-700/80 backdrop-blur-md transition-all duration-300">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span id="bulk-selected-count" class="text-xs font-bold text-slate-200">0 item terpilih</span>
        </div>

        <div class="h-4 w-px bg-slate-700"></div>

        <div class="flex items-center gap-3">
            <!-- Form Bulk Restore / Republish -->
            <form id="form-bulk-republish" action="{{ route('admin.information-center.bulk-republish-history') }}" method="POST" class="inline">
                @csrf
                <div id="bulk-republish-inputs"></div>
                <button type="button" id="btn-bulk-republish" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-md transition-all cursor-pointer border-none">
                    <i class="ph ph-arrow-counter-clockwise text-sm"></i>
                    Tampilkan Kembali Sekaligus
                </button>
            </form>

            <!-- Form Bulk Delete -->
            <form id="form-bulk-delete" action="{{ route('admin.information-center.bulk-delete-history') }}" method="POST" class="inline">
                @csrf
                <div id="bulk-delete-inputs"></div>
                <button type="button" id="btn-bulk-delete" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-md transition-all cursor-pointer border-none">
                    <i class="ph ph-trash text-sm"></i>
                    Hapus Sekaligus
                </button>
            </form>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Konfirmasi Arsip
        const archiveButtons = document.querySelectorAll('.btn-archive-info');
        archiveButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.archive-info-form');
                
                Swal.fire({
                    title: 'Pindahkan ke Arsip?',
                    text: 'Informasi ini akan dinonaktifkan dari beranda dan dipindahkan ke tab History & Arsip Kadaluwarsa.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#f97316',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="ph ph-archive"></i> Ya, Pindahkan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.disabled = true;
                        button.innerHTML = '<i class="ph ph-spinner animate-spin text-lg"></i>';
                        form.submit();
                    }
                });
            });
        });

        // Handle Konfirmasi Hapus Singel
        const deleteButtons = document.querySelectorAll('.btn-delete-info');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.delete-info-form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus Informasi',
                    text: 'Informasi ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#106c38',
                    cancelButtonColor: '#e11d48',
                    confirmButtonText: '<i class="ph ph-trash"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.disabled = true;
                        button.innerHTML = '<i class="ph ph-spinner animate-spin text-lg"></i>';
                        form.submit();
                    }
                });
            });
        });

        // Handle Modal Tampilkan Kembali
        const republishButtons = document.querySelectorAll('.btn-republish-info');
        republishButtons.forEach(button => {
            button.addEventListener('click', function () {
                const infoId = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');

                const now = new Date();
                const todayStr = now.toISOString().split('T')[0];
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const timeStr = `${hours}:${minutes}`;

                const futureDate = new Date(now.getTime() + (7 * 24 * 60 * 60 * 1000));
                const futureDateStr = futureDate.toISOString().split('T')[0];

                const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

                Swal.fire({
                    title: '<div class="text-base font-bold text-slate-800 flex items-center gap-2"><i class="ph ph-arrow-counter-clockwise text-emerald-600 text-xl"></i> Atur Jadwal Tampil Kembali</div>',
                    html: `
                        <div class="text-left text-xs sm:text-sm space-y-4 pt-2">
                            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="text-slate-400 font-semibold block text-[10px] uppercase tracking-wider">Judul Informasi</span>
                                <span class="font-bold text-slate-700 block mt-0.5 leading-snug">${title}</span>
                            </div>

                            <form id="republishForm" action="/admin/information-center/${infoId}/republish" method="POST">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Mulai Tayang (Tanggal & Jam) <span class="text-rose-500">*</span></label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" name="publish_start_date" value="${todayStr}" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                            <input type="time" name="publish_start_time" value="${timeStr}" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-1">Selesai Tayang (Tanggal & Jam) <span class="text-slate-400 font-normal">(Kosongkan jika selamanya)</span></label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="date" name="publish_end_date" value="${futureDateStr}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                            <input type="time" name="publish_end_time" value="23:59" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="ph ph-check-circle"></i> Simpan & Terbitkan Kembali',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-2xl max-w-md',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm'
                    },
                    preConfirm: () => {
                        const form = document.getElementById('republishForm');
                        if (!form.checkValidity()) {
                            form.reportValidity();
                            return false;
                        }
                        form.submit();
                    }
                });
            });
        });

        // ─── BULK ACTIONS (CENTANG BANYAK ON HISTORY TAB) ───────────────────
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const historyCheckboxes = document.querySelectorAll('.history-checkbox');
        const bulkActionBar     = document.getElementById('bulk-action-bar');
        const bulkCountBadge    = document.getElementById('bulk-selected-count');
        const btnBulkRepublish  = document.getElementById('btn-bulk-republish');
        const btnBulkDelete     = document.getElementById('btn-bulk-delete');
        const formBulkRepublish = document.getElementById('form-bulk-republish');
        const formBulkDelete    = document.getElementById('form-bulk-delete');
        const bulkRepublishInputs = document.getElementById('bulk-republish-inputs');
        const bulkDeleteInputs    = document.getElementById('bulk-delete-inputs');

        function updateBulkBarState() {
            const checkedBoxes = document.querySelectorAll('.history-checkbox:checked');
            const count = checkedBoxes.length;

            if (count > 0 && bulkActionBar) {
                bulkActionBar.classList.remove('hidden');
                if (bulkCountBadge) bulkCountBadge.textContent = `${count} item terpilih`;
            } else if (bulkActionBar) {
                bulkActionBar.classList.add('hidden');
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = (historyCheckboxes.length > 0 && count === historyCheckboxes.length);
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                historyCheckboxes.forEach(cb => cb.checked = this.checked);
                updateBulkBarState();
            });
        }

        historyCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkBarState);
        });

        // Bulk Republish Submit
        if (btnBulkRepublish && formBulkRepublish) {
            btnBulkRepublish.addEventListener('click', function () {
                const checked = document.querySelectorAll('.history-checkbox:checked');
                if (checked.length === 0) return;

                Swal.fire({
                    title: 'Tampilkan Kembali Sekaligus?',
                    text: `Apakah Anda yakin ingin mengaktifkan dan menampilkan kembali ${checked.length} informasi ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="ph ph-arrow-counter-clockwise"></i> Ya, Tampilkan Kembali',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-2xl max-w-md',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (bulkRepublishInputs) bulkRepublishInputs.innerHTML = '';
                        checked.forEach(cb => {
                            const inp = document.createElement('input');
                            inp.type = 'hidden';
                            inp.name = 'ids[]';
                            inp.value = cb.value;
                            if (bulkRepublishInputs) bulkRepublishInputs.appendChild(inp);
                        });
                        btnBulkRepublish.disabled = true;
                        btnBulkRepublish.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Memproses...';
                        formBulkRepublish.submit();
                    }
                });
            });
        }

        // Bulk Delete Submit
        if (btnBulkDelete && formBulkDelete) {
            btnBulkDelete.addEventListener('click', function () {
                const checked = document.querySelectorAll('.history-checkbox:checked');
                if (checked.length === 0) return;

                Swal.fire({
                    title: 'Hapus Sekaligus?',
                    text: `Apakah Anda yakin ingin menghapus ${checked.length} data informasi terpilih ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="ph ph-trash"></i> Ya, Hapus Sekaligus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-2xl max-w-md',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (bulkDeleteInputs) bulkDeleteInputs.innerHTML = '';
                        checked.forEach(cb => {
                            const inp = document.createElement('input');
                            inp.type = 'hidden';
                            inp.name = 'ids[]';
                            inp.value = cb.value;
                            if (bulkDeleteInputs) bulkDeleteInputs.appendChild(inp);
                        });
                        btnBulkDelete.disabled = true;
                        btnBulkDelete.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Memproses...';
                        formBulkDelete.submit();
                    }
                });
            });
        }
    });
</script>
@endpush
