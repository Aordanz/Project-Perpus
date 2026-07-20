@extends('admin.information_center.layout')

@section('title', 'Information Center')

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
            <i class="ph ph-megaphone text-usu-green text-3xl"></i>
            <span>Information Center</span>
        </h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Kelola seluruh informasi perpustakaan yang akan ditampilkan kepada pengguna.</p>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.information-center.trash') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all shadow-sm flex items-center gap-2">
            <i class="ph ph-trash-simple text-lg"></i> History / Sampah
        </a>
        <a href="{{ route('admin.information-center.create') }}" class="btn-gold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center gap-2">
            <i class="ph ph-plus font-bold"></i> Tambah Informasi
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
    <!-- Filters -->
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <form action="{{ route('admin.information-center.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
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
            <a href="{{ route('admin.information-center.index') }}" class="px-5 py-2.5 bg-white text-slate-600 font-semibold border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                Reset
            </a>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider">
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
                        <td class="px-5 py-4 text-slate-500">{{ $informationCenters->firstItem() + $index }}</td>
                        <td class="px-5 py-4">
                            @if($info->image_path)
                                <img src="{{ asset($info->image_path) }}" alt="Image" class="h-12 w-20 object-cover rounded shadow-sm border border-slate-200">
                            @else
                                <div class="h-12 w-20 bg-slate-100 rounded flex items-center justify-center border border-slate-200 text-slate-400">
                                    <i class="ph ph-image text-xl"></i>
                                </div>
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
                            <div class="font-medium text-slate-700">{{ $info->publish_start_at->format('d M Y H:i') }}</div>
                            <div>s/d</div>
                            <div class="font-medium text-slate-700">{{ $info->publish_end_at ? $info->publish_end_at->format('d M Y H:i') : 'Selamanya' }}</div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.information-center.show', $info->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Detail">
                                    <i class="ph ph-eye text-lg"></i>
                                </a>
                                <a href="{{ route('admin.information-center.edit', $info->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors" title="Edit">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>
                                <form action="{{ route('admin.information-center.destroy', $info->id) }}" method="POST" class="delete-info-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors btn-delete-info" title="Hapus">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="ph ph-empty text-5xl text-slate-300"></i>
                                <p>Tidak ada data informasi yang ditemukan.</p>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-info');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.delete-info-form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus Informasi',
                    text: 'Informasi ini akan dihapus dari portal utama dan dipindahkan ke menu History / Sampah!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#106c38',
                    cancelButtonColor: '#e11d48',
                    confirmButtonText: '<i class="ph ph-trash"></i> Ya, Pindahkan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ganti text di tombol agar kelihatan memuat
                        button.disabled = true;
                        button.innerHTML = '<i class="ph ph-spinner animate-spin text-lg"></i>';
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
