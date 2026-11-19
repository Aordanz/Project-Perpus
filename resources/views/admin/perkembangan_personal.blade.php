<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Perkembangan Saya - Portal Admin OPAC USU</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .bg-usu-green  { background-color: #106c38; }
        .text-usu-green { color: #106c38; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50 flex flex-col">

    {{-- Topbar & Sidebar Navigation --}}
    @include('partials.admin_sidebar')

    <div class="w-full flex-grow flex flex-col min-w-0">
        <main class="flex-grow p-3 sm:p-6 lg:p-8 pb-10 sm:pb-14 flex flex-col gap-4 sm:gap-6 max-w-7xl mx-auto w-full">

            {{-- Header Card --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-200/80 p-5 sm:p-7 rounded-2xl sm:rounded-3xl shadow-sm">
                <div class="flex items-start sm:items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
                        <i class="ph ph-chart-line-up"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-lg sm:text-2xl font-black text-slate-800 tracking-tight">Perkembangan Kontribusi Saya</h1>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-800 bg-emerald-100/80 px-2.5 py-0.5 rounded-full">
                                <i class="ph ph-user-check"></i> Akun Personal
                            </span>
                        </div>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">
                            Halo <strong>{{ $currentUser->nama_lengkap ?: $currentUser->username }}</strong> (@<span class="text-slate-700 font-semibold">{{ $currentUser->username }}</span>), berikut ringkasan kinerja kontribusi yang telah Anda lakukan pada katalog web.
                        </p>
                    </div>
                </div>

                {{-- User Badge Info --}}
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 self-stretch sm:self-auto justify-end">
                    <div class="bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 py-2 flex items-center gap-2 text-slate-600 text-xs font-semibold">
                        <i class="ph ph-identification-badge text-base text-[#106c38]"></i>
                        <span>Grup: <strong>{{ (int)($currentUser->idgroup ?? 0) === 212 ? 'Pustakawan (212)' : 'Group ' . ($currentUser->idgroup ?? '-') }}</strong></span>
                    </div>
                </div>
            </div>

            {{-- Summary Stat Cards (4 Grid) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                {{-- Total Cover --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Cover Buku</span>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="ph ph-image"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <h3 class="text-2xl sm:text-3xl font-black text-[#106c38]">{{ number_format($myTotalCover) }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Buku memiliki cover</p>
                    </div>
                </div>

                {{-- Total Ringkasan --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Ringkasan Buku</span>
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="ph ph-text-align-left"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <h3 class="text-2xl sm:text-3xl font-black text-amber-600">{{ number_format($myTotalRingkasan) }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Buku berisi ringkasan</p>
                    </div>
                </div>

                {{-- Total Keseluruhan --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Total Kontribusi</span>
                        <div class="w-8 h-8 rounded-xl bg-[#106c38] text-white flex items-center justify-center text-lg shadow-xs">
                            <i class="ph ph-check-circle"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800">{{ number_format($myTotalCover + $myTotalRingkasan) }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Akumulasi cover & ringkasan</p>
                    </div>
                </div>

                {{-- Status Akun --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Status Akun</span>
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="ph ph-shield-check"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 truncate" title="{{ $currentUser->keterangan ?: 'Pustakawan Web' }}">
                            {{ $currentUser->keterangan ?: 'Pustakawan Web' }}
                        </h3>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md mt-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Grafik Riwayat Bulanan Pribadi --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-lg font-bold">
                            <i class="ph ph-chart-bar"></i>
                        </div>
                        <div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-800">Grafik Riwayat Kontribusi Saya per Bulan</h2>
                            <p class="text-xs text-slate-500">Melihat tren penambahan cover dan ringkasan yang Anda buat dari waktu ke waktu.</p>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="flex items-center gap-3 text-xs self-start sm:self-auto bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/60">
                        <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#106c38]"></span> Cover Buku
                        </span>
                        <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#F9C311]"></span> Ringkasan Buku
                        </span>
                    </div>
                </div>

                @if(count($chartMonths) > 0)
                <div class="relative w-full" style="height: 280px;">
                    <canvas id="personalChart"></canvas>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl mb-3 text-slate-400">
                        <i class="ph ph-chart-bar"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Belum Ada Riwayat Kontribusi</p>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm text-center">
                        Anda belum menambahkan cover atau ringkasan buku. Mulai tambahkan melalui menu di samping!
                    </p>
                    <div class="flex items-center gap-2.5 mt-4">
                        <a href="{{ route('admin.tambah-cover') }}" class="inline-flex items-center gap-1.5 bg-[#106c38] text-white text-xs font-bold px-3.5 py-2 rounded-xl hover:bg-[#0b4d27] transition">
                            <i class="ph ph-image"></i> Tambah Cover
                        </a>
                        <a href="{{ route('admin.tambah-ringkasan') }}" class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl hover:bg-slate-200 transition">
                            <i class="ph ph-text-align-left"></i> Tambah Ringkasan
                        </a>
                    </div>
                </div>
                @endif
            </div>

            {{-- Tabel Riwayat 50 Buku Terakhir --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-[#106c38]/10 text-[#106c38] flex items-center justify-center text-lg font-bold">
                            <i class="ph ph-books"></i>
                        </div>
                        <div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-800">Aktivitas Buku Terakhir Anda</h2>
                            <p class="text-xs text-slate-500">Menampilkan hingga 50 buku yang paling baru Anda input atau perbarui.</p>
                        </div>
                    </div>
                    <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                        <span class="text-[#106c38] font-bold">{{ $recentBooks->count() }}</span> Buku Tercatat
                    </div>
                </div>

                @if($recentBooks->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                    <i class="ph ph-book-open text-4xl mb-2 text-slate-300"></i>
                    <p class="text-xs font-semibold text-slate-600">Belum ada buku yang tercatat pada akun ini</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Buku yang Anda tambahkan cover atau ringkasannya akan muncul di sini secara otomatis.</p>
                </div>
                @else
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 pr-3 text-center w-10">No</th>
                                <th class="py-3 pr-3">Buku</th>
                                <th class="py-3 pr-3 hidden sm:table-cell">No. Panggil</th>
                                <th class="py-3 pr-3 text-center">Status Cover</th>
                                <th class="py-3 pr-3 text-center">Status Ringkasan</th>
                                <th class="py-3 pr-3 hidden md:table-cell">Waktu Aktivitas</th>
                                <th class="py-3 text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @foreach($recentBooks as $idx => $b)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 pr-3 text-center text-slate-400 font-semibold">{{ $idx + 1 }}</td>
                                <td class="py-3 pr-3">
                                    <div class="flex items-center gap-3">
                                        @if($b->cover_image && file_exists(public_path('covers/' . $b->cover_image)))
                                            <img src="{{ asset('covers/' . $b->cover_image) }}" alt="Cover" class="w-9 h-12 object-cover rounded-md shadow-xs flex-shrink-0">
                                        @else
                                            <div class="w-9 h-12 rounded-md bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 flex-shrink-0">
                                                <i class="ph ph-image text-sm"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 line-clamp-1 hover:text-[#106c38] transition" title="{{ $b->judul_buku }}">
                                                {{ $b->judul_buku ?: 'Tanpa Judul' }}
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-mono mt-0.5">ID: {{ $b->idmaster }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pr-3 hidden sm:table-cell text-slate-600 font-mono text-[11px]">
                                    {{ $b->nopanggil ?: '-' }}
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    @if($b->cover_image)
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 font-bold text-[10px] px-2 py-0.5 rounded-full">
                                            <i class="ph ph-check"></i> Ada Cover
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-400 font-medium text-[10px] px-2 py-0.5 rounded-full">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 pr-3 text-center">
                                    @if(!empty($b->ringkasanbuku))
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 font-bold text-[10px] px-2 py-0.5 rounded-full">
                                            <i class="ph ph-check"></i> Ada Ringkasan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-400 font-medium text-[10px] px-2 py-0.5 rounded-full">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 pr-3 hidden md:table-cell text-slate-500 text-[11px]">
                                    {{ $b->tgl_aktivitas ? date('d M Y, H:i', strtotime($b->tgl_aktivitas)) : '-' }}
                                </td>
                                <td class="py-3 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.books.edit', $b->idmaster) }}" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition" title="Edit Cover Buku">
                                            <i class="ph ph-image text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.books.edit-ringkasan', $b->idmaster) }}" class="p-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 transition" title="Edit Ringkasan Buku">
                                            <i class="ph ph-text-align-left text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- Catatan Privasi & Metodologi --}}
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-4 flex gap-3 text-xs text-slate-600">
                <i class="ph ph-lock-key text-emerald-700 text-lg flex-shrink-0 mt-0.5"></i>
                <div class="leading-relaxed">
                    <p class="font-bold text-slate-800 mb-0.5">Informasi Akses & Privasi</p>
                    <p>Halaman ini merupakan <strong>dashboard personal Anda</strong>. Hanya pencapaian dan aktivitas dari akun Anda yang ditampilkan di sini. Kinerja akun pustakawan lain tidak ditampilkan demi privasi dan fokus kerja mandiri.</p>
                </div>
            </div>

        </main>
    </div>

    @if(count($chartMonths) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('personalChart');
            if (!ctx) return;

            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            label: 'Cover Buku',
                            data: @json($chartCovers),
                            backgroundColor: '#106c38',
                            borderRadius: 6,
                            maxBarThickness: 32,
                        },
                        {
                            label: 'Ringkasan Buku',
                            data: @json($chartRingkasan),
                            backgroundColor: '#F9C311',
                            borderRadius: 6,
                            maxBarThickness: 32,
                        }
                    ]
                },
                options: {
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
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: { family: 'Inter', size: 11 },
                                color: '#94a3b8',
                            },
                            grid: { color: '#f1f5f9' },
                        },
                        x: {
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#64748b',
                            },
                            grid: { display: false },
                        }
                    }
                }
            });
        });
    </script>
    @endif
</body>
</html>