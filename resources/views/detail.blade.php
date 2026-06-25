<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} - OPAC USU Library</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8fafc;
        }
        body, input, select, button, textarea {
            font-family: 'Inter', sans-serif !important;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .cover-glow {
            box-shadow: 0 20px 40px -15px rgba(16, 108, 56, 0.15), 0 15px 25px -10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    @include('partials.navbar')

    <!-- Main Content Area -->
    @php
        $getBigCategory = function($subj) {
            $lower = strtolower(trim($subj));
            
            // Agama
            if (str_contains($lower, 'religion') || str_contains($lower, 'islam') || str_contains($lower, 'faith') || str_contains($lower, 'agama')) {
                return 'Agama';
            }
            
            // Kesehatan & Kedokteran
            if (
                str_contains($lower, 'medicine') || 
                str_contains($lower, 'nursing') || 
                str_contains($lower, 'public health') || 
                str_contains($lower, 'pharmacy') || 
                str_contains($lower, 'dentistry') ||
                str_contains($lower, 'kedokteran') ||
                str_contains($lower, 'keperawatan') ||
                str_contains($lower, 'kesehatan') ||
                str_contains($lower, 'farmasi')
            ) {
                return 'Kesehatan & Kedokteran';
            }
            
            // Sains & Teknologi
            if (
                str_contains($lower, 'engineering') || 
                str_contains($lower, 'chemical') || 
                str_contains($lower, 'mathematics') || 
                str_contains($lower, 'biology') || 
                str_contains($lower, 'computer') || 
                str_contains($lower, 'forestry') || 
                str_contains($lower, 'agriculture') ||
                str_contains($lower, 'teknik') ||
                str_contains($lower, 'matematika') ||
                str_contains($lower, 'biologi') ||
                str_contains($lower, 'komputer') ||
                str_contains($lower, 'kehutanan') ||
                str_contains($lower, 'pertanian')
            ) {
                return 'Sains & Teknologi';
            }
            
            // Sosial & Humaniora
            if (
                str_contains($lower, 'social') || 
                str_contains($lower, 'economics') || 
                str_contains($lower, 'management') || 
                str_contains($lower, 'law') || 
                str_contains($lower, 'wisdom') ||
                str_contains($lower, 'ekonomi') ||
                str_contains($lower, 'manajemen') ||
                str_contains($lower, 'hukum') ||
                str_contains($lower, 'sosial') ||
                str_contains($lower, 'kearifan')
            ) {
                return 'Sosial & Humaniora';
            }
            
            return 'Umum';
        };

        $dbSubject = $book->category ?: ($book->subject ?: 'General');
        $bigCategoryName = $getBigCategory($dbSubject);

        $totalCopies = $book->items->count();
        $availableCopies = $book->items->where('status', 'Tersedia')->count();
        $borrowedCopies = $totalCopies - $availableCopies;
    @endphp
    <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        
        <!-- Back button (Below Navbar) -->
        <div class="mb-6">
            <button onclick="history.back()" class="inline-flex items-center gap-2 text-[#106c38] hover:text-[#064e3b] transition text-sm font-bold bg-[#106c38]/5 hover:bg-[#106c38]/10 px-4 py-2 rounded-lg border border-[#106c38]/10 cursor-pointer">
                <i class="ph ph-arrow-left"></i> {{ __('Kembali') }}
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Side: Book Cover & Quick Status -->
            <div class="md:col-span-1 space-y-6">
                <!-- Book Cover Card -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col items-center shadow-sm">
                    <div class="w-48 aspect-[2/3] bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden cover-glow mb-6 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4">
                                <i class="ph ph-book-open text-6xl mb-3"></i>
                                <span class="text-xs font-bold text-center leading-normal">{{ __('NO COVER IMAGE') }}</span>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-[#106c38] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">
                            {{ strtoupper($book->type) }}
                        </span>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="w-full text-center py-4 border-t border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Ketersediaan Fisik') }}</span>
                        @if($availableCopies > 0)
                            <div class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 font-bold px-4 py-1.5 rounded-full border border-green-200/50 text-xs">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                {{ $availableCopies }} {{ __('dari') }} {{ $totalCopies }} {{ __('Salinan Tersedia') }}
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 font-bold px-4 py-1.5 rounded-full border border-red-200/50 text-xs">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                {{ __('Semua Salinan Dipinjam') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact / Help info -->
                <div class="bg-gradient-to-br from-[#064e3b] to-[#106c38] rounded-3xl p-6 text-white shadow-sm flex flex-col gap-3">
                    <i class="ph ph-info text-2xl text-green-200"></i>
                    <h4 class="font-bold text-sm">{{ __('Butuh bantuan mencari buku?') }}</h4>
                    <p class="text-xs text-green-100/80 leading-relaxed">
                        {{ __('Silakan hubungi pustakawan kami di meja informasi atau gunakan layanan pesan instan perpustakaan untuk memandu pencarian Anda di rak buku.') }}
                    </p>
                </div>
            </div>

            <!-- Right Side: Detailed Tables -->
            <div class="md:col-span-2 space-y-6">
                <!-- Book Title header -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                    <span class="inline-block bg-[#106c38]/5 text-[#106c38] text-[10px] font-bold px-3 py-1 rounded-full mb-3 tracking-wider uppercase">
                        {{ __($bigCategoryName) }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-800 leading-snug mb-3">{{ $book->title }}</h1>
                    <p class="text-sm font-semibold text-slate-500 flex items-center gap-1.5">
                        <i class="ph ph-user text-base text-slate-400"></i> {{ __('Oleh:') }} <span class="text-slate-800">{{ $book->author }}</span>
                    </p>
                </div>

                <!-- Table 1: Availability Table -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-emerald-50 text-[#106c38] rounded-xl flex items-center justify-center text-lg">
                            <i class="ph ph-list-checks"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">{{ __('Tabel Ketersediaan Buku') }}</h2>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                    <th class="px-5 py-4">{{ __('No. Barcode') }}</th>
                                    <th class="px-5 py-4">{{ __('No. Panggil') }}</th>
                                    <th class="px-5 py-4">{{ __('Lokasi Rak') }}</th>
                                    <th class="px-5 py-4 text-center">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
                                @forelse($book->items as $item)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="px-5 py-4 font-mono text-slate-500">{{ $item->barcode }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $item->call_number }}</td>
                                        <td class="px-5 py-4 text-slate-700">{{ $item->location->name }}</td>
                                        <td class="px-5 py-4 text-center">
                                            @if($item->status == 'Tersedia')
                                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 font-bold px-2.5 py-0.5 rounded-full border border-green-200/50 text-xs">
                                                    {{ $item->status }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 font-bold px-2.5 py-0.5 rounded-full border border-amber-200/50 text-xs">
                                                    {{ $item->status }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-6 text-center text-slate-400">
                                            {{ __('Belum ada salinan fisik terdaftar untuk koleksi ini.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table 2: Detailed Bibliographic Information Table -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-emerald-50 text-[#106c38] rounded-xl flex items-center justify-center text-lg">
                            <i class="ph ph-info"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">{{ __('Informasi Detail Bibliografi') }}</h2>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-100">
                        <table class="w-full text-left border-collapse">
                            <tbody class="divide-y divide-slate-100 text-sm font-medium">
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Judul') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->title ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('No Panggil') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->call_number ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Penerbit') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->publisher ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Kota') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->publication_city ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Edisi') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->edition ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Tahun') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->publish_year ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('ISBN') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->isbn ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Deskripsi') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->physical_description ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('No. Klasifikasi') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->classification ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Golongan') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->golongan ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Subyek') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->subject ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Bahasa') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->language ? __($book->language) : '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Jenis') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->type ? __(ucfirst($book->type)) : '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Catatan Umum') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $book->general_note ?: '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Jumlah Eksemplar') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $totalCopies }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Terpinjam') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $borrowedCopies }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-5 py-4 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[11px] w-1/3">{{ __('Tersedia') }}</td>
                                    <td class="px-5 py-4 text-slate-700">{{ $availableCopies }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    @include('partials.footer')

</body>
</html>
