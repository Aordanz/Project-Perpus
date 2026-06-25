<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Buku - Portal Admin OPAC USU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .admin-nav { background: #064e3b; border-bottom: 2px solid #eab308; }
        .text-usu-green { color: #064e3b; }
        .bg-usu-green { background-color: #064e3b; }
        .field-label { @apply block text-[11px] font-bold text-slate-500 mb-1; }
        .field-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .field-input:focus { border-color: #064e3b; }
        .item-row-existing { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem; position: relative; }
        .item-row-new { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.75rem; padding: 0.75rem; position: relative; padding-top: 1.75rem; }
        .section-card { background: white; border: 1px solid #f1f5f9; border-radius: 1.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .section-title { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 4px; margin-bottom: 0.75rem; }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="admin-nav py-4 px-6 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 hover:opacity-95 transition">
                    <img src="{{ asset('logousu.jpeg') }}" alt="Logo USU" class="h-10 w-auto bg-white rounded-full p-0.5 border border-yellow-400">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm tracking-wide uppercase">PORTAL ADMINISTRASI</span>
                        <span class="text-xs font-semibold text-yellow-300 tracking-wider">Perpustakaan Universitas Sumatera Utara</span>
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
                    <button type="submit" class="bg-red-600/90 hover:bg-red-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5 cursor-pointer border-none shadow-sm">
                        <i class="ph ph-sign-out text-base"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-6">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.index') }}" class="hover:text-usu-green transition font-semibold flex items-center gap-1">
                <i class="ph ph-layout text-base"></i> Dashboard
            </a>
            <i class="ph ph-caret-right text-xs text-slate-400"></i>
            <span class="text-slate-800 font-bold">Edit Buku</span>
        </div>

        <!-- Page Header -->
        <div class="section-card flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <!-- Cover Preview -->
                <div class="w-14 h-20 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400" id="cover-preview-wrap">
                    @if($book->cover_image)
                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover" id="cover-preview-img">
                    @else
                        <i class="ph ph-book text-2xl" id="cover-preview-icon"></i>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold text-[#064e3b] uppercase tracking-wider mb-1">Mengedit Buku</p>
                    <h1 class="text-xl font-black text-slate-800 leading-tight">{{ $book->title }}</h1>
                    <p class="text-sm text-slate-500 mt-0.5">oleh <span class="font-semibold text-slate-700">{{ $book->author }}</span></p>
                </div>
            </div>
            <a href="{{ route('admin.index') }}" class="flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
                <i class="ph ph-arrow-left text-base"></i> Kembali
            </a>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm">
                <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                <ul class="list-disc pl-4 space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT: Bibliographic Info -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <!-- Section: Informasi Utama -->
                    <div class="section-card space-y-4">
                        <div class="section-title"><i class="ph ph-book-open"></i> Informasi Utama</div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="field-input" placeholder="Judul buku...">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Pengarang <span class="text-red-500">*</span></label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="field-input" placeholder="Nama pengarang...">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">No. Panggil</label>
                                <input type="text" name="call_number" value="{{ old('call_number', $book->call_number) }}" class="field-input" placeholder="e.g. 005.74 ARI p">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">ISBN</label>
                                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="field-input" placeholder="e.g. 978-602-...">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Tahun Terbit</label>
                                <input type="number" name="publish_year" value="{{ old('publish_year', $book->publish_year) }}" class="field-input" placeholder="2024">
                            </div>
                            <div class="flex flex-col gap-1 col-span-2">
                                <label class="field-label">Penerbit</label>
                                <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="field-input" placeholder="Nama penerbit...">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Kota Terbit</label>
                                <input type="text" name="publication_city" value="{{ old('publication_city', $book->publication_city) }}" class="field-input" placeholder="e.g. Medan">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Edisi</label>
                                <input type="text" name="edition" value="{{ old('edition', $book->edition) }}" class="field-input" placeholder="e.g. Cet. 2">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Klasifikasi -->
                    <div class="section-card space-y-4">
                        <div class="section-title"><i class="ph ph-tag"></i> Klasifikasi & Karakteristik</div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Klasifikasi DDC</label>
                                <input type="text" name="classification" value="{{ old('classification', $book->classification) }}" class="field-input" placeholder="e.g. 005.133">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Golongan</label>
                                <input type="text" name="golongan" value="{{ old('golongan', $book->golongan) }}" class="field-input" placeholder="e.g. 000 - Karya Umum">
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Subyek Utama</label>
                            <input type="text" name="subject" value="{{ old('subject', $book->subject) }}" class="field-input" placeholder="e.g. Komputer & Pemrograman">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Bahasa</label>
                                <input type="text" name="language" value="{{ old('language', $book->language) }}" class="field-input" placeholder="Indonesia">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Jenis Koleksi</label>
                                <select name="type" class="field-input appearance-none cursor-pointer">
                                    @foreach(['buku' => 'Buku', 'jurnal' => 'Jurnal', 'majalah' => 'Majalah', 'skripsi' => 'Skripsi/Tesis'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('type', $book->type) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Deskripsi -->
                    <div class="section-card space-y-4">
                        <div class="section-title"><i class="ph ph-file-text"></i> Deskripsi & Catatan</div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Deskripsi Fisik</label>
                            <input type="text" name="physical_description" value="{{ old('physical_description', $book->physical_description) }}" class="field-input" placeholder="e.g. xxiv, 450 hlm.: ilus.; 23 cm.">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Catatan Umum</label>
                            <textarea name="general_note" rows="3" class="field-input resize-none" placeholder="Catatan tambahan...">{{ old('general_note', $book->general_note) }}</textarea>
                        </div>
                    </div>

                    <!-- Section: Eksemplar Fisik -->
                    <div class="section-card space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="section-title mb-0"><i class="ph ph-list-checks"></i> Eksemplar Fisik (Salinan)</div>
                            <button type="button" id="btn-add-new-item" class="text-[10px] bg-[#064e3b] hover:bg-green-900 text-white font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 cursor-pointer border-none">
                                <i class="ph ph-plus"></i> Tambah Eksemplar
                            </button>
                        </div>

                        <!-- Existing Items -->
                        <div id="existing-items-container" class="space-y-3">
                            @forelse($book->items as $item)
                                <div class="item-row-existing" id="item-row-{{ $item->barcode }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Salinan Barcode: <span class="font-mono text-slate-600">{{ $item->barcode }}</span></span>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-[10px] text-red-500 font-semibold hover:text-red-700">
                                            <input type="checkbox" name="delete_items[]" value="{{ $item->barcode }}" class="rounded border-red-300 text-red-500 focus:ring-red-500 w-3 h-3"
                                                onchange="toggleItemDeletion(this, 'item-row-{{ $item->barcode }}')">
                                            Hapus salinan ini
                                        </label>
                                    </div>
                                    <input type="hidden" name="items[{{ $item->barcode }}][barcode]" value="{{ $item->barcode }}">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[10px] font-bold text-slate-400">Lokasi Rak</label>
                                            <select name="items[{{ $item->barcode }}][location_id]" class="field-input appearance-none cursor-pointer text-xs">
                                                @foreach($locations as $loc)
                                                    <option value="{{ $loc->id }}" {{ $item->location_id == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[10px] font-bold text-slate-400">Status</label>
                                            <select name="items[{{ $item->barcode }}][status]" class="field-input appearance-none cursor-pointer text-xs">
                                                <option value="Tersedia" {{ $item->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="Dipinjam" {{ $item->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-slate-400 text-xs py-4">Belum ada salinan fisik terdaftar.</p>
                            @endforelse
                        </div>

                        <!-- New Items Container -->
                        <div id="new-items-container" class="space-y-3"></div>
                    </div>
                </div>

                <!-- RIGHT: Cover & Submit -->
                <div class="flex flex-col gap-6">

                    <!-- Cover Image Card -->
                    <div class="section-card flex flex-col gap-4 sticky top-24">
                        <div class="section-title"><i class="ph ph-image"></i> Sampul Buku</div>

                        <!-- Current Cover Preview -->
                        <div class="w-full aspect-[2/3] bg-slate-100 rounded-2xl border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative" id="cover-drop-area">
                            @if($book->cover_image)
                                <img src="{{ asset('covers/' . $book->cover_image) }}"
                                     alt="Cover Buku"
                                     class="w-full h-full object-cover"
                                     id="cover-large-preview">
                                <div class="absolute inset-0 bg-black/30 opacity-0 hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                                    Klik untuk ganti
                                </div>
                            @else
                                <div class="flex flex-col items-center text-slate-400 gap-2" id="cover-placeholder">
                                    <i class="ph ph-image text-5xl"></i>
                                    <span class="text-xs font-semibold">Belum ada sampul</span>
                                </div>
                                <img src="" alt="Preview" class="hidden w-full h-full object-cover" id="cover-large-preview">
                            @endif
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-[11px] font-bold text-slate-500">Ganti Gambar Sampul</label>
                            <input type="file" name="cover_image" id="cover-input" accept="image/*"
                                class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#064e3b] hover:file:bg-green-100 cursor-pointer w-full">
                            <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, GIF. Maks 2MB.<br>Kosongkan jika tidak ingin mengganti.</p>
                        </div>

                        @if($book->cover_image)
                            <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-xl p-3 border border-slate-200">
                                <i class="ph ph-check-circle text-green-600"></i>
                                <span>Sampul saat ini: <span class="font-mono text-slate-700 text-[10px]">{{ $book->cover_image }}</span></span>
                            </div>
                        @endif

                        <hr class="border-slate-100">

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-[#064e3b] to-[#106c38] hover:from-[#053c2e] hover:to-[#0b4d27] text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer shadow-md border-none">
                            <i class="ph ph-floppy-disk text-lg"></i>
                            <span>Simpan Perubahan</span>
                        </button>

                        <a href="{{ route('admin.index') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-4 rounded-xl transition flex items-center justify-center gap-1.5 text-sm">
                            <i class="ph ph-x text-base"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <footer class="bg-[#064e3b] text-slate-100 py-5 mt-10 border-t border-yellow-600/30 text-center text-xs font-medium">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; 2026 Universitas Sumatera Utara | OPAC Admin.</p>
            <p class="text-yellow-400">Universitas Sumatera Utara Library</p>
        </div>
    </footer>

    <script>
        // Live cover image preview
        document.getElementById('cover-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                const preview = document.getElementById('cover-large-preview');
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
                const placeholder = document.getElementById('cover-placeholder');
                if (placeholder) placeholder.classList.add('hidden');

                // Also update small header preview
                const headerImg = document.querySelector('#cover-preview-wrap img');
                const headerIcon = document.getElementById('cover-preview-icon');
                if (headerImg) { headerImg.src = ev.target.result; }
                else {
                    const wrap = document.getElementById('cover-preview-wrap');
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'w-full h-full object-cover';
                    if(headerIcon) headerIcon.remove();
                    wrap.appendChild(img);
                }
            };
            reader.readAsDataURL(file);
        });

        // Toggle item deletion: strike-through styling
        function toggleItemDeletion(checkbox, rowId) {
            const row = document.getElementById(rowId);
            if (!row) return;
            if (checkbox.checked) {
                row.classList.add('opacity-50');
                row.querySelectorAll('select').forEach(el => el.disabled = true);
            } else {
                row.classList.remove('opacity-50');
                row.querySelectorAll('select').forEach(el => el.disabled = false);
            }
        }

        // Add new item row dynamically
        let newItemIndex = 0;
        const locationOptions = `@foreach($locations as $loc)<option value="{{ $loc->id }}">{{ $loc->name }}</option>@endforeach`;

        document.getElementById('btn-add-new-item').addEventListener('click', () => {
            const container = document.getElementById('new-items-container');
            const idx = newItemIndex++;

            const row = document.createElement('div');
            row.className = 'item-row-new';
            row.innerHTML = `
                <button type="button" onclick="this.closest('.item-row-new').remove()"
                    class="absolute top-2 right-2 text-slate-400 hover:text-red-500 bg-transparent border-none cursor-pointer">
                    <i class="ph ph-x-circle text-base"></i>
                </button>
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-2">+ Eksemplar Baru</p>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-400">Barcode *</label>
                        <input type="text" name="new_items[${idx}][barcode]" placeholder="e.g. L009876"
                            class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-[#064e3b] bg-white">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-400">Status</label>
                        <select name="new_items[${idx}][status]"
                            class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-[#064e3b] appearance-none cursor-pointer bg-white">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-slate-400">Lokasi Rak *</label>
                    <select name="new_items[${idx}][location_id]"
                        class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-[#064e3b] appearance-none cursor-pointer bg-white">
                        ${locationOptions}
                    </select>
                </div>
            `;
            container.appendChild(row);
            row.querySelector('input[type="text"]').focus();
        });
    </script>
</body>
</html>
