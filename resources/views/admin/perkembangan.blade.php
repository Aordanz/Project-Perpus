<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Perkembangan User - Portal Admin OPAC USU</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .bg-usu-green  { background-color: #106c38; }
        .text-usu-green { color: #106c38; }

        /* Custom Dropdown */
        #dropdownPanel {
            animation: dropdownIn 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes dropdownIn {
            from { opacity: 0; transform: translateY(-6px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        .dropdown-option.active-option {
            background-color: #f0fdf4;
        }
        .dropdown-option.active-option .option-check {
            display: inline-block !important;
        }
        .dropdown-option.active-option span.text-xs {
            color: #106c38;
            font-weight: 600;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
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
                        <i class="ph ph-chart-bar text-usu-green text-2xl sm:text-3xl"></i>
                        <span>Perkembangan Per Akun</span>
                    </h1>
                    <p class="text-slate-500 text-[10px] sm:text-sm mt-1">Statistik kontribusi pustakawan dalam menambahkan cover dan ringkasan buku.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 flex items-center gap-2 text-amber-700 text-xs font-semibold flex-shrink-0">
                        <i class="ph ph-shield-check text-base"></i>
                        <span>Akses: idgroup 3</span>
                    </div>
                </div>
            </div>

            {{-- Filter Periode Control Bar (Redesigned & Clean) --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-3 sm:gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-grow">
                    <div class="flex items-center gap-2 text-slate-700 font-bold text-xs uppercase tracking-wider shrink-0 bg-slate-50 px-3 py-2 rounded-xl border border-slate-200/60">
                        <i class="ph ph-calendar text-usu-green text-base"></i>
                        <span class="whitespace-nowrap">Pilih Periode:</span>
                    </div>
                    
                    {{-- Custom Dropdown Periode --}}
                    <div class="relative w-full sm:w-80" id="customDropdownWrapper">
                        {{-- Hidden native select (untuk handlePeriodeChange tetap berjalan) --}}
                        <select id="periodeSelect" onchange="handlePeriodeChange(this.value)" class="hidden">
                            <option value="all">Semua Periode (Total Akumulasi)</option>
                            @foreach($monthlyData as $keyMonth => $mVal)
                                <option value="{{ $keyMonth }}">{{ $mVal['label'] }} ({{ count($mVal['users']) }} akun)</option>
                            @endforeach
                        </select>

                        {{-- Trigger Button --}}
                        <button
                            type="button"
                            id="dropdownTrigger"
                            onclick="toggleCustomDropdown()"
                            class="w-full flex items-center justify-between gap-2 bg-white border border-slate-200 hover:border-[#106c38] rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition-all duration-200 group"
                        >
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="ph ph-calendar-blank text-[#106c38] text-sm shrink-0"></i>
                                <span id="dropdownLabel" class="truncate">Semua Periode (Total Akumulasi)</span>
                            </div>
                            <i id="dropdownCaret" class="ph ph-caret-down text-slate-400 text-sm shrink-0 transition-transform duration-200"></i>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div
                            id="dropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden"
                        >
                            {{-- Search (kalau opsi banyak) --}}
                            <div class="p-2 border-b border-slate-100">
                                <div class="flex items-center gap-2 bg-slate-50 rounded-xl px-3 py-2">
                                    <i class="ph ph-magnifying-glass text-slate-400 text-sm"></i>
                                    <input
                                        type="text"
                                        id="dropdownSearch"
                                        placeholder="Cari periode..."
                                        oninput="filterDropdownOptions(this.value)"
                                        class="bg-transparent text-xs text-slate-700 placeholder-slate-400 outline-none w-full"
                                    />
                                </div>
                            </div>

                            {{-- Options List --}}
                            <ul id="dropdownOptions" class="max-h-56 overflow-y-auto py-1.5 custom-scrollbar">
                                <li
                                    data-value="all"
                                    data-label="Semua Periode (Total Akumulasi)"
                                    onclick="selectDropdownOption(this)"
                                    class="dropdown-option flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-emerald-50 transition-colors duration-150 group/item"
                                >
                                    <span class="w-5 h-5 flex items-center justify-center rounded-full bg-emerald-100 shrink-0">
                                        <i class="ph ph-stack text-[#106c38] text-xs"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-slate-700 group-hover/item:text-[#106c38] transition-colors">Semua Periode (Total Akumulasi)</span>
                                    <i class="ph ph-check text-[#106c38] text-sm ml-auto option-check"></i>
                                </li>
                                @foreach($monthlyData as $keyMonth => $mVal)
                                <li
                                    data-value="{{ $keyMonth }}"
                                    data-label="{{ $mVal['label'] }}"
                                    onclick="selectDropdownOption(this)"
                                    class="dropdown-option flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-emerald-50 transition-colors duration-150 group/item"
                                >
                                    <span class="w-5 h-5 flex items-center justify-center rounded-full bg-slate-100 shrink-0">
                                        <i class="ph ph-calendar text-slate-500 text-xs"></i>
                                    </span>
                                    <span class="text-xs font-medium text-slate-600 group-hover/item:text-[#106c38] transition-colors">
                                        {{ $mVal['label'] }}
                                        <span class="ml-1 text-[10px] font-semibold bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded-full">{{ count($mVal['users']) }} akun</span>
                                    </span>
                                    <i class="ph ph-check text-[#106c38] text-sm ml-auto option-check hidden"></i>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <span id="badgeActivePeriod" class="text-xs font-semibold text-[#106c38] bg-emerald-50 px-3 py-2 rounded-xl border border-emerald-200/60 inline-flex items-center gap-1.5 w-fit">
                        <i class="ph ph-check-circle text-emerald-600"></i>
                        <span id="badgePeriodText">Menampilkan Total Akumulasi</span>
                    </span>
                </div>

                {{-- Quick Info on the right to balance space --}}
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-200/50 self-start lg:self-auto">
                    <i class="ph ph-lightning text-amber-500 text-base"></i>
                    <span>Diperbarui otomatis dari database</span>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-5">
                {{-- Total User Aktif --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm hover:border-[#106c38]/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="ph ph-users-three"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total User Berkontribusi</span>
                        <h3 id="cardTotalUser" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ $stats->count() }}</h3>
                    </div>
                </div>

                {{-- Total Cover --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm hover:border-[#106c38]/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="ph ph-image"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Cover Ditambah</span>
                        <h3 id="cardTotalCover" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_cover')) }}</h3>
                    </div>
                </div>

                {{-- Total Ringkasan --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm hover:border-[#106c38]/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="ph ph-file-text"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Ringkasan Ditambah</span>
                        <h3 id="cardTotalRingkasan" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_ringkasan')) }}</h3>
                    </div>
                </div>

                {{-- Top Kontributor --}}
                @php $topUser = $stats->first(); @endphp
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm hover:border-[#106c38]/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="ph ph-trophy"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Top Kontributor</span>
                        <h3 id="cardTopUser" class="text-sm sm:text-base font-black text-[#006633] mt-0.5 truncate">
                            {{ $topUser ? $topUser['username'] : '-' }}
                        </h3>
                        <p id="cardTopSub" class="text-[9px] text-slate-400 font-medium truncate">
                            @if($topUser)
                                {{ $topUser['jumlah_cover'] }} cover · {{ $topUser['jumlah_ringkasan'] }} ringkasan
                            @else
                                Belum ada data
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Grafik Kontribusi (Leaderboard Horizontal Stacked Bar) --}}
            <div id="chartContainer" class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                            <i class="ph ph-chart-bar-horizontal"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Peringkat Kontribusi Pustakawan</h2>
                            <p id="chartSubText" class="text-xs text-slate-500">Perbandingan jumlah cover dan ringkasan yang ditambahkan per akun.</p>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-600 bg-slate-50 px-3.5 py-1.5 rounded-xl border border-slate-100 self-start sm:self-auto">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded inline-block shrink-0 shadow-xs" style="background-color: #106c38;"></span>
                            <span>Cover Buku</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded inline-block shrink-0 shadow-xs" style="background-color: #F9C311;"></span>
                            <span>Ringkasan Buku</span>
                        </div>
                    </div>
                </div>

                <div id="chartEmptyMessage" class="hidden flex-col items-center justify-center py-12 text-slate-400">
                    <i class="ph ph-chart-bar text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data kontribusi untuk periode ini.</p>
                </div>

                <div id="chartCanvasWrapper" class="relative w-full" style="min-height: 240px;">
                    <canvas id="perkembanganChart"></canvas>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                            <i class="ph ph-table"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Rincian Per Akun</h2>
                            <p id="tableSubText" class="text-xs text-slate-500">Detail kontribusi pustakawan diurutkan dari yang terbanyak.</p>
                        </div>
                    </div>
                    <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl">
                        <span id="tableRowCount" class="text-[#106c38] font-bold">{{ $totalUserTerdaftar }}</span> Akun Terdaftar
                    </div>
                </div>

                <div id="tableEmptyState" class="{{ $stats->isEmpty() ? 'flex' : 'hidden' }} flex-col items-center justify-center py-10 text-slate-400">
                    <i class="ph ph-users text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data kontribusi untuk periode yang dipilih.</p>
                </div>

                <div id="tableWrapper" class="{{ $stats->isEmpty() ? 'hidden' : 'block' }} overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-500">
                                <th class="text-center text-[10px] font-bold uppercase tracking-wider pb-3 pr-3 w-12">Peringkat</th>
                                <th class="text-left text-[10px] font-bold uppercase tracking-wider pb-3 pr-3">Username</th>
                                <th class="text-left text-[10px] font-bold uppercase tracking-wider pb-3 pr-3 hidden sm:table-cell">Nama Lengkap</th>
                                <th class="text-left text-[10px] font-bold uppercase tracking-wider pb-3 pr-3 hidden md:table-cell">Jabatan</th>
                                <th class="text-center text-[10px] font-bold uppercase tracking-wider pb-3 pr-3 w-28">
                                    <span class="flex items-center justify-center gap-1"><i class="ph ph-image text-sm"></i> Cover</span>
                                </th>
                                <th class="text-center text-[10px] font-bold uppercase tracking-wider pb-3 pr-3 w-28">
                                    <span class="flex items-center justify-center gap-1"><i class="ph ph-file-text text-sm"></i> Ringkasan</span>
                                </th>
                                <th class="text-center text-[10px] font-bold uppercase tracking-wider pb-3 w-28">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-slate-50">
                            @foreach($stats as $index => $user)
                            @php
                                $total = $user['jumlah_cover'] + $user['jumlah_ringkasan'];
                                $rank = $index + 1;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition group">
                                <td class="py-3 pr-3 text-center">
                                    @if($rank === 1)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #d97706; color: #ffffff;" title="Peringkat 1">1</span>
                                    @elseif($rank === 2)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #64748b; color: #ffffff;" title="Peringkat 2">2</span>
                                    @elseif($rank === 3)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #b45309; color: #ffffff;" title="Peringkat 3">3</span>
                                    @else
                                        <span class="text-xs text-slate-600 font-bold">{{ $rank }}</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($user['username'], 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-slate-800 text-xs">{{ $user['username'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 pr-3 hidden sm:table-cell">
                                    <span class="text-xs text-slate-700 font-medium">{{ $user['nama_lengkap'] ?? '-' }}</span>
                                </td>
                                <td class="py-3 pr-3 hidden md:table-cell">
                                    <span class="text-xs text-slate-500">{{ $user['keterangan'] ?? '-' }}</span>
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    <span class="inline-flex items-center justify-center gap-1 bg-emerald-50 text-emerald-700 font-bold text-xs px-2.5 py-1 rounded-lg min-w-[3rem]">
                                        {{ number_format($user['jumlah_cover']) }}
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    <span class="inline-flex items-center justify-center gap-1 bg-amber-50 text-amber-700 font-bold text-xs px-2.5 py-1 rounded-lg min-w-[3rem]">
                                        {{ number_format($user['jumlah_ringkasan']) }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="inline-flex items-center justify-center font-black text-xs text-white bg-[#106c38] px-3 py-1 rounded-lg min-w-[3rem] shadow-xs">
                                        {{ number_format($total) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Catatan Metodologi --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex gap-3 text-sm">
                <i class="ph ph-info text-blue-500 text-xl flex-shrink-0 mt-0.5"></i>
                <div class="text-blue-700 text-xs font-medium leading-relaxed">
                    <p class="font-bold mb-1">Catatan Metodologi</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li><strong>Filter Periode:</strong> Pilih bulan tertentu dari menu dropdown di atas untuk melihat kinerja kontribusi akun pada periode tersebut.</li>
                        <li><strong>Cover:</strong> Dihitung berdasarkan buku yang memiliki foto cover di galeri buku.</li>
                        <li><strong>Ringkasan:</strong> Dihitung berdasarkan kelengkapan kolom ringkasan buku.</li>
                    </ul>
                </div>
            </div>

        </main>

        @include('partials.admin_footer')
    </div>

    {{-- Script Chart --}}
    <script>
        // Data Global dari Controller
        const allStats = @json($stats);
        const monthlyData = @json($monthlyData);

        let myChart = null;

        // Inisialisasi Chart.js — Horizontal Stacked Bar (Rata, Proporsional, Rapih)
        function renderChart(labels, covers, ringkasan) {
            const ctx = document.getElementById('perkembanganChart');
            if (!ctx) return;

            const emptyMsg = document.getElementById('chartEmptyMessage');
            const canvasWrapper = document.getElementById('chartCanvasWrapper');

            if (!labels || labels.length === 0) {
                if (emptyMsg) emptyMsg.classList.remove('hidden');
                if (canvasWrapper) canvasWrapper.classList.add('hidden');
                if (myChart) { myChart.destroy(); myChart = null; }
                return;
            }

            if (emptyMsg) emptyMsg.classList.add('hidden');
            if (canvasWrapper) canvasWrapper.classList.remove('hidden');

            // Sesuaikan tinggi canvas secara dinamis agar batang selalu proporsional dan tidak gemuk
            const dynamicHeight = Math.max(220, labels.length * 48 + 40);
            canvasWrapper.style.height = dynamicHeight + 'px';

            if (myChart) {
                myChart.destroy();
            }

            myChart = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Cover Buku',
                            data: covers,
                            backgroundColor: '#106c38',
                            borderRadius: 6,
                            borderSkipped: false,
                            maxBarThickness: 24,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8,
                        },
                        {
                            label: 'Ringkasan Buku',
                            data: ringkasan,
                            backgroundColor: '#F9C311',
                            borderRadius: 6,
                            borderSkipped: false,
                            maxBarThickness: 24,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8,
                        }
                    ]
                },
                options: {
                    indexAxis: 'y', // Horizontal Bar Chart: Rata, sejajar, dan proporsional
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Inter', size: 12, weight: '700' },
                            bodyFont: { family: 'Inter', size: 11 },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.dataset.label + ': ' + context.parsed.x.toLocaleString('id-ID');
                                },
                                afterBody: function(items) {
                                    if (items.length > 1) {
                                        let total = 0;
                                        items.forEach(it => { total += it.parsed.x; });
                                        return '\n Total Kontribusi: ' + total.toLocaleString('id-ID');
                                    }
                                    return '';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true, // Ditumpuk agar total kontribusi terlihat jelas & tidak miring
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                font: { family: 'Inter', size: 11 },
                                color: '#94a3b8',
                                callback: function(val) {
                                    return Number.isInteger(val) ? val.toLocaleString('id-ID') : null;
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 12, weight: '600' },
                                color: '#334155',
                            }
                        }
                    }
                }
            });
        }

        // =========================================================
        // Custom Dropdown Logic
        // =========================================================
        let dropdownOpen = false;

        function toggleCustomDropdown() {
            dropdownOpen ? closeCustomDropdown() : openCustomDropdown();
        }

        function openCustomDropdown() {
            dropdownOpen = true;
            document.getElementById('dropdownPanel').classList.remove('hidden');
            document.getElementById('dropdownCaret').style.transform = 'rotate(180deg)';
            document.getElementById('dropdownTrigger').classList.add('border-[#106c38]', 'ring-2', 'ring-[#106c38]/15');
            // reset search
            document.getElementById('dropdownSearch').value = '';
            filterDropdownOptions('');
            setTimeout(() => document.getElementById('dropdownSearch').focus(), 50);
        }

        function closeCustomDropdown() {
            dropdownOpen = false;
            document.getElementById('dropdownPanel').classList.add('hidden');
            document.getElementById('dropdownCaret').style.transform = 'rotate(0deg)';
            document.getElementById('dropdownTrigger').classList.remove('border-[#106c38]', 'ring-2', 'ring-[#106c38]/15');
        }

        function selectDropdownOption(el) {
            const value = el.dataset.value;
            const labelText = el.dataset.label || el.textContent.trim();

            // Update trigger label
            document.getElementById('dropdownLabel').textContent = labelText;

            // Update active state semua opsi
            document.querySelectorAll('.dropdown-option').forEach(opt => {
                opt.classList.remove('active-option');
            });
            el.classList.add('active-option');

            // Update hidden select & trigger onChange
            const nativeSelect = document.getElementById('periodeSelect');
            nativeSelect.value = value;
            handlePeriodeChange(value);

            closeCustomDropdown();
        }

        function filterDropdownOptions(query) {
            const q = query.toLowerCase();
            document.querySelectorAll('.dropdown-option').forEach(opt => {
                const text = opt.textContent.toLowerCase();
                opt.style.display = text.includes(q) ? '' : 'none';
            });
        }

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('customDropdownWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeCustomDropdown();
            }
        });

        // Set active option awal
        document.querySelectorAll('.dropdown-option').forEach(opt => {
            if (opt.dataset.value === 'all') opt.classList.add('active-option');
        });

        // Handle Pergantian Periode Dropdown
        function handlePeriodeChange(selectedPeriod) {
            let activeList = [];
            let periodLabel = "Total Akumulasi";

            if (selectedPeriod === 'all') {
                activeList = allStats;
                periodLabel = "Total Akumulasi";
            } else if (monthlyData[selectedPeriod]) {
                activeList = monthlyData[selectedPeriod].users || [];
                periodLabel = monthlyData[selectedPeriod].label;
            }

            // Update Badge & Header Text
            document.getElementById('badgePeriodText').innerText = "Menampilkan: " + periodLabel;
            document.getElementById('chartSubText').innerText = "Perbandingan kontribusi untuk periode: " + periodLabel;
            document.getElementById('tableSubText').innerText = "Detail kontribusi untuk periode: " + periodLabel;

            // Recalculate summary cards
            const totalUser = activeList.length;
            const totalCover = activeList.reduce((acc, curr) => acc + (parseInt(curr.jumlah_cover) || 0), 0);
            const totalRingkasan = activeList.reduce((acc, curr) => acc + (parseInt(curr.jumlah_ringkasan) || 0), 0);
            const topUser = activeList.length > 0 ? activeList[0] : null;

            document.getElementById('cardTotalUser').innerText = totalUser.toLocaleString('id-ID');
            document.getElementById('cardTotalCover').innerText = totalCover.toLocaleString('id-ID');
            document.getElementById('cardTotalRingkasan').innerText = totalRingkasan.toLocaleString('id-ID');

            if (topUser) {
                document.getElementById('cardTopUser').innerText = topUser.username || '-';
                document.getElementById('cardTopSub').innerText = (topUser.jumlah_cover || 0) + " cover · " + (topUser.jumlah_ringkasan || 0) + " ringkasan";
            } else {
                document.getElementById('cardTopUser').innerText = '-';
                document.getElementById('cardTopSub').innerText = 'Belum ada data';
            }

            document.getElementById('tableRowCount').innerText = totalUser;

            // Update Table Body
            const tbody = document.getElementById('tableBody');
            const tableWrapper = document.getElementById('tableWrapper');
            const emptyState = document.getElementById('tableEmptyState');

            if (activeList.length === 0) {
                tableWrapper.classList.add('hidden');
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');
            } else {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
                tableWrapper.classList.remove('hidden');

                let rowsHtml = '';
                activeList.forEach((u, idx) => {
                    const rank = idx + 1;
                    const cCover = parseInt(u.jumlah_cover) || 0;
                    const cRingkasan = parseInt(u.jumlah_ringkasan) || 0;
                    const cTotal = cCover + cRingkasan;

                    let rankBadge = `<span class="text-xs text-slate-600 font-bold">${rank}</span>`;
                    if (rank === 1) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #d97706; color: #ffffff;" title="Peringkat 1">1</span>`;
                    else if (rank === 2) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #64748b; color: #ffffff;" title="Peringkat 2">2</span>`;
                    else if (rank === 3) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black shadow-sm" style="background-color: #b45309; color: #ffffff;" title="Peringkat 3">3</span>`;

                    const initial = (u.username ? u.username.charAt(0) : 'U').toUpperCase();

                    rowsHtml += `
                        <tr class="hover:bg-slate-50/70 transition group">
                            <td class="py-3 pr-3 text-center">${rankBadge}</td>
                            <td class="py-3 pr-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        ${initial}
                                    </div>
                                    <span class="font-bold text-slate-800 text-xs">${u.username || '-'}</span>
                                </div>
                            </td>
                            <td class="py-3 pr-3 hidden sm:table-cell">
                                <span class="text-xs text-slate-700 font-medium">${u.nama_lengkap || '-'}</span>
                            </td>
                            <td class="py-3 pr-3 hidden md:table-cell">
                                <span class="text-xs text-slate-500">${u.keterangan || '-'}</span>
                            </td>
                            <td class="py-3 pr-3 text-center">
                                <span class="inline-flex items-center justify-center gap-1 bg-emerald-50 text-emerald-700 font-bold text-xs px-2.5 py-1 rounded-lg min-w-[3rem]">
                                    ${cCover.toLocaleString('id-ID')}
                                </span>
                            </td>
                            <td class="py-3 pr-3 text-center">
                                <span class="inline-flex items-center justify-center gap-1 bg-amber-50 text-amber-700 font-bold text-xs px-2.5 py-1 rounded-lg min-w-[3rem]">
                                    ${cRingkasan.toLocaleString('id-ID')}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="inline-flex items-center justify-center font-black text-xs text-white bg-[#106c38] px-3 py-1 rounded-lg min-w-[3rem] shadow-xs">
                                    ${cTotal.toLocaleString('id-ID')}
                                </span>
                            </td>
                        </tr>
                    `;
                });
                tbody.innerHTML = rowsHtml;
            }

            // Update Chart
            const top10 = activeList.slice(0, 10);
            const chartLabels = top10.map(u => u.username || '-');
            const chartCovers = top10.map(u => parseInt(u.jumlah_cover) || 0);
            const chartRingkasan = top10.map(u => parseInt(u.jumlah_ringkasan) || 0);
            renderChart(chartLabels, chartCovers, chartRingkasan);
        }

        // Jalankan render chart awal
        document.addEventListener('DOMContentLoaded', function () {
            const chartLabels   = @json($chartLabels);
            const chartCovers   = @json($chartCovers);
            const chartRingkasan = @json($chartRingkasan);
            renderChart(chartLabels, chartCovers, chartRingkasan);
        });
    </script>
</body>
</html>
