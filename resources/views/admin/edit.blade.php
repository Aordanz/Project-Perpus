<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Buku - Portal Admin OPAC USU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .admin-nav { background: #106c38; border-bottom: 1px solid rgba(255, 255, 255, 0.15); }
        .text-usu-green { color: #106c38; }
        .bg-usu-green { background-color: #106c38; }
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
        .field-input:focus {
            border-color: #106c38;
            box-shadow: 0 0 0 2px rgba(16, 108, 56, 0.2);
        }
        .item-row-existing { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem; position: relative; }
        .item-row-new { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.75rem; padding: 0.75rem; position: relative; padding-top: 1.75rem; }
        .section-card { background: white; border: 1px solid #f1f5f9; border-radius: 1.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .section-title { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 4px; margin-bottom: 0.75rem; }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-6">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.koleksi-buku') }}" class="hover:text-usu-green transition font-semibold flex items-center gap-1">
                <i class="ph ph-books text-base"></i> Koleksi Buku
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
                    <p class="text-xs font-bold text-[#106c38] uppercase tracking-wider mb-1">Mengedit Buku</p>
                    <h1 class="text-xl font-black text-slate-800 leading-tight">{{ $book->title }}</h1>
                    <p class="text-sm text-slate-500 mt-0.5">oleh <span class="font-semibold text-slate-700">{{ $book->author }}</span></p>
                </div>
            </div>
            <a href="{{ route('admin.koleksi-buku') }}" class="flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
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

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Subyek Utama</label>
                                <input type="text" name="subject" value="{{ old('subject', $book->subject) }}" class="field-input" placeholder="e.g. Komputer & Pemrograman">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Spesifikasi Buku</label>
                                <div class="relative custom-select-container w-full">
                                    <button type="button" class="field-input flex items-center justify-between cursor-pointer pr-4 text-left w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all">
                                        <span class="custom-select-label">{{ old('category', $book->category) ?: 'Umum' }}</span>
                                        <i class="ph ph-caret-down text-slate-400 text-xs transition-transform duration-200"></i>
                                    </button>
                                    <input type="hidden" name="category" value="{{ old('category', $book->category) ?: 'Umum' }}">
                                    <div class="custom-select-menu hidden absolute left-0 mt-1.5 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-[1000] max-h-60 overflow-y-auto">
                                        @foreach(['Sains & Teknologi', 'Sosial & Humaniora', 'Kesehatan & Kedokteran', 'Agama', 'Umum'] as $cat)
                                            @php $isSelected = (old('category', $book->category) ?: 'Umum') == $cat; @endphp
                                            <button type="button" data-value="{{ $cat }}" class="custom-select-option w-full text-left px-5 py-3.5 text-xs transition flex items-center justify-between {{ $isSelected ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                <span>{{ $cat }}</span>
                                                <i class="ph ph-check text-xs select-active-check {{ $isSelected ? '' : 'hidden' }}"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Bahasa</label>
                                <input type="text" name="language" value="{{ old('language', $book->language) }}" class="field-input" placeholder="Indonesia">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Jenis Koleksi</label>
                                <div class="relative custom-select-container w-full">
                                    @php
                                        $jenisMap = ['buku' => 'Buku', 'jurnal' => 'Jurnal', 'majalah' => 'Majalah', 'skripsi' => 'Skripsi/Tesis'];
                                        $currentJenisVal = old('jenis', $book->jenis) ?: 'buku';
                                        $currentJenisLabel = $jenisMap[$currentJenisVal] ?? 'Buku';
                                    @endphp
                                    <button type="button" class="field-input flex items-center justify-between cursor-pointer pr-4 text-left w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all">
                                        <span class="custom-select-label">{{ $currentJenisLabel }}</span>
                                        <i class="ph ph-caret-down text-slate-400 text-xs transition-transform duration-200"></i>
                                    </button>
                                    <input type="hidden" name="jenis" value="{{ $currentJenisVal }}">
                                    <div class="custom-select-menu hidden absolute left-0 mt-1.5 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-[1000] max-h-60 overflow-y-auto">
                                        @foreach($jenisMap as $val => $label)
                                            @php $isSelected = $currentJenisVal == $val; @endphp
                                            <button type="button" data-value="{{ $val }}" class="custom-select-option w-full text-left px-5 py-3.5 text-xs transition flex items-center justify-between {{ $isSelected ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                <span>{{ $label }}</span>
                                                <i class="ph ph-check text-xs select-active-check {{ $isSelected ? '' : 'hidden' }}"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
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
                            <div class="section-title mb-0"><i class="ph ph-list-checks"></i> Eksemplar Fisik</div>
                            <button type="button" id="btn-add-new-item" class="text-[10px] bg-[#106c38] hover:bg-green-800 text-white font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 cursor-pointer border-none">
                                <i class="ph ph-plus"></i> Tambah Eksemplar
                            </button>
                        </div>

                        <!-- Existing Items -->
                        <div id="existing-items-container" class="space-y-3">
                            @forelse($book->items as $item)
                                <div class="item-row-existing" id="item-row-{{ $item->barcode }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Eksemplar Barcode: <span class="font-mono text-slate-600">{{ $item->barcode }}</span></span>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-[10px] text-red-500 font-semibold hover:text-red-700">
                                            <input type="checkbox" name="delete_items[]" value="{{ $item->barcode }}" class="rounded border-red-300 text-red-500 focus:ring-red-500 w-3 h-3"
                                                onchange="toggleItemDeletion(this, 'item-row-{{ $item->barcode }}')">
                                            Hapus eksemplar ini
                                        </label>
                                    </div>
                                    <input type="hidden" name="items[{{ $item->barcode }}][barcode]" value="{{ $item->barcode }}">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[10px] font-bold text-slate-400">Tipe</label>
                                            <div class="relative custom-select-container w-full">
                                                @php
                                                    $typeVal = $item->type ?: 'STD';
                                                    $typeLabel = $typeVal == 'KPS' ? 'KPS (Koleksi Pinjem Singkat)' : 'STD (Standart)';
                                                @endphp
                                                <button type="button" class="field-input flex items-center justify-between cursor-pointer pr-4 text-left w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all">
                                                    <span class="custom-select-label text-xs font-semibold">{{ $typeLabel }}</span>
                                                    <i class="ph ph-caret-down text-slate-400 text-xs transition-transform duration-200"></i>
                                                </button>
                                                <input type="hidden" name="items[{{ $item->barcode }}][type]" value="{{ $typeVal }}">
                                                <div class="custom-select-menu hidden absolute left-0 mt-1.5 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-[1000] max-h-40 overflow-y-auto">
                                                    <button type="button" data-value="STD" class="custom-select-option w-full text-left px-5 py-3.5 text-xs transition flex items-center justify-between {{ $typeVal == 'STD' ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                        <span>STD (Standart)</span>
                                                        <i class="ph ph-check text-xs select-active-check {{ $typeVal == 'STD' ? '' : 'hidden' }}"></i>
                                                    </button>
                                                    <button type="button" data-value="KPS" class="custom-select-option w-full text-left px-5 py-3.5 text-xs transition flex items-center justify-between {{ $typeVal == 'KPS' ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                        <span>KPS (Koleksi Pinjam Singkat)</span>
                                                        <i class="ph ph-check text-xs select-active-check {{ $typeVal == 'KPS' ? '' : 'hidden' }}"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[10px] font-bold text-slate-400">Lokasi Rak</label>
                                            <div class="relative custom-select-container w-full">
                                                @php
                                                    $locVal = $item->location_id;
                                                    $selectedLoc = $locations->firstWhere('id', $locVal);
                                                    $locLabel = $selectedLoc ? $selectedLoc->name : 'Pilih Lokasi';
                                                @endphp
                                                <button type="button" class="field-input flex items-center justify-between cursor-pointer pr-4 text-left w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all">
                                                    <span class="custom-select-label text-xs font-semibold">{{ $locLabel }}</span>
                                                    <i class="ph ph-caret-down text-slate-400 text-xs transition-transform duration-200"></i>
                                                </button>
                                                <input type="hidden" name="items[{{ $item->barcode }}][location_id]" value="{{ $locVal }}">
                                                <div class="custom-select-menu hidden absolute left-0 mt-1.5 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-[1000] max-h-40 overflow-y-auto">
                                                    @foreach($locations as $loc)
                                                        @php $isSelected = $locVal == $loc->id; @endphp
                                                        <button type="button" data-value="{{ $loc->id }}" class="custom-select-option w-full text-left px-5 py-3.5 text-xs transition flex items-center justify-between {{ $isSelected ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                                                            <span>{{ $loc->name }}</span>
                                                            <i class="ph ph-check text-xs select-active-check {{ $isSelected ? '' : 'hidden' }}"></i>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-slate-400 text-xs py-4">Belum ada eksemplar fisik terdaftar.</p>
                            @endforelse
                        </div>

                        <!-- New Items Container -->
                        <div id="new-items-container" class="space-y-3"></div>
                    </div>
                </div>

                <!-- RIGHT: Cover & Submit -->
                <div class="flex flex-col gap-6">

                    <!-- Cover Image Card -->
                    <div class="section-card flex flex-col gap-4">
                        <div class="section-title"><i class="ph ph-image"></i> Sampul Buku</div>

                        <input type="hidden" name="delete_cover" id="delete-cover-input" value="0">

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
                                class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#106c38] hover:file:bg-green-100 cursor-pointer w-full">
                            <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, GIF. Maks 2MB.<br>Kosongkan jika tidak ingin mengganti.</p>
                        </div>

                        @if($book->cover_image)
                            <button type="button" id="btn-delete-cover" class="bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold py-2 px-3 rounded-xl border border-red-200 transition flex items-center justify-center gap-1 cursor-pointer w-full">
                                <i class="ph ph-trash"></i> Hapus Sampul Saat Ini
                            </button>
                            <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-xl p-3 border border-slate-200">
                                <i class="ph ph-check-circle text-green-600"></i>
                                <span>Sampul saat ini: <span class="font-mono text-slate-700 text-[10px]">{{ $book->cover_image }}</span></span>
                            </div>
                        @endif

                        <!-- Additional Images Section -->
                        <hr class="border-slate-100">
                        <div class="section-title text-xs"><i class="ph ph-images"></i> Gambar Tambahan</div>

                        @if($book->images && $book->images->count() > 0)
                            <div class="grid grid-cols-3 gap-2 my-2" id="additional-images-grid">
                                @foreach($book->images as $img)
                                    <div class="relative group aspect-square rounded-xl border border-slate-200 overflow-hidden bg-slate-50 existing-image-item" id="additional-image-{{ $img->id }}">
                                        <img src="{{ asset('covers/' . $img->image_path) }}" class="w-full h-full object-cover">
                                        <button type="button" onclick="deleteAdditionalImage({{ $img->id }})" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center text-white text-[9px] font-bold cursor-pointer gap-1 border-none w-full h-full">
                                            <i class="ph ph-trash text-lg"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-[10px] text-slate-400 my-2 text-center" id="no-additional-images-text">Belum ada gambar tambahan.</p>
                        @endif

                        <div class="flex flex-col gap-1">
                            <label class="text-[11px] font-bold text-slate-500">Tambah Gambar Tambahan (Maks 3)</label>
                            <input type="file" name="additional_images[]" id="additional-images-input" multiple accept="image/*"
                                class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-[#106c38] hover:file:bg-green-100 cursor-pointer w-full"
                                {{ !$book->cover_image ? 'disabled' : '' }}>
                            
                            <!-- Preview Bubbles for new additional images -->
                            <div id="additional-image-bubbles-container" class="flex flex-wrap gap-2 mt-2 empty:hidden"></div>
                            
                            @if(!$book->cover_image)
                                <p class="text-[10px] text-red-500 font-semibold mt-1" id="additional-images-warning">
                                    Unggah sampul default terlebih dahulu.
                                </p>
                            @else
                                <p class="text-[10px] text-slate-400 mt-1" id="additional-images-warning">Bisa memilih lebih dari 1 gambar sekaligus (Maksimal total 3 gambar tambahan).</p>
                            @endif
                        </div>

                        <!-- PDF/E-Book Section -->
                        <!-- <hr class="border-slate-100">
                        <div class="section-title text-xs"><i class="ph ph-file-pdf"></i> E-Book (PDF, Opsional)</div>

                        <div class="flex flex-col gap-1">
                            <label class="text-[11px] font-bold text-slate-500">File E-Book (PDF)</label>
                            <input type="file" name="pdf_file" accept="application/pdf"
                                class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#106c38] hover:file:bg-green-100 cursor-pointer w-full">
                            <p class="text-[10px] text-slate-400 mt-1">Unggah berkas PDF untuk e-book ini. Kosongkan jika tidak ingin mengganti.</p>
                        </div>

                        @if($book->pdf_file)
                            <div class="flex items-center justify-between text-xs text-slate-500 bg-slate-50 rounded-xl p-3 border border-slate-200">
                                <div class="flex items-center gap-2 overflow-hidden">
                                    <i class="ph ph-file-pdf text-red-600 text-lg flex-shrink-0"></i>
                                    <span class="truncate">E-Book saat ini: <a href="{{ asset('ebooks/' . $book->pdf_file) }}" target="_blank" class="font-mono text-[#106c38] hover:underline text-[10px]">{{ $book->pdf_file }}</a></span>
                                </div>
                                <label class="flex items-center gap-1 cursor-pointer text-red-600 hover:text-red-800 font-bold select-none text-[10px] flex-shrink-0">
                                    <input type="checkbox" name="delete_pdf" value="1" class="rounded text-red-500 focus:ring-red-500 w-3.5 h-3.5"> Hapus File
                                </label>
                            </div>
                        @endif -->

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-[#106c38] hover:bg-green-800 text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer shadow-md border-none">
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

        <!-- Custom Toast Notification Container -->
        <div id="toast-container" class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-3 pointer-events-none items-center"></div>

    </main>

            </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p>&copy; 2026 Universitas Sumatera Utara | OPAC Admin.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Custom Toast Function
        function showToast(message, type = 'error') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) return;
            const toast = document.createElement('div');
            toast.className = `max-w-xs w-full bg-white border ${type === 'error' ? 'border-rose-200' : 'border-green-200'} rounded-2xl shadow-xl flex items-center p-4 gap-3 transform transition-all duration-300 -translate-y-full opacity-0 pointer-events-auto`;
            
            const icon = type === 'error' 
                ? '<div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center flex-shrink-0"><i class="ph ph-warning-circle text-xl"></i></div>'
                : '<div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0"><i class="ph ph-check-circle text-xl"></i></div>';
            
            toast.innerHTML = `
                ${icon}
                <div class="flex-grow">
                    <p class="text-sm font-semibold text-slate-800">${type === 'error' ? 'Peringatan' : 'Berhasil'}</p>
                    <p class="text-xs text-slate-500 leading-snug">${message}</p>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600 bg-transparent border-none p-0 transition focus:outline-none cursor-pointer" onclick="this.parentElement.remove()">
                    <i class="ph ph-x text-lg"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('-translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0');
            });

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.classList.remove('translate-y-0');
                toast.classList.add('-translate-y-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

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

                // Enable additional images input if disabled
                const addInput = document.getElementById('additional-images-input');
                if (addInput) {
                    addInput.removeAttribute('disabled');
                }
                const addWarning = document.getElementById('additional-images-warning');
                if (addWarning) {
                    addWarning.innerText = 'Bisa memilih lebih dari 1 gambar sekaligus.';
                    addWarning.className = 'text-[10px] text-slate-400 mt-1';
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

        document.getElementById('btn-add-new-item').addEventListener('click', () => {
            const container = document.getElementById('new-items-container');
            const idx = newItemIndex++;

            // Build location options for custom select
            let locationOptions = '';
            let firstLocId = '';
            let firstLocName = '';
            @foreach($locations as $index => $loc)
                @if($index == 0)
                    firstLocId = '{{ $loc->id }}';
                    firstLocName = '{{ $loc->name }}';
                @endif
                locationOptions += `
                    <button type="button" data-value="{{ $loc->id }}" class="custom-select-option w-full text-left px-3 py-2 text-[11px] transition flex items-center justify-between text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]">
                        <span>{{ $loc->name }}</span>
                        <i class="ph ph-check text-[10px] select-active-check hidden"></i>
                    </button>
                `;
            @endforeach

            const row = document.createElement('div');
            row.className = 'item-row-new p-4 bg-slate-50 border border-slate-200 rounded-2xl relative pt-8 mt-3';
            row.innerHTML = `
                <button type="button" onclick="this.closest('.item-row-new').remove()"
                    class="absolute top-2 right-2 text-slate-400 hover:text-red-500 bg-transparent border-none cursor-pointer">
                    <i class="ph ph-x-circle text-base"></i>
                </button>
                <p class="text-[10px] font-bold text-[#106c38] uppercase tracking-wider mb-2">+ Eksemplar Baru</p>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="flex flex-col gap-1 col-span-1">
                        <label class="text-[10px] font-bold text-slate-400">Barcode *</label>
                        <input type="text" name="new_items[${idx}][barcode]" placeholder="e.g. L009876"
                            class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs focus:border-[#106c38] bg-white">
                    </div>
                    <div class="flex flex-col gap-1 col-span-1">
                        <label class="text-[10px] font-bold text-slate-400">Tipe *</label>
                        <div class="relative custom-select-container w-full">
                            <button type="button" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs flex items-center justify-between cursor-pointer w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all bg-white text-left">
                                <span class="custom-select-label">STD (Standart)</span>
                                <i class="ph ph-caret-down text-slate-400 text-[10px] transition-transform duration-200"></i>
                            </button>
                            <input type="hidden" name="new_items[${idx}][type]" value="STD">
                            <div class="custom-select-menu hidden absolute left-0 mt-1 w-full bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-[1000] max-h-40 overflow-y-auto">
                                <button type="button" data-value="STD" class="custom-select-option w-full text-left px-3 py-2 text-[11px] transition flex items-center justify-between text-[#106c38] font-bold bg-green-50/50">
                                    <span>STD (Standart)</span>
                                    <i class="ph ph-check text-[10px] select-active-check"></i>
                                </button>
                                <button type="button" data-value="KPS" class="custom-select-option w-full text-left px-3 py-2 text-[11px] transition flex items-center justify-between text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]">
                                    <span>KPS (Koleksi Pinjam Singkat)</span>
                                    <i class="ph ph-check text-[10px] select-active-check hidden"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-bold text-slate-400">Lokasi Rak *</label>
                    <div class="relative custom-select-container w-full">
                        <button type="button" class="px-2 py-1.5 border border-slate-200 rounded-lg outline-none text-xs flex items-center justify-between cursor-pointer w-full custom-select-trigger focus:border-[#106c38] focus:ring-2 focus:ring-[#106c38]/20 transition-all bg-white text-left">
                            <span class="custom-select-label">${firstLocName}</span>
                            <i class="ph ph-caret-down text-slate-400 text-[10px] transition-transform duration-200"></i>
                        </button>
                        <input type="hidden" name="new_items[${idx}][location_id]" value="${firstLocId}">
                        <div class="custom-select-menu hidden absolute left-0 mt-1 w-full bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-[1000] max-h-40 overflow-y-auto">
                            ${locationOptions}
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(row);
            if (window.initCustomSelects) {
                window.initCustomSelects(row);
            }
            row.querySelector('input[type="text"]').focus();
        });

        // Custom Confirm Modal Logic
        let confirmCallback = null;

        window.showCustomConfirm = function(message, callback) {
            const modal = document.getElementById('confirm-modal');
            const card = document.getElementById('confirm-modal-card');
            const msgEl = document.getElementById('confirm-modal-message');
            
            if (!modal || !card || !msgEl) return;
            
            msgEl.innerText = message;
            confirmCallback = callback;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        window.hideCustomConfirm = function() {
            const modal = document.getElementById('confirm-modal');
            const card = document.getElementById('confirm-modal-card');
            
            if (!modal || !card) return;
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                confirmCallback = null;
            }, 200);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cancelBtn = document.getElementById('confirm-modal-cancel');
            const confirmBtn = document.getElementById('confirm-modal-confirm');
            
            if (cancelBtn) cancelBtn.addEventListener('click', hideCustomConfirm);
            if (confirmBtn) {
                confirmBtn.addEventListener('click', () => {
                    if (confirmCallback) confirmCallback();
                    hideCustomConfirm();
                });
            }

            // Custom Select UI Handler
            const selectContainers = document.querySelectorAll('.custom-select-container');
            selectContainers.forEach(container => {
                const trigger = container.querySelector('.custom-select-trigger');
                const menu = container.querySelector('.custom-select-menu');
                const options = container.querySelectorAll('.custom-select-option');
                const hiddenInput = container.querySelector('input[type="hidden"]');
                const label = container.querySelector('.custom-select-label');
                const caret = container.querySelector('.ph-caret-down');
                
                if (!trigger || !menu) return;
                
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Close other select menus
                    document.querySelectorAll('.custom-select-menu').forEach(m => {
                        if (m !== menu) {
                            m.classList.add('hidden');
                            const c = m.parentElement.querySelector('.ph-caret-down');
                            if (c) c.classList.remove('rotate-180');
                        }
                    });
                    menu.classList.toggle('hidden');
                    if (caret) caret.classList.toggle('rotate-180');
                });
                
                options.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = opt.getAttribute('data-value');
                        const text = opt.querySelector('span').textContent.trim();
                        
                        if (label) label.textContent = text;
                        if (hiddenInput) {
                            hiddenInput.value = val;
                            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        
                        options.forEach(o => {
                            const check = o.querySelector('.select-active-check');
                            if (o === opt) {
                                o.classList.remove('text-slate-600', 'font-semibold');
                                o.classList.add('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                if (check) check.classList.remove('hidden');
                            } else {
                                o.classList.remove('text-[#106c38]', 'font-bold', 'bg-green-50/50');
                                o.classList.add('text-slate-600', 'font-semibold');
                                if (check) check.classList.add('hidden');
                            }
                        });
                        
                        menu.classList.add('hidden');
                        if (caret) caret.classList.remove('rotate-180');
                    });
                });
            });
            
            document.addEventListener('click', () => {
                document.querySelectorAll('.custom-select-menu').forEach(m => {
                    m.classList.add('hidden');
                    const c = m.parentElement.querySelector('.ph-caret-down');
                    if (c) c.classList.remove('rotate-180');
                });
            });
        });

        // Cover deletion logic
        const btnDeleteCover = document.getElementById('btn-delete-cover');
        const deleteCoverInput = document.getElementById('delete-cover-input');
        if (btnDeleteCover && deleteCoverInput) {
            btnDeleteCover.addEventListener('click', () => {
                showCustomConfirm('Apakah Anda yakin ingin menghapus sampul buku ini?', () => {
                    deleteCoverInput.value = '1';
                    
                    const preview = document.getElementById('cover-large-preview');
                    if (preview) {
                        preview.src = '';
                        preview.classList.add('hidden');
                    }
                    const placeholder = document.getElementById('cover-placeholder');
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                    }
                    
                    const currentCoverWrap = btnDeleteCover.nextElementSibling;
                    if (currentCoverWrap) {
                        currentCoverWrap.remove();
                    }
                    
                    btnDeleteCover.classList.add('hidden');
                    
                    const addInput = document.getElementById('additional-images-input');
                    if (addInput) {
                        addInput.setAttribute('disabled', 'true');
                    }
                    const addWarning = document.getElementById('additional-images-warning');
                    if (addWarning) {
                        addWarning.innerText = 'Unggah sampul default terlebih dahulu.';
                        addWarning.className = 'text-[10px] text-red-500 font-semibold mt-1';
                    }
                });
            });
        }

        // Reset delete_cover if new file is selected
        document.getElementById('cover-input').addEventListener('change', () => {
            if (deleteCoverInput) {
                deleteCoverInput.value = '0';
            }
            if (btnDeleteCover) {
                btnDeleteCover.classList.add('hidden');
            }
        });

        // Handle new additional images preview bubbles (Max 3 total)
        const addImagesInput = document.getElementById('additional-images-input');
        const addBubblesContainer = document.getElementById('additional-image-bubbles-container');
        let selectedAddFiles = [];

        let existingImagesCount = {{ $book->images ? $book->images->count() : 0 }};

        function getMaxNewAllowed() {
            return Math.max(0, 3 - existingImagesCount);
        }

        if (addImagesInput && addBubblesContainer) {
            addImagesInput.addEventListener('change', function(e) {
                const newFiles = Array.from(e.target.files);
                const maxAllowed = getMaxNewAllowed();
                let overLimit = false;
                
                for (let file of newFiles) {
                    if (selectedAddFiles.length < maxAllowed) {
                        if (!selectedAddFiles.some(f => f.name === file.name && f.size === file.size)) {
                            selectedAddFiles.push(file);
                        }
                    } else {
                        overLimit = true;
                    }
                }
                if (overLimit) {
                    showToast('Total gambar tambahan tidak boleh melebihi 3 foto.', 'error');
                }
                updateAddBubblesUI();
                syncAddInputFiles();
            });
        }

        window.removeAddFile = function(index) {
            selectedAddFiles.splice(index, 1);
            updateAddBubblesUI();
            syncAddInputFiles();
        };

        window.deleteAdditionalImage = function(id) {
            showCustomConfirm('Apakah Anda yakin ingin menghapus gambar tambahan ini?', () => {
                const url = "{{ route('admin.books.delete-image', ['id' => ':id']) }}".replace(':id', id);
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const imgEl = document.getElementById(`additional-image-${id}`);
                        if (imgEl) {
                            imgEl.remove();
                        }
                        
                        existingImagesCount--;
                        
                        // Check if container is empty
                        const container = document.getElementById('additional-images-grid');
                        if (container && container.querySelectorAll('.existing-image-item').length === 0) {
                            container.outerHTML = `<p class="text-[10px] text-slate-400 my-2 text-center" id="no-additional-images-text">Belum ada gambar tambahan.</p>`;
                        }
                        
                        // Enable inputs/warnings
                        const addWarning = document.getElementById('additional-images-warning');
                        if (addWarning) {
                            addWarning.innerText = 'Bisa memilih lebih dari 1 gambar sekaligus (Maksimal total 3 gambar tambahan).';
                            addWarning.className = 'text-[10px] text-slate-400 mt-1';
                        }
                        
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message || 'Gagal menghapus gambar.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus gambar.', 'error');
                });
            });
        };

        function updateAddBubblesUI() {
            addBubblesContainer.innerHTML = '';
            selectedAddFiles.forEach((file, index) => {
                const bubble = document.createElement('div');
                bubble.className = 'flex items-center gap-1.5 bg-green-50 border border-green-200 text-[#106c38] px-2 py-1 rounded-lg text-[10px] font-semibold mt-2';
                
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
                    <span title="${file.name}">${displayTitle}</span>
                    <button type="button" onclick="removeAddFile(${index})" class="ml-1 text-green-700 hover:text-red-500 bg-transparent border-none p-0 cursor-pointer flex items-center justify-center transition">
                        <i class="ph ph-x-circle text-[14px]"></i>
                    </button>
                `;
                addBubblesContainer.appendChild(bubble);
            });
        }

        function syncAddInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedAddFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            addImagesInput.files = dataTransfer.files;
        }
    </script>

    <!-- Custom Confirm Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-[10000] hidden flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="hideCustomConfirm()"></div>
        
        <!-- Modal Content Card -->
        <div class="relative bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 transform transition-all scale-95 opacity-0 duration-200" id="confirm-modal-card">
            <div class="flex flex-col items-center text-center">
                <!-- Icon -->
                <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mb-4">
                    <i class="ph ph-warning-circle text-3xl"></i>
                </div>
                
                <!-- Title -->
                <h3 class="text-base font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
                
                <!-- Message -->
                <p id="confirm-modal-message" class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                
                <!-- Buttons -->
                <div class="flex items-center gap-3 w-full">
                    <button type="button" id="confirm-modal-cancel" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition text-xs border-none cursor-pointer">
                        Batal
                    </button>
                    <button type="button" id="confirm-modal-confirm" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-xl transition text-xs border-none cursor-pointer shadow-md shadow-red-200">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
