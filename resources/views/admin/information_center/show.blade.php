@extends('admin.information_center.layout')

@section('title', 'Detail Informasi')

@section('content')
<div class="flex items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.information-center.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Detail Informasi</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Lihat detail informasi lengkap.</p>
        </div>
    </div>
    <div class="flex gap-2">
        @if($informationCenter->computed_status === 'expired' || $informationCenter->status === 'archived' || ($informationCenter->publish_end_at && $informationCenter->publish_end_at->isPast()))
            <button type="button" 
                    class="px-5 py-2.5 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors flex items-center gap-2 text-sm btn-republish-info cursor-pointer border-none shadow-sm"
                    data-id="{{ $informationCenter->id }}"
                    data-title="{{ e($informationCenter->title) }}">
                <i class="ph ph-arrow-counter-clockwise text-lg"></i> Tampilkan Kembali
            </button>
        @endif
        <a href="{{ route('admin.information-center.edit', $informationCenter->id) }}" class="px-5 py-2.5 rounded-xl font-bold text-amber-600 bg-amber-50 hover:bg-amber-100 transition-colors flex items-center gap-2 text-sm">
            <i class="ph ph-pencil-simple text-lg"></i> Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            @if($informationCenter->image_path)
                <img src="{{ asset($informationCenter->image_path) }}" alt="{{ $informationCenter->title }}" class="w-full h-64 object-cover" onerror="this.onerror=null; this.src='{{ asset('perpustakaan_depan.webp') }}';">
            @else
                <img src="{{ asset('perpustakaan_depan.webp') }}" alt="{{ $informationCenter->title }}" class="w-full h-64 object-cover">
            @endif
            
            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap gap-2 mb-4">
                    @php
                        $categoryName = match($informationCenter->category) {
                            'event' => 'Event / Kegiatan',
                            'announcement' => 'Pengumuman',
                            'maintenance' => 'Pemeliharaan',
                            'new_collection' => 'Koleksi Baru',
                            'tips' => 'Tips & Trik',
                            'promotion' => 'Promo / Penawaran',
                            'general' => 'Informasi Umum',
                            default => $informationCenter->category
                        };
                        
                        $status = $informationCenter->computed_status;
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
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider">
                        {{ $categoryName }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $informationCenter->title }}</h2>
                
                @if($informationCenter->summary)
                    <p class="text-slate-600 font-medium mb-6 text-sm leading-relaxed border-l-4 border-usu-green pl-4 py-1 bg-slate-50/50 rounded-r-lg">{{ $informationCenter->summary }}</p>
                @endif

                <div class="prose prose-slate max-w-none text-sm">
                    {!! $informationCenter->content !!}
                </div>

                @if($informationCenter->action_button_url)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tautan & Tombol Aksi:</h3>
                        <div class="flex flex-wrap gap-3">
                            @if(is_array($informationCenter->action_button_url))
                                @foreach($informationCenter->action_button_url as $btn)
                                    <a href="{{ $btn['url'] }}" target="{{ isset($btn['new_tab']) && $btn['new_tab'] ? '_blank' : '_self' }}" class="btn-gold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm inline-flex items-center gap-2">
                                        {{ $btn['name'] }}
                                        @if(isset($btn['new_tab']) && $btn['new_tab'])
                                            <i class="ph ph-arrow-square-out"></i>
                                        @else
                                            <i class="ph ph-arrow-right"></i>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                <a href="{{ $informationCenter->action_button_url }}" class="btn-gold px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm inline-flex items-center gap-2">
                                    {{ $informationCenter->action_button_name ?? 'Buka Link' }}
                                    <i class="ph ph-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="ph ph-calendar text-usu-green text-lg"></i> Jadwal Tayang
            </h3>
            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Mulai Tayang</span>
                    <div class="text-sm font-medium text-slate-800">{{ $informationCenter->publish_start_at->format('d F Y, H:i') }} WIB</div>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Berakhir Pada</span>
                    <div class="text-sm font-medium text-slate-800">
                        @if($informationCenter->publish_end_at)
                            {{ $informationCenter->publish_end_at->format('d F Y, H:i') }} WIB
                        @else
                            <span class="text-green-600 font-bold">Tayang Selamanya</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="ph ph-monitor text-usu-green text-lg"></i> Info Tampilan
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Tampil Popup</span>
                    @if($informationCenter->show_popup)
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Ya (Prioritas: {{ $informationCenter->popup_priority }})</span>
                    @else
                        <span class="text-xs font-bold text-slate-400">Tidak</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Tampil Navbar</span>
                    @if($informationCenter->show_navbar)
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Ya</span>
                    @else
                        <span class="text-xs font-bold text-slate-400">Tidak</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Featured</span>
                    @if($informationCenter->is_featured)
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">Ya</span>
                    @else
                        <span class="text-xs font-bold text-slate-400">Tidak</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Sort Order</span>
                    <span class="text-xs font-bold text-slate-800">{{ $informationCenter->sort_order }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-600">Dilihat</span>
                    <span class="text-xs font-bold text-slate-800">{{ $informationCenter->view_count }} kali</span>
                </div>
            </div>
        </div>

        @if($informationCenter->contact_name || $informationCenter->contact_phone || $informationCenter->contact_email)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="ph ph-address-book text-usu-green text-lg"></i> Contact Person
            </h3>
            <div class="space-y-3">
                @if($informationCenter->contact_name)
                <div class="flex items-center gap-3">
                    <i class="ph ph-user text-slate-400"></i>
                    <span class="text-sm font-medium text-slate-700">{{ $informationCenter->contact_name }}</span>
                </div>
                @endif
                
                @if($informationCenter->contact_phone)
                <div class="flex items-center gap-3">
                    <i class="ph ph-whatsapp-logo text-green-500"></i>
                    <span class="text-sm font-medium text-slate-700">{{ $informationCenter->contact_phone }}</span>
                </div>
                @endif

                @if($informationCenter->contact_email)
                <div class="flex items-center gap-3">
                    <i class="ph ph-envelope-simple text-blue-500"></i>
                    <span class="text-sm font-medium text-slate-700">{{ $informationCenter->contact_email }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="ph ph-info text-usu-green text-lg"></i> Metadata
            </h3>
            <div class="space-y-3">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Dibuat Oleh</span>
                    <div class="text-sm font-medium text-slate-800">{{ $informationCenter->creator->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-slate-400">{{ $informationCenter->created_at->format('d M Y, H:i') }}</div>
                </div>
                @if($informationCenter->updated_by)
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Terakhir Diupdate Oleh</span>
                    <div class="text-sm font-medium text-slate-800">{{ $informationCenter->updator->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-slate-400">{{ $informationCenter->updated_at->format('d M Y, H:i') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>
@endpush
