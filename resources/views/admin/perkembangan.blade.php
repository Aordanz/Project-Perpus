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
                <div class="bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 flex items-center gap-2 text-amber-700 text-xs font-semibold flex-shrink-0">
                    <i class="ph ph-shield-check text-base"></i>
                    <span>Akses Terbatas: idgroup 3</span>
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
                        <h3 class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ $stats->count() }}</h3>
                    </div>
                </div>

                {{-- Total Cover --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#F9C311] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-image"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Cover Ditambah</span>
                        <h3 class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_cover')) }}</h3>
                    </div>
                </div>

                {{-- Total Ringkasan --}}
                <div class="bg-white border border-slate-200/80 rounded-xl sm:rounded-2xl p-3 sm:p-5 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3 shadow-sm">
                    <div class="text-[#F9C311] text-3xl sm:text-4xl flex-shrink-0">
                        <i class="ph ph-file-text"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider leading-tight">Total Ringkasan Ditambah</span>
                        <h3 class="text-xl sm:text-2xl font-black text-[#006633] mt-0.5">{{ number_format($stats->sum('jumlah_ringkasan')) }}</h3>
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
                        <h3 class="text-sm sm:text-base font-black text-[#006633] mt-0.5 truncate">
                            {{ $topUser ? $topUser['username'] : '-' }}
                        </h3>
                        @if($topUser)
                        <p class="text-[9px] text-slate-400 font-medium">
                            {{ $topUser['jumlah_cover'] }} cover · {{ $topUser['jumlah_ringkasan'] }} ringkasan
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bar Chart (Top 10) --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                        <i class="ph ph-chart-bar-horizontal"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Grafik Kontribusi (Top 10 User)</h2>
                        <p class="text-xs text-slate-500">Perbandingan jumlah cover dan ringkasan yang ditambahkan per akun.</p>
                    </div>
                </div>

                @if($stats->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <i class="ph ph-chart-bar text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data kontribusi.</p>
                </div>
                @else
                <div class="relative" style="height: 320px;">
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
                @endif
            </div>

            {{-- Data Table --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-xl">
                        <i class="ph ph-table"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Rincian Per Akun</h2>
                        <p class="text-xs text-slate-500">Detail jumlah kontribusi setiap user, diurutkan dari yang terbanyak.</p>
                    </div>
                </div>

                @if($stats->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                    <i class="ph ph-users text-5xl mb-3"></i>
                    <p class="text-sm font-medium">Belum ada data.</p>
                </div>
                @else
                <div class="overflow-x-auto">
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
                        <tbody class="divide-y divide-slate-50">
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
                @endif
            </div>

            {{-- Catatan Metodologi --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex gap-3 text-sm">
                <i class="ph ph-info text-blue-500 text-xl flex-shrink-0 mt-0.5"></i>
                <div class="text-blue-700 text-xs font-medium leading-relaxed">
                    <p class="font-bold mb-1">Catatan Metodologi</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li><strong>Cover:</strong> Dihitung berdasarkan buku yang memiliki cover di galeri, dikaitkan dengan <code class="bg-blue-100 px-1 rounded">iduser_input</code> pada tabel <code class="bg-blue-100 px-1 rounded">tblbuku</code> (user yang menginput/mengupdate data buku tersebut).</li>
                        <li><strong>Ringkasan:</strong> Dihitung dari buku yang memiliki kolom <code class="bg-blue-100 px-1 rounded">ringkasanbuku</code> terisi, dikaitkan dengan <code class="bg-blue-100 px-1 rounded">iduser_input</code> pada <code class="bg-blue-100 px-1 rounded">tblbuku</code>.</li>
                        <li>Data ini bersifat aproksimasi karena tabel galeri tidak menyimpan info siapa yang upload cover secara langsung.</li>
                    </ul>
                </div>
            </div>

        </main>

        @include('partials.admin_footer')
    </div>

    @if(!$stats->isEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('perkembanganChart').getContext('2d');

            const labels   = @json($chartLabels);
            const covers   = @json($chartCovers);
            const ringkasan = @json($chartRingkasan);

            new Chart(ctx, {
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
        });
    </script>
    @endif

</body>
</html>
