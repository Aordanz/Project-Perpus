<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koleksi Buku - Portal Admin OPAC USU</title>

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
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
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
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        
                <!-- Welcome Alert & Summary -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                            <i class="ph ph-books text-usu-green text-3xl"></i>
                            <span>Koleksi Buku</span>
                        </h1>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">Kelola dan pantau seluruh data buku yang ada pada database perpustakaan.</p>
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

                <!-- Content Area -->
                <div class="flex flex-col gap-8 items-start w-full">
                    
                    <!-- Book List Panel -->
                    <div id="koleksi-buku" class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6 w-full">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="ph ph-database text-usu-green"></i>
                                    <span>Daftar Koleksi Buku</span>
                                </h2>
                                <p class="text-slate-500 text-xs mt-0.5">Menampilkan seluruh buku yang ada di database beserta salinan fisiknya.</p>
                            </div>
                            
                            <!-- Search Box inside Card & Button -->
                            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                                <form id="admin-search-form" action="{{ route('admin.koleksi-buku') }}" method="GET" class="w-full sm:w-64 relative flex items-center">
                                    <div class="absolute left-3.5 text-slate-400">
                                        <i class="ph ph-magnifying-glass text-lg"></i>
                                    </div>
                                    <input type="text" name="search" id="admin-search-input" value="{{ request('search') }}" placeholder="Cari judul, penulis..." class="w-full pl-10 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-xs outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                                    <button type="button" id="clear-search-btn" class="absolute right-3.5 text-slate-400 hover:text-slate-600 {{ request('search') ? '' : 'hidden' }} bg-transparent border-none cursor-pointer p-0 flex items-center">
                                        <i class="ph ph-x-circle text-base"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="openAddBookModal()" class="w-full sm:w-auto bg-[#106c38] hover:bg-green-800 text-white font-bold py-2 px-4 rounded-xl transition flex items-center justify-center gap-2 text-xs shadow-sm border-none cursor-pointer whitespace-nowrap">
                                    <i class="ph ph-plus-circle text-base"></i> Tambah Koleksi Baru
                                </button>
                            </div>
                        </div>

                        <!-- Books Table Container -->
                        <div id="books-table-container" class="w-full">
                            @include('admin.partials.books_table')
                        </div>
                    </div>
                </div>

                <!-- Modal: Tambah Koleksi Buku Baru -->
                <div id="addBookModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddBookModal()"></div>
                    
                    <div class="bg-white rounded-3xl w-full max-w-2xl mx-4 max-h-[90vh] flex flex-col shadow-2xl relative z-10 transform scale-95 transition-transform duration-300 overflow-hidden" id="addBookModalContent">
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-5 border-b border-slate-100 bg-slate-50/50">
                            <div>
                                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <i class="ph ph-plus-circle text-usu-green"></i>
                                    <span>Tambah Koleksi Buku Baru</span>
                                </h2>
                                <p class="text-slate-500 text-[10px] sm:text-xs mt-0.5">Isi seluruh informasi bibliografi secara rinci untuk menyimpannya ke database.</p>
                            </div>
                            <button type="button" onclick="closeAddBookModal()" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 transition cursor-pointer border-none">
                                <i class="ph ph-x text-lg"></i>
                            </button>
                        </div>

                        <!-- Scrollable Modal Body -->
                        <div class="overflow-y-auto p-5">
                            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="space-y-4 form-container">
                                
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
                                            <label class="text-[11px] font-bold text-slate-500">Unggah Gambar (Maks 15, Utama & Tambahan)</label>
                                            <input type="file" name="images[]" id="images-input" multiple accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-usu-green hover:file:bg-green-100 cursor-pointer w-full">
                                            <p class="text-[10px] text-slate-400" id="images-helper">Gambar pertama yang Anda pilih akan menjadi sampul utama.</p>
                                            
                                            <!-- Bubble Container -->
                                            <div id="image-bubbles-container" class="flex flex-wrap gap-2 mt-2 empty:hidden"></div>
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
                                            <!-- Row template -->
                                            <div class="item-row p-3 bg-white border border-slate-200 rounded-xl flex flex-col gap-2.5 relative">
                                                <div class="grid grid-cols-2 gap-2">
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
                                    
                                    <!-- Submit Button -->
                                    <button type="submit" class="w-full bg-[#106c38] hover:bg-green-800 text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer shadow-md shadow-green-950/15 border-none mt-2">
                                        <i class="ph ph-floppy-disk text-base"></i>
                                        <span>Simpan Buku & Eksemplar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Modal Control Functions
        const addBookModal = document.getElementById('addBookModal');
        const addBookModalContent = document.getElementById('addBookModalContent');

        function openAddBookModal() {
            addBookModal.classList.remove('hidden');
            setTimeout(() => {
                addBookModal.classList.remove('opacity-0');
                addBookModalContent.classList.remove('scale-95');
                addBookModalContent.classList.add('scale-100');
            }, 10);
        }

        function closeAddBookModal() {
            addBookModal.classList.add('opacity-0');
            addBookModalContent.classList.remove('scale-100');
            addBookModalContent.classList.add('scale-95');
            setTimeout(() => {
                addBookModal.classList.add('hidden');
            }, 300);
        }

        // Open modal if there are validation errors
        @if ($errors->any())
            openAddBookModal();
        @endif

        document.addEventListener('DOMContentLoaded', () => {
            const btnAddRow = document.getElementById('btn-add-item-row');
            const container = document.getElementById('items-rows-container');
            let rowIndex = 1;

            if (btnAddRow && container) {
                btnAddRow.addEventListener('click', () => {
                    const newRow = document.createElement('div');
                    newRow.className = 'item-row p-3 bg-white border border-slate-200 rounded-xl flex flex-col gap-2.5 relative pt-7';
                    
                    newRow.innerHTML = `
                        <button type="button" class="btn-remove-row absolute top-2 right-2 text-slate-400 hover:text-red-500 bg-transparent border-none cursor-pointer text-sm">
                            <i class="ph ph-trash-simple text-base"></i>
                        </button>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col gap-1 col-span-1">
                                <label class="text-[10px] font-bold text-slate-400">Barcode <span class="text-red-500">*</span></label>
                                <input type="text" name="items[\${rowIndex}][barcode]" required placeholder="e.g. L0012903" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green">
                            </div>
                            <div class="flex flex-col gap-1 col-span-1">
                                <label class="text-[10px] font-bold text-slate-400">Tipe <span class="text-red-500">*</span></label>
                                <select name="items[\${rowIndex}][type]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                    <option value="STD">STD (Sirkulasi)</option>
                                    <option value="KPS">KPS (Kampus)</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-bold text-slate-400">Lokasi Rak <span class="text-red-500">*</span></label>
                            <select name="items[\${rowIndex}][location_id]" required class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-usu-green appearance-none cursor-pointer">
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    `;

                    const btnRemove = newRow.querySelector('.btn-remove-row');
                    btnRemove.addEventListener('click', () => {
                        newRow.remove();
                    });

                    container.appendChild(newRow);
                    rowIndex++;
                });
            }

            // Handle multiple image preview bubbles
            const imagesInput = document.getElementById('images-input');
            const bubblesContainer = document.getElementById('image-bubbles-container');
            let selectedFiles = [];

            if (imagesInput && bubblesContainer) {
                imagesInput.addEventListener('change', function(e) {
                    const newFiles = Array.from(e.target.files);
                    for (let file of newFiles) {
                        if (selectedFiles.length < 15 && !selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                            selectedFiles.push(file);
                        }
                    }
                    updateBubblesUI();
                    syncInputFiles();
                });
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateBubblesUI();
                syncInputFiles();
            };

            function updateBubblesUI() {
                bubblesContainer.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const bubble = document.createElement('div');
                    bubble.className = 'flex items-center gap-1.5 bg-green-50 border border-green-200 text-usu-green px-2 py-1 rounded-lg text-[10px] font-semibold';
                    
                    let displayTitle = file.name;
                    if (displayTitle.length > 20) {
                        const extIndex = displayTitle.lastIndexOf('.');
                        if (extIndex > -1) {
                            displayTitle = displayTitle.substring(0, 10) + '...' + displayTitle.substring(extIndex);
                        } else {
                            displayTitle = displayTitle.substring(0, 15) + '...';
                        }
                    }

                    bubble.innerHTML = `
                        <i class="ph ph-image"></i>
                        <span title="\${file.name}">\${index === 0 ? '[Sampul] ' : ''}\${displayTitle}</span>
                        <button type="button" onclick="removeFile(\${index})" class="ml-1 text-green-600 hover:text-red-500 bg-transparent border-none p-0 cursor-pointer flex items-center justify-center transition">
                            <i class="ph ph-x-circle text-[14px]"></i>
                        </button>
                    `;
                    bubblesContainer.appendChild(bubble);
                });
            }

            function syncInputFiles() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                imagesInput.files = dataTransfer.files;
            }

            // AJAX Live Search & Pagination for Books Table
            const searchForm = document.getElementById('admin-search-form');
            const searchInput = document.getElementById('admin-search-input');
            const clearBtn = document.getElementById('clear-search-btn');
            const tableContainer = document.getElementById('books-table-container');

            let debounceTimer;

            function performSearch(url = null) {
                if (!url) {
                    const query = encodeURIComponent(searchInput.value);
                    url = `${searchForm.action}?search=${query}`;
                }

                if (tableContainer) {
                    tableContainer.style.opacity = '0.5';
                    tableContainer.style.pointerEvents = 'none';
                }

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Search request failed');
                    return response.text();
                })
                .then(html => {
                    if (tableContainer) {
                        tableContainer.innerHTML = html;
                        tableContainer.style.opacity = '1';
                        tableContainer.style.pointerEvents = 'auto';
                    }

                    if (clearBtn) {
                        if (searchInput.value.trim().length > 0) {
                            clearBtn.classList.remove('hidden');
                        } else {
                            clearBtn.classList.add('hidden');
                        }
                    }

                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    if (tableContainer) {
                        tableContainer.style.opacity = '1';
                        tableContainer.style.pointerEvents = 'auto';
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    if (clearBtn) {
                        if (searchInput.value.trim().length > 0) {
                            clearBtn.classList.remove('hidden');
                        } else {
                            clearBtn.classList.add('hidden');
                        }
                    }

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        performSearch();
                    }, 300);
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    clearBtn.classList.add('hidden');
                    performSearch();
                });
            }

            if (searchForm) {
                searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    performSearch();
                });
            }

            if (tableContainer) {
                tableContainer.addEventListener('click', (e) => {
                    const anchor = e.target.closest('a');
                    if (anchor && anchor.href && anchor.href.includes('page=')) {
                        e.preventDefault();
                        performSearch(anchor.href);
                    }
                });
            }
        });
    </script>
</body>
</html>
