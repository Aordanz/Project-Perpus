@extends('admin.information_center.layout')

@section('title', 'History & Arsip Hapus')

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.information-center.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="ph ph-trash-simple text-rose-600 text-3xl"></i>
                <span>History / Arsip Hapus (Trash)</span>
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Daftar informasi yang dihapus sementara. Anda dapat memulihkan kembali atau menghapusnya secara permanen dari database.</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
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

            <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white font-semibold rounded-xl text-sm hover:bg-slate-700 transition-colors shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.information-center.trash') }}" class="px-5 py-2.5 bg-white text-slate-600 font-semibold border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition-colors">
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
                    <th class="px-5 py-4 font-semibold">Tanggal Dihapus</th>
                    <th class="px-5 py-4 font-semibold text-right">Aksi Pemulihan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($trashItems as $index => $info)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-5 py-4 text-slate-500">{{ $trashItems->firstItem() + $index }}</td>
                        <td class="px-5 py-4">
                            @if($info->image_path)
                                <img src="{{ asset($info->image_path) }}" alt="Image" class="h-12 w-20 object-cover rounded shadow-sm border border-slate-200 grayscale opacity-70">
                            @else
                                <div class="h-12 w-20 bg-slate-100 rounded flex items-center justify-center border border-slate-200 text-slate-400">
                                    <i class="ph ph-image text-xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-700 mb-1 line-clamp-1 line-through decoration-slate-400">{{ $info->title }}</div>
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
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500 uppercase tracking-wider">
                                {{ $categoryName }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-500 font-medium">
                            {{ $info->deleted_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <!-- Form Restore -->
                                <form action="{{ route('admin.information-center.restore', $info->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-green-50 text-green-700 font-bold hover:bg-green-100 transition-colors flex items-center gap-1.5 text-xs shadow-sm" title="Pulihkan / Kembalikan">
                                        <i class="ph ph-arrow-counter-clockwise text-sm"></i> Pulihkan
                                    </button>
                                </form>

                                <!-- Form Force Delete -->
                                <form action="{{ route('admin.information-center.force-delete', $info->id) }}" method="POST" class="delete-permanen-form inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="px-3.5 py-1.5 rounded-lg bg-rose-50 text-rose-700 font-bold hover:bg-rose-100 transition-colors flex items-center gap-1.5 text-xs btn-delete-permanen shadow-sm" title="Hapus Permanen">
                                        <i class="ph ph-trash text-sm"></i> Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="ph ph-trash-simple text-6xl text-slate-200"></i>
                                <p class="text-sm font-bold text-slate-400">Tidak ada history / arsip informasi yang dihapus.</p>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deletePermanenButtons = document.querySelectorAll('.btn-delete-permanen');
        
        deletePermanenButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.delete-permanen-form');
                
                Swal.fire({
                    title: 'HAPUS PERMANEN?',
                    text: 'Tindakan ini akan menghapus informasi ini secara fisik dari DATABASE selamanya. Data tidak dapat dipulihkan lagi!',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#475569',
                    confirmButtonText: '<i class="ph ph-trash-simple"></i> Ya, Hapus Selamanya!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.disabled = true;
                        button.innerHTML = '<i class="ph ph-spinner animate-spin text-sm"></i> Menghapus...';
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
