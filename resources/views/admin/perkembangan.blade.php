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
                    <p class="text-slate-500 text-[10px] sm:text-sm mt-1">Statistik kontribusi setiap pustakawan dalam menambahkan cover dan ringkasan buku.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 flex items-center gap-2 text-amber-700 text-xs font-semibold flex-shrink-0">
                        <i class="ph ph-shield-check text-base"></i>
                        <span>Akses: idgroup 3</span>
                    </div>
                </div>
            </div>

            {{-- Filter Periode --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-grow">
                    <div class="flex items-center gap-2 text-slate-700 font-bold text-xs uppercase tracking-wider shrink-0">
                        <i class="ph ph-calendar text-usu-green text-lg"></i>
                        <span>Pilih Periode:</span>
                    </div>
                    <select id="periodeSelect" onchange="handlePeriodeChange(this.value)" class="w-full sm:w-64 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#106c38] transition">
                        <option value="all">Semua Periode (Total Akumulasi)</option>
                        @foreach($monthlyData as $keyMonth => $mVal)
                            <option value="{{ $keyMonth }}">{{ $mVal['label'] }} ({{ count($mVal['users']) }} akun)</option>
                        @endforeach
                    </select>
                    <span id="badgeActivePeriod" class="text-[11px] font-semibold text-[#106c38] bg-green-50 px-2.5 py-1 rounded-lg border border-green-200/60 inline-flex items-center gap-1.5 w-fit">
                        <i class="ph ph-check-circle"></i>
                        <span id="badgePeriodText">Menampilkan Total Akumulasi</span>
                    </span>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-5">
                {{-- Total User Aktif --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#106c38] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-users-three"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total User Berkontribusi</span>
                        <h3 id="cardTotalUser" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ $stats->count() }}</h3>
                    </div>
                </div>

                {{-- Total Cover --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#F9C311] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-image"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Cover Ditambah</span>
                        <h3 id="cardTotalCover" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_cover')) }}</h3>
                    </div>
                </div>

                {{-- Total Ringkasan --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#F9C311] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-file-text"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Ringkasan Ditambah</span>
                        <h3 id="cardTotalRingkasan" class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_ringkasan')) }}</h3>
                    </div>
                </div>

                {{-- Top Kontributor --}}
                @php $topUser = $stats->first(); @endphp
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#106c38] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-trophy"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Top Kontributor</span>
                        <h3 id="cardTopUser" class="text-sm sm:text-base font-black text-[#006633] mt-0.5 truncate">
                            {{ $topUser ? $topUser['username'] : '-' }}
                        </h3>
                        <p id="cardTopSub" class="text-[9px] text-slate-400 font-medium">
                            @if($topUser)
                                {{ $topUser['jumlah_cover'] }} cover · {{ $topUser['jumlah_ringkasan'] }} ringkasan
                            @else
                                Belum ada data
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bar Chart (Top 10) --}}
            <div id="chartContainer" class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                        <i class="ph ph-chart-bar-horizontal"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Grafik Kontribusi (Top 10 User)</h2>
                        <p id="chartSubText" class="text-xs text-slate-500">Perbandingan jumlah cover dan ringkasan yang ditambahkan per akun.</p>
                    </div>
                </div>

                <div id="chartEmptyMessage" class="hidden flex-col items-center justify-center py-12 text-slate-400">
                    <i class="ph ph-chart-bar text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data kontribusi untuk periode ini.</p>
                </div>

                <div id="chartCanvasWrapper" class="relative" style="height: 320px;">
                    <canvas id="perkembanganChart"></canvas>
                </div>

                <div class="flex flex-wrap gap-4 mt-4 justify-center">
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-[#106c38] inline-block"></span>
                        Cover Buku
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-[#F9C311] inline-block"></span>
                        Ringkasan Buku
                    </div>
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
                            <p id="tableSubText" class="text-xs text-slate-500">Detail jumlah kontribusi setiap user, diurutkan dari yang terbanyak.</p>
                        </div>
                    </div>
                    <div class="text-xs font-semibold text-slate-400">
                        <span id="tableRowCount">{{ $stats->count() }}</span> Akun Ditemukan
                    </div>
                </div>

                <div id="tableEmptyState" class="{{ $stats->isEmpty() ? 'flex' : 'hidden' }} flex-col items-center justify-center py-10 text-slate-400">
                    <i class="ph ph-users text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data kontribusi untuk periode yang dipilih.</p>
                </div>

                <div id="tableWrapper" class="{{ $stats->isEmpty() ? 'hidden' : 'block' }} overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3">#</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3">Username</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3 hidden sm:table-cell">Nama Lengkap</th>
                                <th class="text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3 hidden md:table-cell">Jabatan</th>
                                <th class="text-center text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3">
                                    <span class="flex items-center justify-center gap-1"><i class="ph ph-image text-sm"></i> Cover</span>
                                </th>
                                <th class="text-center text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3 pr-3">
                                    <span class="flex items-center justify-center gap-1"><i class="ph ph-file-text text-sm"></i> Ringkasan</span>
                                </th>
                                <th class="text-center text-[10px] font-bold text-slate-500 uppercase tracking-wider pb-3">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-slate-50">
                            @foreach($stats as $index => $user)
                            @php
                                $total = $user['jumlah_cover'] + $user['jumlah_ringkasan'];
                                $maxTotal = ($stats->first()['jumlah_cover'] ?? 0) + ($stats->first()['jumlah_ringkasan'] ?? 0);
                                $pct = $maxTotal > 0 ? round(($total / $maxTotal) * 100) : 0;
                                $rank = $index + 1;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition group">
                                <td class="py-3 pr-3">
                                    @if($rank === 1)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-white text-[10px] font-black">1</span>
                                    @elseif($rank === 2)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-300 text-slate-700 text-[10px] font-black">2</span>
                                    @elseif($rank === 3)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-300 text-white text-[10px] font-black">3</span>
                                    @else
                                        <span class="text-xs text-slate-400 font-bold pl-1">{{ $rank }}</span>
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
                                    <span class="text-xs text-slate-700">{{ $user['nama_lengkap'] ?? '-' }}</span>
                                </td>
                                <td class="py-3 pr-3 hidden md:table-cell">
                                    <span class="text-xs text-slate-500">{{ $user['keterangan'] ?? '-' }}</span>
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    <span class="inline-flex items-center justify-center gap-1 bg-emerald-50 text-emerald-700 font-bold text-xs px-2 py-1 rounded-lg min-w-[2.5rem]">
                                        <i class="ph ph-image text-sm"></i>
                                        {{ number_format($user['jumlah_cover']) }}
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    <span class="inline-flex items-center justify-center gap-1 bg-amber-50 text-amber-700 font-bold text-xs px-2 py-1 rounded-lg min-w-[2.5rem]">
                                        <i class="ph ph-file-text text-sm"></i>
                                        {{ number_format($user['jumlah_ringkasan']) }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="font-black text-sm text-[#106c38]">{{ number_format($total) }}</span>
                                        <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-[#106c38] rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
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
                    <p class="font-bold mb-1">Catatan Metodologi & Ekspor</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li><strong>Filter Periode:</strong> Pilih bulan tertentu dari dropdown di atas untuk melihat kinerja akun pada bulan tersebut.</li>
                        <li><strong>Cover:</strong> Dihitung berdasarkan buku ber-cover di galeri buku.</li>
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

        // Inisialisasi Chart.js
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
                            backgroundColor: 'rgba(16, 108, 56, 0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Ringkasan Buku',
                            data: ringkasan,
                            backgroundColor: 'rgba(249, 195, 17, 0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.dataset.label + ': ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 11, weight: '600' },
                                color: '#475569',
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#94a3b8',
                                callback: function(val) {
                                    return val.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

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

                const maxTotal = (parseInt(activeList[0].jumlah_cover) || 0) + (parseInt(activeList[0].jumlah_ringkasan) || 0);

                let rowsHtml = '';
                activeList.forEach((u, idx) => {
                    const rank = idx + 1;
                    const cCover = parseInt(u.jumlah_cover) || 0;
                    const cRingkasan = parseInt(u.jumlah_ringkasan) || 0;
                    const cTotal = cCover + cRingkasan;
                    const pct = maxTotal > 0 ? Math.round((cTotal / maxTotal) * 100) : 0;

                    let rankBadge = `<span class="text-xs text-slate-400 font-bold pl-1">${rank}</span>`;
                    if (rank === 1) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-white text-[10px] font-black">1</span>`;
                    else if (rank === 2) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-300 text-slate-700 text-[10px] font-black">2</span>`;
                    else if (rank === 3) rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-300 text-white text-[10px] font-black">3</span>`;

                    const initial = (u.username ? u.username.charAt(0) : 'U').toUpperCase();

                    rowsHtml += `
                        <tr class="hover:bg-slate-50/70 transition group">
                            <td class="py-3 pr-3">${rankBadge}</td>
                            <td class="py-3 pr-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        ${initial}
                                    </div>
                                    <span class="font-bold text-slate-800 text-xs">${u.username || '-'}</span>
                                </div>
                            </td>
                            <td class="py-3 pr-3 hidden sm:table-cell">
                                <span class="text-xs text-slate-700">${u.nama_lengkap || '-'}</span>
                            </td>
                            <td class="py-3 pr-3 hidden md:table-cell">
                                <span class="text-xs text-slate-500">${u.keterangan || '-'}</span>
                            </td>
                            <td class="py-3 pr-3 text-center">
                                <span class="inline-flex items-center justify-center gap-1 bg-emerald-50 text-emerald-700 font-bold text-xs px-2 py-1 rounded-lg min-w-[2.5rem]">
                                    <i class="ph ph-image text-sm"></i>
                                    ${cCover.toLocaleString('id-ID')}
                                </span>
                            </td>
                            <td class="py-3 pr-3 text-center">
                                <span class="inline-flex items-center justify-center gap-1 bg-amber-50 text-amber-700 font-bold text-xs px-2 py-1 rounded-lg min-w-[2.5rem]">
                                    <i class="ph ph-file-text text-sm"></i>
                                    ${cRingkasan.toLocaleString('id-ID')}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-black text-sm text-[#106c38]">${cTotal.toLocaleString('id-ID')}</span>
                                    <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#106c38] rounded-full" style="width: ${pct}%"></div>
                                    </div>
                                </div>
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
