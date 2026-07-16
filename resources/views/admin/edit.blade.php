<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Edit Cover Buku - Portal Admin OPAC USU</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .text-usu-green { color: #106c38; }
        .bg-usu-green { background-color: #106c38; }
        .field-label { display: block; font-size: 11px; font-weight: 750; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .field-value {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            font-size: 13px;
            color: #334155;
            font-weight: 600;
        }
        .section-card { background: white; border: 1px solid #e2e8f0; border-radius: 1.5rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .section-title { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 6px; margin-bottom: 1rem; }
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
            <a href="{{ route('admin.tambah-cover') }}" class="hover:text-usu-green transition font-semibold flex items-center gap-1">
                <i class="ph ph-image-plus text-base"></i> Tambah Cover
            </a>
            <i class="ph ph-caret-right text-xs text-slate-400"></i>
            <span class="text-slate-800 font-bold">Edit Cover Buku</span>
        </div>

        <!-- Page Header -->
        <div class="section-card flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <!-- Cover Preview -->
                <div class="w-14 h-20 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400">
                    @if($book->cover_image)
                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover" id="header-cover-preview">
                    @else
                        <i class="ph ph-book text-2xl" id="header-cover-placeholder"></i>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold text-[#106c38] uppercase tracking-wider mb-1">Manajemen Cover Buku</p>
                    <h1 class="text-xl font-black text-slate-800 leading-tight">{{ $book->title }}</h1>
                    <p class="text-sm text-slate-500 mt-0.5">oleh <span class="font-semibold text-slate-700">{{ $book->author }}</span></p>
                </div>
            </div>
            <a href="{{ route('admin.tambah-cover') }}" class="flex-shrink-0 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 decoration-none" style="text-decoration: none;">
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

        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-2xl flex gap-3 text-sm">
            <i class="ph ph-info text-2xl flex-shrink-0"></i>
            <div>
                <p class="font-bold text-xs mb-1">Mode Edit Cover</p>
                <p class="text-xs">Data bibliografi buku bersifat <i>Read-Only</i> (hanya baca). Anda hanya dapat mengubah atau mengunggah cover/sampul baru untuk buku ini.</p>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Keep all required original hidden inputs to pass validation rules in controller -->
            <input type="hidden" name="title" value="{{ $book->title }}">
            <input type="hidden" name="author" value="{{ $book->author }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT: Bibliographic Info (Read-Only) -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div class="section-card space-y-4">
                        <div class="section-title"><i class="ph ph-book-open"></i> Informasi Buku (Hanya Baca)</div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Judul Buku</label>
                            <div class="field-value">{{ $book->title ?: '-' }}</div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="field-label">Pengarang</label>
                            <div class="field-value">{{ $book->author ?: '-' }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">No. Panggil</label>
                                <div class="field-value">{{ $book->call_number ?: '-' }}</div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="field-label">ISBN</label>
                                <div class="field-value">{{ $book->isbn ?: '-' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="field-label">Tahun Terbit</label>
                                <div class="field-value">{{ $book->publish_year ?: '-' }}</div>
                            </div>
                            <div class="flex flex-col gap-1 col-span-2">
                                <label class="field-label">Penerbit</label>
                                <div class="field-value">{{ $book->publisher ?: '-' }}</div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1 mt-2">
                            <label class="field-label">Deskripsi / Catatan Fisik</label>
                            <div class="field-value">{{ $book->physical_description ?: '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Cover Upload & Submit -->
                <div class="flex flex-col gap-6">
                    <div class="section-card flex flex-col gap-4">
                        <div class="section-title"><i class="ph ph-image"></i> Gambar Sampul (Cover)</div>

                        <input type="hidden" name="delete_cover" id="delete-cover-input" value="0">

                        <!-- Current Cover Preview -->
                        <div class="w-full aspect-[2/3] bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative cursor-pointer hover:bg-slate-100 transition" id="cover-drop-area" onclick="document.getElementById('cover-input').click()">
                            @if($book->cover_image)
                                <img src="{{ asset('covers/' . $book->cover_image) }}"
                                     alt="Cover Buku"
                                     class="w-full h-full object-cover"
                                     id="cover-large-preview">
                                <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                                    Klik untuk mengganti gambar
                                </div>
                            @else
                                <div class="flex flex-col items-center text-slate-400 gap-2" id="cover-placeholder">
                                    <i class="ph ph-image text-5xl"></i>
                                    <span class="text-xs font-semibold">Belum ada cover</span>
                                    <span class="text-[10px] text-slate-400">Klik di sini untuk memilih gambar</span>
                                </div>
                                <img src="" alt="Preview" class="hidden w-full h-full object-cover" id="cover-large-preview">
                            @endif
                        </div>

                        <div class="flex flex-col gap-1.5 mt-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase">Pilih File Gambar</label>
                            <input type="file" name="cover_image" id="cover-input" accept="image/*"
                                class="text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-50 file:text-[#106c38] hover:file:bg-green-100 cursor-pointer w-full">
                            <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, GIF. Ukuran maksimum 20MB.</p>
                        </div>

                        @if($book->cover_image)
                            <button type="button" id="btn-delete-cover" class="bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold py-2.5 px-3 rounded-xl border border-rose-200 transition flex items-center justify-center gap-1 cursor-pointer w-full mt-2">
                                <i class="ph ph-trash"></i> Hapus Cover Saat Ini
                            </button>
                        @endif

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-[#106c38] hover:bg-green-800 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer shadow-md border-none mt-4 text-xs">
                            <i class="ph ph-floppy-disk text-lg"></i>
                            <span>Simpan Gambar Cover</span>
                        </button>

                        <a href="{{ route('admin.tambah-cover') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-1.5 text-xs decoration-none" style="text-decoration: none;">
                            <i class="ph ph-x text-base"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Custom Toast Notification Container -->
        <div id="toast-container" class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-3 pointer-events-none items-center"></div>

    </main>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Image Preview JS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const coverInput = document.getElementById('cover-input');
            const coverLargePreview = document.getElementById('cover-large-preview');
            const coverPlaceholder = document.getElementById('cover-placeholder');
            const btnDeleteCover = document.getElementById('btn-delete-cover');
            const deleteCoverInput = document.getElementById('delete-cover-input');
            const headerCoverPreview = document.getElementById('header-cover-preview');

            if (coverInput) {
                coverInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            if (coverLargePreview) {
                                coverLargePreview.src = event.target.result;
                                coverLargePreview.classList.remove('hidden');
                            }
                            if (coverPlaceholder) {
                                coverPlaceholder.classList.add('hidden');
                            }
                            if (deleteCoverInput) {
                                deleteCoverInput.value = '0';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (btnDeleteCover) {
                btnDeleteCover.addEventListener('click', () => {
                    if (confirm('Apakah Anda yakin ingin menghapus cover ini?')) {
                        if (coverLargePreview) {
                            coverLargePreview.src = '';
                            coverLargePreview.classList.add('hidden');
                        }
                        if (coverPlaceholder) {
                            coverPlaceholder.classList.remove('hidden');
                        }
                        if (deleteCoverInput) {
                            deleteCoverInput.value = '1';
                        }
                        if (coverInput) {
                            coverInput.value = ''; // Clear selected file
                        }
                        btnDeleteCover.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
