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
            @if($informationCenter->type === 'poster')
                @if($informationCenter->image_path)
                    <img src="{{ asset($informationCenter->image_path) }}" alt="{{ $informationCenter->title }}" class="w-full aspect-[4/5] object-cover max-w-md mx-auto mt-8 rounded-2xl shadow-lg border border-slate-100" onerror="this.onerror=null; this.src='{{ asset('perpustakaan_depan.webp') }}';">
                @else
                    <img src="{{ asset('perpustakaan_depan.webp') }}" alt="{{ $informationCenter->title }}" class="w-full aspect-[4/5] object-cover max-w-md mx-auto mt-8 rounded-2xl shadow-lg border border-slate-100">
                @endif
            @else
                @if($informationCenter->image_path)
                    <img src="{{ asset($informationCenter->image_path) }}" alt="{{ $informationCenter->title }}" class="w-full aspect-[4/5] object-cover sm:max-w-xs mx-auto mt-6 rounded-2xl shadow border border-slate-100" onerror="this.onerror=null; this.src='{{ asset('perpustakaan_depan.webp') }}';">
                @else
                    <img src="{{ asset('perpustakaan_depan.webp') }}" alt="{{ $informationCenter->title }}" class="w-full aspect-[4/5] object-cover sm:max-w-xs mx-auto mt-6 rounded-2xl shadow border border-slate-100">
                @endif
            @endif
            
            <div class="p-6 sm:p-8">
                @if($informationCenter->type !== 'poster')
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
                    
                    @php
                        $contentData = json_decode($informationCenter->content, true);
                        $isJsonContent = json_last_error() === JSON_ERROR_NONE && is_array($contentData);
                    @endphp

                    @if($isJsonContent)
                        <div class="prose prose-slate max-w-none text-sm mb-4">
                            @if(isset($contentData['description']))
                                <p class="whitespace-pre-line">{!! nl2br(e($contentData['description'])) !!}</p>
                            @endif
                        </div>
                        
                        <div class="bg-slate-50 border border-slate-100 rounded-xl overflow-hidden mb-6 max-w-md">
                            @foreach($contentData as $key => $val)
                                @if($key !== 'description' && $key !== 'is_custom_collection' && !empty($val) && !is_array($val))
                                    @php
                                        $label = ucwords(str_replace('_', ' ', $key));
                                        // Ganti beberapa label khusus agar lebih cantik
                                        if ($key === 'book_author') $label = 'Penulis';
                                        if ($key === 'book_publisher') $label = 'Penerbit';
                                        if ($key === 'shelf_location') $label = 'Lokasi Rak';
                                        if ($key === 'event_time' || $key === 'announcement_time') $label = 'Waktu';
                                        if ($key === 'event_location' || $key === 'announcement_location') $label = 'Lokasi';
                                        if ($key === 'event_organizer') $label = 'Penyelenggara';
                                        if ($key === 'news_date') $label = 'Tanggal Berita';
                                    @endphp
                                    <div class="flex items-center gap-2.5 px-3 py-2 border-b border-slate-100 last:border-0">
                                        <div class="w-1.5 h-1.5 rounded-full bg-usu-green shrink-0"></div>
                                        <span class="text-[10px] font-black text-slate-400 uppercase w-24 shrink-0">{{ $label }}</span>
                                        <span class="text-xs font-bold text-slate-800 flex-1 truncate" title="{{ $val }}">{{ $val }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="prose prose-slate max-w-none text-sm">
                            {!! $informationCenter->content !!}
                        </div>
                    @endif
                @else
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider">
                            POSTER GAMBAR
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                @endif

                @if($informationCenter->action_button_url)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tautan & Tombol Aksi:</h3>
                        <div class="flex flex-wrap gap-3">
                            @if(is_array($informationCenter->action_button_url) && count($informationCenter->action_button_url) > 0)
                                @php $btn = $informationCenter->action_button_url[0]; @endphp
                                <a href="{{ $btn['url'] }}" target="{{ isset($btn['new_tab']) && $btn['new_tab'] ? '_blank' : '_self' }}" class="btn-gold w-full px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2">
                                    {{ $btn['name'] }}
                                    <i class="ph ph-arrow-right"></i>
                                </a>
                            @elseif(!is_array($informationCenter->action_button_url) && !empty($informationCenter->action_button_url))
                                <a href="{{ $informationCenter->action_button_url }}" class="btn-gold w-full px-6 py-2.5 rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-2">
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



        @if($informationCenter->type !== 'poster' && ($informationCenter->contact_name || $informationCenter->contact_phone || $informationCenter->contact_email))
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
                <div class="pt-2 mt-2 border-t border-slate-100">
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Dilihat</span>
                    <div class="text-sm font-medium text-slate-800">{{ $informationCenter->view_count }} kali</div>
                </div>
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

                const maxSortOrder = {{ max(1, \App\Models\InformationCenter::where('status', '!=', 'archived')->where(function($q){ $q->whereNull('publish_end_at')->orWhere('publish_end_at', '>=', now()); })->count() + 1) }};

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
                                
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-2">Status Publikasi <span class="text-rose-500">*</span></label>
                                            <select name="status" id="swal_status" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                                                <option value="published">🟢 Diterbitkan</option>
                                                <option value="draft">📝 Draf (Jadwalkan)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-2">Urutan Tampil <span class="text-rose-500">*</span></label>
                                            <input type="number" name="sort_order" title="Urutan Tampil" placeholder="Maks: ${maxSortOrder}" value="${maxSortOrder}" min="1" max="${maxSortOrder}" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                                            <p class="text-[9.5px] text-slate-400 mt-1">Maksimal ${maxSortOrder}.</p>
                                        </div>
                                    </div>

                                    <div id="swal_live_publish_badge" class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-xs font-semibold flex items-center gap-2">
                                        <i class="ph ph-check-circle text-base"></i> Ditayangkan langsung saat ini.
                                    </div>

                                    <div id="swal_start_time_wrapper" class="hidden">
                                        <label class="block text-xs font-bold text-slate-600 mb-2">Mulai Tayang <span class="text-rose-500">*</span></label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <span class="block text-[10px] text-slate-400 mb-1.5">Tanggal</span>
                                                <input type="date" name="publish_start_date" id="swal_start_date" value="${todayStr}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" min="${todayStr}">
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-slate-400 mb-1.5">Jam</span>
                                                <input type="time" name="publish_start_time" id="swal_start_time" value="${timeStr}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                                <span id="swal_start_time_error" class="hidden text-[10px] text-red-500 mt-1 leading-tight block">Jam tidak boleh lewat!</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-600 mb-2">Selesai Tayang <span class="ml-1.5 px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 text-[9px] font-extrabold uppercase tracking-widest">Opsional</span></label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <span class="block text-[10px] text-slate-400 mb-1.5">Tanggal</span>
                                                <input type="date" name="publish_end_date" id="swal_end_date" value="${futureDateStr}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600" min="${todayStr}">
                                            </div>
                                            <div>
                                                <span class="block text-[10px] text-slate-400 mb-1.5">Jam</span>
                                                <input type="time" name="publish_end_time" id="swal_end_time" value="23:59" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                                <span id="swal_end_time_error" class="hidden text-[10px] text-red-500 mt-1 leading-tight block">Jam tidak boleh lewat!</span>
                                            </div>
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
                    didOpen: () => {
                        const statusSelect = document.getElementById('swal_status');
                        const startTimeWrapper = document.getElementById('swal_start_time_wrapper');
                        const livePublishBadge = document.getElementById('swal_live_publish_badge');
                        
                        const startDateInput = document.getElementById('swal_start_date');
                        const startTimeInput = document.getElementById('swal_start_time');
                        const startTimeError = document.getElementById('swal_start_time_error');
                        const endDateInput = document.getElementById('swal_end_date');
                        const endTimeInput = document.getElementById('swal_end_time');
                        const endTimeError = document.getElementById('swal_end_time_error');

                        function updateStatusState() {
                            if (statusSelect.value === 'published') {
                                startTimeWrapper.classList.add('hidden');
                                livePublishBadge.classList.remove('hidden');
                                startDateInput.required = false;
                                startTimeInput.required = false;
                            } else {
                                startTimeWrapper.classList.remove('hidden');
                                livePublishBadge.classList.add('hidden');
                                startDateInput.required = true;
                                startTimeInput.required = true;
                            }
                        }

                        statusSelect.addEventListener('change', updateStatusState);
                        updateStatusState();

                        function getTodayDateStr() {
                            const d = new Date();
                            const yyyy = d.getFullYear();
                            const mm = String(d.getMonth() + 1).padStart(2, '0');
                            const dd = String(d.getDate()).padStart(2, '0');
                            return `${yyyy}-${mm}-${dd}`;
                        }

                        function isValidTimeStr(timeStr) {
                            if (!timeStr) return true;
                            const d = new Date();
                            const h = d.getHours();
                            const m = d.getMinutes();
                            const parts = timeStr.split(':');
                            if (parts.length === 2) {
                                const ih = parseInt(parts[0], 10);
                                const im = parseInt(parts[1], 10);
                                if (ih < h || (ih === h && im < m)) {
                                    return false;
                                }
                            }
                            return true;
                        }

                        function validateStartTime() {
                            if (statusSelect.value === 'draft' && startDateInput.value === getTodayDateStr()) {
                                if (!isValidTimeStr(startTimeInput.value)) {
                                    startTimeError.classList.remove('hidden');
                                    startTimeInput.classList.add('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                } else {
                                    startTimeError.classList.add('hidden');
                                    startTimeInput.classList.remove('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                }
                            } else {
                                startTimeError.classList.add('hidden');
                                startTimeInput.classList.remove('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                            }
                        }

                        function validateEndTime() {
                            if (endDateInput.value === getTodayDateStr()) {
                                if (!isValidTimeStr(endTimeInput.value)) {
                                    endTimeError.classList.remove('hidden');
                                    endTimeInput.classList.add('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                } else {
                                    endTimeError.classList.add('hidden');
                                    endTimeInput.classList.remove('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                }
                            } else {
                                endTimeError.classList.add('hidden');
                                endTimeInput.classList.remove('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                            }
                        }

                        startTimeInput.addEventListener('change', validateStartTime);
                        startDateInput.addEventListener('change', validateStartTime);
                        endTimeInput.addEventListener('change', validateEndTime);
                        endDateInput.addEventListener('change', validateEndTime);
                        statusSelect.addEventListener('change', validateStartTime);
                    },
                    preConfirm: () => {
                        const form = document.getElementById('republishForm');
                        if (!form.checkValidity()) {
                            form.reportValidity();
                            return false;
                        }

                        const statusSelect = document.getElementById('swal_status');
                        const startDateInput = document.getElementById('swal_start_date');
                        const startTimeInput = document.getElementById('swal_start_time');
                        const startTimeError = document.getElementById('swal_start_time_error');
                        const endDateInput = document.getElementById('swal_end_date');
                        const endTimeInput = document.getElementById('swal_end_time');
                        const endTimeError = document.getElementById('swal_end_time_error');

                        function getTodayDateStr() {
                            const d = new Date();
                            const yyyy = d.getFullYear();
                            const mm = String(d.getMonth() + 1).padStart(2, '0');
                            const dd = String(d.getDate()).padStart(2, '0');
                            return `${yyyy}-${mm}-${dd}`;
                        }

                        function isValidTimeStr(timeStr) {
                            if (!timeStr) return true;
                            const d = new Date();
                            const h = d.getHours();
                            const m = d.getMinutes();
                            const parts = timeStr.split(':');
                            if (parts.length === 2) {
                                const ih = parseInt(parts[0], 10);
                                const im = parseInt(parts[1], 10);
                                if (ih < h || (ih === h && im < m)) {
                                    return false;
                                }
                            }
                            return true;
                        }

                        let isValid = true;

                        if (statusSelect.value === 'draft') {
                            if (startDateInput.value === getTodayDateStr()) {
                                if (!isValidTimeStr(startTimeInput.value)) {
                                    startTimeError.classList.remove('hidden');
                                    startTimeInput.classList.add('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                    isValid = false;
                                }
                            }
                        }

                        if (endDateInput.value && endDateInput.value === getTodayDateStr()) {
                            if (!isValidTimeStr(endTimeInput.value)) {
                                endTimeError.classList.remove('hidden');
                                endTimeInput.classList.add('border-red-500', 'focus:ring-red-500/20', 'focus:border-red-600');
                                isValid = false;
                            }
                        }

                        if (!isValid) {
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
