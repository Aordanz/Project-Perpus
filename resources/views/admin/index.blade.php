<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Admin - OPAC Universitas Sumatera Utara</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .admin-nav {
            background: #064e3b;
            border-bottom: 2px solid #eab308; /* Gold Accent border */
        }
        .btn-gold {
            background-color: #eab308;
            color: #064e3b;
            font-weight: 700;
        }
        .btn-gold:hover {
            background-color: #ca8a04;
        }
        .bg-usu-green {
            background-color: #064e3b;
        }
        .text-usu-green {
            color: #064e3b;
        }
        .border-usu-gold {
            border-color: #eab308;
        }
        .custom-card {
            transition: all 0.3s ease;
        }
        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }
        /* Custom scrollbar for form fields container */
        .form-container::-webkit-scrollbar {
            width: 6px;
        }
        .form-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .form-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Admin Navigation Bar -->
    <nav class="admin-nav py-4 px-6 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-95 transition">
                    <img src="{{ asset('logousu.jpeg') }}" alt="Logo USU" class="h-10 w-auto bg-white rounded-full p-0.5 border border-yellow-400">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm tracking-wide uppercase font-sans">PORTAL ADMINISTRASI</span>
                        <span class="text-xs font-semibold text-yellow-350 tracking-wider">Perpustakaan Universitas Sumatera Utara</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="font-bold text-xs">{{ Auth::user()->name ?? 'Admin Perpustakaan' }}</span>
                    <span class="text-[10px] text-yellow-400 font-semibold uppercase tracking-wider">Pustakawan</span>
                </div>
                
                <div class="w-px h-8 bg-white/20 hidden sm:block"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600/90 hover:bg-red-700 text-white font-bold text-xs px-4.5 py-2 rounded-xl transition flex items-center gap-1.5 cursor-pointer border-none shadow-sm">
                        <i class="ph ph-sign-out text-base"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Admin Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-8">
        
        <!-- Welcome Alert & Summary -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="ph ph-layout text-usu-green text-3xl"></i>
                    <span>Dashboard Inventaris Buku</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Selamat bekerja! Di sini Anda dapat memantau data sirkulasi dan menambahkan koleksi buku baru secara rinci.</p>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
                    <i class="ph ph-arrow-square-out text-base"></i>
                    <span>Lihat Halaman OPAC</span>
                </a>
            </div>
        </div>

        <!-- Success & Error Alerts -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm animate-pulse">
                <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                <div class="leading-normal">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                <div class="leading-normal">
                    <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- 4 Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat 1: Total Titles -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-green-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-green-50 text-[#106c38] rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-book-open"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Judul</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ number_format($totalBooks) }}</h3>
                </div>
            </div>

            <!-- Stat 2: Total Items (Copies) -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-emerald-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-barcode"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Salinan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ number_format($totalItems) }}</h3>
                </div>
            </div>

            <!-- Stat 3: Available Items -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-teal-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-check-square"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Tersedia</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5 text-green-700">{{ number_format($availableItems) }}</h3>
                </div>
            </div>

            <!-- Stat 4: Borrowed Items -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 relative overflow-hidden flex items-center gap-4 shadow-sm custom-card">
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-gradient-to-tl from-amber-50 to-transparent rounded-full blur-lg"></div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="ph ph-user-minus"></i>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Dipinjam</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-0.5 text-amber-700">{{ number_format($borrowedItems) }}</h3>
                </div>
            </div>
        </div>

        <!-- Split Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Book Database List (8 columns) -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                
                <!-- Book List Panel -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <i class="ph ph-database text-usu-green"></i>
                                <span>Daftar Koleksi Buku</span>
                            </h2>
                            <p class="text-slate-500 text-xs mt-0.5">Menampilkan seluruh buku yang ada di database beserta salinan fisiknya.</p>
                        </div>
                        
                        <!-- Search Box inside Card -->
                        <form action="{{ route('admin.index') }}" method="GET" class="w-full sm:w-64 relative flex items-center">
                            <div class="absolute left-3.5 text-slate-400">
                                <i class="ph ph-magnifying-glass text-lg"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis..." class="w-full pl-10 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-xs outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                            @if(request('search'))
                                <a href="{{ route('admin.index') }}" class="absolute right-3.5 text-slate-400 hover:text-slate-600">
                                    <i class="ph ph-x-circle text-base"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Books Table -->
                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                                    <th class="px-5 py-4">Informasi Buku</th>
                                    <th class="px-5 py-4">No. Panggil / ISBN</th>
                                    <th class="px-5 py-4 text-center">Salinan</th>
                                    <th class="px-5 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
                                @forelse($books as $book)
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <!-- Book Title & Cover/Author -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-14 bg-slate-100 rounded-md border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400">
                                                    @if($book->cover_image)
                                                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="ph ph-book text-xl"></i>
                                                    @endif
                                                </div>
                                                <div class="max-w-[200px]">
                                                    <a href="{{ route('books.show', $book->id) }}" target="_blank" class="block font-bold text-slate-800 hover:text-usu-green truncate" title="{{ $book->title }}">
                                                        {{ $book->title }}
                                                    </a>
                                                    <span class="block text-xs text-slate-400 truncate mt-0.5" title="{{ $book->author }}">{{ $book->author }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Call Number & ISBN -->
                                        <td class="px-5 py-4">
                                            <span class="block text-slate-700 text-xs font-mono font-semibold">{{ $book->call_number ?: '-' }}</span>
                                            <span class="block text-xs text-slate-400 font-medium mt-0.5">ISBN: {{ $book->isbn ?: '-' }}</span>
                                        </td>

                                        <!-- Copies Count & Available -->
                                        <td class="px-5 py-4 text-center">
                                            @php
                                                $copies = $book->items->count();
                                                $avail = $book->items->where('status', 'Tersedia')->count();
                                            @endphp
                                            <span class="inline-flex items-center gap-1 bg-[#106c38]/5 text-usu-green font-bold px-2.5 py-0.5 rounded-full text-xs">
                                                {{ $avail }} / {{ $copies }} Available
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-5 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('books.show', $book->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-green-50 text-slate-600 hover:text-usu-green flex items-center justify-center border border-slate-200/60 transition" title="Lihat Halaman Detail">
                                                    <i class="ph ph-eye text-base"></i>
                                                </a>

                                                <a href="{{ route('admin.books.edit', $book->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 flex items-center justify-center border border-slate-200/60 transition" title="Edit Buku">
                                                    <i class="ph ph-pencil-simple text-base"></i>
                                                </a>
                                                
                                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini beserta seluruh salinan fisiknya dari database?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-600 flex items-center justify-center border border-slate-200/60 transition cursor-pointer" title="Hapus Buku">
                                                        <i class="ph ph-trash text-base"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                                            <i class="ph ph-warning-circle text-4xl mb-2 text-slate-300"></i>
                                            <p class="text-sm font-semibold">Tidak ada data buku yang ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Custom Pagination Links -->
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>

            <!-- Right Side: Input New Book Form (5 columns) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6 sticky top-24">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="ph ph-plus-circle text-usu-green"></i>
                            <span>Tambah Koleksi Buku Baru</span>
                        </h2>
                        <p class="text-slate-500 text-xs mt-0.5">Isi seluruh informasi bibliografi secara rinci untuk menyimpannya ke database.</p>
                    </div>

                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <!-- Scrollable form inputs container -->
                        <div class="max-h-[58vh] overflow-y-auto pr-2 space-y-4 form-container">
                            
                            <!-- Field group: Informasi Utama -->
                            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-200/40 space-y-3">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <i class="ph ph-info"></i> Informasi Utama
                                </h4>
                                
                                <div class="flex flex-col gap-1">
                                    <label class="text-[11px] font-bold text-slate-500">Judul Buku <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Pemrograman Web Lanjut" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                </div>
                                
                                <div class="flex flex-col gap-1">
                                    <label class="text-[11px] font-bold text-slate-500">Pengarang <span class="text-red-500">*</span></label>
                                    <input type="text" name="author" value="{{ old('author') }}" required placeholder="e.g. Dr. H. Arialdi, M.Kom" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">No. Panggil</label>
                                        <input type="text" name="call_number" value="{{ old('call_number') }}" placeholder="e.g. 005.74 ARI p" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">ISBN</label>
                                        <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="e.g. 978-602-8512-30-4" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Tahun Terbit</label>
                                        <input type="number" name="publish_year" value="{{ old('publish_year', date('Y')) }}" placeholder="e.g. 2024" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1 col-span-2">
                                        <label class="text-[11px] font-bold text-slate-500">Penerbit</label>
                                        <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="e.g. Rajawali Pers" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Kota Terbit</label>
                                        <input type="text" name="publication_city" value="{{ old('publication_city') }}" placeholder="e.g. Medan" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Edisi</label>
                                        <input type="text" name="edition" value="{{ old('edition') }}" placeholder="e.g. Cet. 2 / Ed. Rev" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Field group: Klasifikasi & Kategori -->
                            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-200/40 space-y-3">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <i class="ph ph-tag"></i> Klasifikasi & Karakteristik
                                </h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Klasifikasi DDC</label>
                                        <input type="text" name="classification" value="{{ old('classification') }}" placeholder="e.g. 005.133" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Golongan</label>
                                        <input type="text" name="golongan" value="{{ old('golongan') }}" placeholder="e.g. 000 - Karya Umum" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Subyek Utama</label>
                                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="e.g. Komputer & Pemrograman" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Spesifikasi Buku</label>
                                        <select name="category" class="w-full px-2 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all appearance-none cursor-pointer">
                                            <option value="Sains & Teknologi" {{ old('category') == 'Sains & Teknologi' ? 'selected' : '' }}>Sains & Teknologi</option>
                                            <option value="Sosial & Humaniora" {{ old('category') == 'Sosial & Humaniora' ? 'selected' : '' }}>Sosial & Humaniora</option>
                                            <option value="Kesehatan & Kedokteran" {{ old('category') == 'Kesehatan & Kedokteran' ? 'selected' : '' }}>Kesehatan & Kedokteran</option>
                                            <option value="Agama" {{ old('category') == 'Agama' ? 'selected' : '' }}>Agama</option>
                                            <option value="Umum" {{ old('category', 'Umum') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Bahasa</label>
                                        <input type="text" name="language" value="{{ old('language', 'Indonesia') }}" placeholder="e.g. Indonesia" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-[11px] font-bold text-slate-500">Jenis Koleksi</label>
                                        <select name="jenis" class="w-full px-2 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all appearance-none cursor-pointer">
                                            <option value="buku" {{ old('jenis') == 'buku' ? 'selected' : '' }}>Buku</option>
                                            <option value="jurnal" {{ old('jenis') == 'jurnal' ? 'selected' : '' }}>Jurnal</option>
                                            <option value="majalah" {{ old('jenis') == 'majalah' ? 'selected' : '' }}>Majalah</option>
                                            <option value="skripsi" {{ old('jenis') == 'skripsi' ? 'selected' : '' }}>Skripsi/Tesis</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Field group: Deskripsi & Cover -->
                            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-200/40 space-y-3">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <i class="ph ph-file-text"></i> Deskripsi & Sampul
                                </h4>

                                <div class="flex flex-col gap-1">
                                    <label class="text-[11px] font-bold text-slate-500">Deskripsi Fisik</label>
                                    <input type="text" name="physical_description" value="{{ old('physical_description') }}" placeholder="e.g. xxiv, 450 hlm.: ilus.; 23 cm." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all">
                                </div>

                                <div class="flex flex-col gap-1">
                                    <label class="text-[11px] font-bold text-slate-500">Catatan Umum</label>
                                    <textarea name="general_note" rows="2" placeholder="Tuliskan catatan tambahan mengenai buku..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl outline-none text-xs focus:border-usu-green transition-all resize-none">{{ old('general_note') }}</textarea>
                                </div>

                                <div class="flex flex-col gap-1">
                                    <label class="text-[11px] font-bold text-slate-500">Unggah Gambar Sampul</label>
                                    <input type="file" name="cover_image" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-usu-green hover:file:bg-green-100 cursor-pointer w-full">
                                </div>
                            </div>

                            <!-- Field group: Data Eksemplar Fisik (Salinan) -->
                            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-200/40 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                        <i class="ph ph-list-checks"></i> Registrasi Salinan (Eksemplar)
                                    </h4>
                                    <button type="button" id="btn-add-item-row" class="text-[10px] bg-[#106c38] hover:bg-green-800 text-white font-bold px-2.5 py-1 rounded-lg flex items-center gap-1 cursor-pointer transition border-none shadow-sm">
                                        <i class="ph ph-plus"></i> Tambah
                                    </button>
                                </div>

                                <div id="items-rows-container" class="space-y-3">
                                    <!-- Row template (will be appended dynamically) -->
                                    <div class="item-row p-3 bg-white border border-slate-200 rounded-xl flex flex-col gap-2.5 relative">
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="flex flex-col gap-1 col-span-1">
                                                <label class="text-[10px] font-bold text-slate-400">Barcode <span class="text-red-500">*</span></label>
                                                <input type="text" name="items[0][barcode]" required placeholder="e.g. L0012903" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green">
                                            </div>
                                            <div class="flex flex-col gap-1 col-span-1">
                                                <label class="text-[10px] font-bold text-slate-400">Tipe <span class="text-red-500">*</span></label>
                                                <select name="items[0][type]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                                    <option value="STD">STD (Sirkulasi)</option>
                                                    <option value="KPS">KPS (Kampus)</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col gap-1 col-span-1">
                                                <label class="text-[10px] font-bold text-slate-400">Status <span class="text-red-500">*</span></label>
                                                <select name="items[0][status]" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                                    <option value="Tersedia">Tersedia</option>
                                                    <option value="Dipinjam">Dipinjam</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[10px] font-bold text-slate-400">Lokasi Rak <span class="text-red-500">*</span></label>
                                            <select name="items[0][location_id]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                                @foreach($locations as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-[#064e3b] to-[#106c38] hover:from-[#053c2e] hover:to-[#0b4d27] text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer shadow-md shadow-green-950/15 border-none mt-2">
                            <i class="ph ph-floppy-disk text-base"></i>
                            <span>Simpan Buku & Eksemplar</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-usu-green text-slate-100 py-6 mt-12 border-t border-yellow-450 flex-shrink-0 text-center text-xs font-medium">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
            <p class="text-yellow-400">Universitas Sumatera Utara Library</p>
        </div>
    </footer>

    <!-- Script to dynamically add book copy items rows in form -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnAddRow = document.getElementById('btn-add-item-row');
            const container = document.getElementById('items-rows-container');
            let rowIndex = 1;

            if (btnAddRow && container) {
                btnAddRow.addEventListener('click', () => {
                    const newRow = document.createElement('div');
                    newRow.className = 'item-row p-3 bg-white border border-slate-200 rounded-xl flex flex-col gap-2.5 relative pt-7';
                    
                    // Add delete row button
                    newRow.innerHTML = `
                        <button type="button" class="btn-remove-row absolute top-2 right-2 text-slate-400 hover:text-red-500 bg-transparent border-none cursor-pointer text-sm">
                            <i class="ph ph-trash-simple text-base"></i>
                        </button>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="flex flex-col gap-1 col-span-1">
                                <label class="text-[10px] font-bold text-slate-400">Barcode <span class="text-red-500">*</span></label>
                                <input type="text" name="items[${rowIndex}][barcode]" required placeholder="e.g. L0012903" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green">
                            </div>
                            <div class="flex flex-col gap-1 col-span-1">
                                <label class="text-[10px] font-bold text-slate-400">Tipe <span class="text-red-500">*</span></label>
                                <select name="items[${rowIndex}][type]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                    <option value="STD">STD (Sirkulasi)</option>
                                    <option value="KPS">KPS (Kampus)</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1 col-span-1">
                                <label class="text-[10px] font-bold text-slate-400">Status <span class="text-red-500">*</span></label>
                                <select name="items[${rowIndex}][status]" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-[#106c38] appearance-none cursor-pointer">
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Dipinjam">Dipinjam</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-bold text-slate-400">Lokasi Rak <span class="text-red-500">*</span></label>
                            <select name="items[${rowIndex}][location_id]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    `;

                    // Handle delete button click
                    const btnRemove = newRow.querySelector('.btn-remove-row');
                    btnRemove.addEventListener('click', () => {
                        newRow.remove();
                    });

                    container.appendChild(newRow);
                    rowIndex++;
                });
            }
        });
    </script>
</body>
</html>
