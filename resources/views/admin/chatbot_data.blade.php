<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Data AI Chatbot - Portal Admin OPAC USU</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }

        /* ── Layout utama: 2 kolom selalu, tanpa scroll body ── */
        .page-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 1.25rem;
            padding: 1.25rem;
            /* Isi tinggi sisa layar setelah topbar (56px) */
            height: calc(100vh - 56px);
            box-sizing: border-box;
            overflow: hidden;
        }

        /* Kolom kiri: kartu editor */
        .editor-col {
            display: flex;
            flex-direction: column;
            min-height: 0; /* penting agar flex child bisa scroll */
            overflow: hidden;
        }

        /* Kartu editor */
        .editor-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0,0,0,.05);
            overflow: hidden;
            flex: 1;
            min-height: 0;
        }

        #ai-textarea {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.775rem;
            line-height: 1.75;
            flex: 1;
            min-height: 0;
            resize: none;
            border: none;
            outline: none;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            color: #334155;
            width: 100%;
            box-sizing: border-box;
            transition: background 0.2s, color 0.2s;
        }
        /* State: terkunci */
        #ai-textarea.locked {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            user-select: none;
        }
        /* State: bisa edit */
        #ai-textarea:not(.locked):focus { background: #fff; }

        /* Banner terkunci di atas textarea */
        #lock-banner {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: #fef9c3;
            border-bottom: 1px solid #fde68a;
            font-size: 0.7rem;
            font-weight: 700;
            color: #92400e;
            flex-shrink: 0;
        }
        #lock-banner.hidden { display: none; }

        /* Tombol izinkan edit */
        #btn-unlock {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: #0f172a;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.5rem 1.1rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            transition: background 0.18s, transform 0.1s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        #btn-unlock:hover { background: #1e293b; }
        #btn-unlock:active { transform: scale(0.97); }

        /* Kolom kanan: panel-panel kecil, bisa scroll */
        .side-col {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            overflow-y: auto;
            min-height: 0;
            padding-right: 2px; /* agar scrollbar tidak terpotong */
        }
        .side-col::-webkit-scrollbar { width: 4px; }
        .side-col::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        .side-card {
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            padding: 1rem;
            flex-shrink: 0;
        }

        /* Topbar */
        .editor-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            background: #f8fafc;
            flex-shrink: 0;
        }

        /* Footer save bar */
        .editor-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.625rem 1.25rem;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
            flex-shrink: 0;
            gap: 0.75rem;
        }

        /* Alert area di atas editor */
        .alert-area {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 0;
        }
        .alert-area:empty { display: none; }

        /* Page header */
        .page-header {
            flex-shrink: 0;
            padding: 0.875rem 1.25rem 0;
        }

        /* Btn save */
        #btn-save {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: #106c38;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.5rem 1.1rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            transition: background 0.18s, transform 0.1s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        #btn-save:hover { background: #0b4d27; }
        #btn-save:active { transform: scale(0.97); }
        #btn-save:disabled { opacity: 0.4; cursor: not-allowed; }

        /* Btn hapus cache */
        .btn-clear-cache {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            background: #f59e0b;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.55rem 0.75rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: background 0.15s;
        }
        .btn-clear-cache:hover { background: #d97706; }

        /* Code snippet preview */
        .code-preview {
            background: #0f172a;
            border-radius: 0.625rem;
            padding: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            line-height: 1.7;
            color: #94a3b8;
            overflow-x: auto;
        }

        .char-ok   { color: #16a34a; }
        .char-warn { color: #d97706; }

        #empty-warning {
            font-size: 0.7rem;
            color: #b45309;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.5rem;
            padding: 0.45rem 0.75rem;
            display: none;
            align-items: center;
            gap: 0.4rem;
        }
    </style>
</head>
<body class="antialiased text-slate-800" style="overflow:hidden">

    @include('partials.admin_sidebar')

    <div class="page-layout">

        {{-- ═══════════════ KOLOM KIRI: EDITOR ═══════════════ --}}
        <div class="editor-col">

            {{-- Alert area --}}
            <div class="alert-area page-header">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2">
                        <i class="ph ph-check-circle text-base flex-shrink-0"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2">
                        <i class="ph ph-warning-circle text-base flex-shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            {{-- Editor card --}}
            <div class="editor-card {{ (session('success') || $errors->any()) ? 'mx-5 mb-5 mt-2' : 'm-5' }}">

                {{-- Topbar --}}
                <div class="editor-topbar">
                    <div class="flex items-center gap-2 min-w-0">
                        <i class="ph ph-file-text text-[#106c38] text-base flex-shrink-0"></i>
                        <span class="font-bold text-sm text-slate-700 truncate">data_perpus.txt</span>
                        <span class="text-[9px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full hidden sm:block flex-shrink-0">storage/app/private/</span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        @if($backupExists)
                            <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                                <i class="ph ph-shield-check text-xs"></i> Backup ada
                            </span>
                        @endif
                        <span id="char-counter" class="text-xs font-bold tabular-nums char-ok">{{ number_format($charCount) }} kar.</span>
                    </div>
                </div>

                {{-- Textarea --}}
                <form id="editor-form" action="{{ route('admin.chatbot-data.update') }}" method="POST" class="flex flex-col flex-1 min-h-0">
                    @csrf

                    {{-- Banner terkunci --}}
                    <div id="lock-banner">
                        <i class="ph ph-lock text-sm"></i>
                        <span>Mode baca — klik <b>Edit</b> di bawah untuk mulai mengedit.</span>
                    </div>

                    <textarea
                        id="ai-textarea"
                        name="content"
                        placeholder="Tulis data referensi perpustakaan di sini…"
                        spellcheck="false"
                        readonly
                        class="locked"
                    >{{ old('content', $content) }}</textarea>

                    {{-- Footer bar --}}
                    <div class="editor-footer">
                        <div class="flex items-center gap-3 min-w-0">
                            <span id="line-counter" class="text-[10px] font-semibold text-slate-400 tabular-nums">— baris</span>
                            <div id="empty-warning">
                                <i class="ph ph-warning text-xs"></i>
                                Tidak boleh kosong
                            </div>
                        </div>
                        {{-- Tombol unlock (default tampil) --}}
                        <button id="btn-unlock" type="button" onclick="enableEditMode()">
                            <i class="ph ph-pencil-simple text-sm"></i>
                            Edit
                        </button>
                        {{-- Tombol simpan (tersembunyi sampai mode edit aktif) --}}
                        <button id="btn-save" type="button" onclick="handleSaveClick()" style="display:none;">
                            <i class="ph ph-floppy-disk text-sm"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════════════ KOLOM KANAN: PANEL ═══════════════ --}}
        <div class="side-col" style="padding: 1.25rem 1.25rem 1.25rem 0;">

            {{-- Stats card --}}
            <div class="side-card">
                <div class="flex items-center gap-2 mb-2.5">
                    <i class="ph ph-chart-bar text-[#106c38] text-base"></i>
                    <span class="font-bold text-sm text-slate-700">Statistik File</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                        <p id="stat-chars" class="text-lg font-extrabold text-[#106c38] tabular-nums">{{ number_format($charCount) }}</p>
                        <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Karakter</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                        <p id="stat-lines" class="text-lg font-extrabold text-[#106c38] tabular-nums">—</p>
                        <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Baris</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                        <p id="stat-words" class="text-lg font-extrabold text-[#106c38] tabular-nums">—</p>
                        <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Kata</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                        <p id="stat-sections" class="text-lg font-extrabold text-[#106c38] tabular-nums">—</p>
                        <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Seksi</p>
                    </div>
                </div>
            </div>

            {{-- Status & Kontrol Chatbot Card --}}
            <div class="side-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-power text-[#106c38] text-base"></i>
                        <span class="font-bold text-sm text-slate-700">Status Chatbot</span>
                    </div>
                    @if($chatbotStatus === 'active')
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                        </span>
                    @else
                        <span class="text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                        </span>
                    @endif
                </div>
                <p class="text-[10px] text-slate-500 mb-3 leading-relaxed">
                    @if($chatbotStatus === 'active')
                        Layanan Chatbot AI saat ini <b class="text-emerald-600">aktif</b> dan dapat digunakan pengunjung website.
                    @else
                        Layanan Chatbot AI saat ini <b class="text-rose-600">nonaktif</b>. Widget disembunyikan dari pengunjung.
                    @endif
                </p>
                <form id="form-toggle-status" action="{{ route('admin.chatbot-status.toggle') }}" method="POST">
                    @csrf
                    @if($chatbotStatus === 'active')
                        <button type="button" id="btn-toggle-status" onclick="openModal('modal-toggle-status')" class="w-full flex items-center justify-center gap-2 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-200 cursor-pointer border-none shadow-sm">
                            <i class="ph ph-power text-sm"></i>
                            <span>Nonaktifkan Chatbot</span>
                        </button>
                    @else
                        <button type="button" id="btn-toggle-status" onclick="openModal('modal-toggle-status')" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-200 cursor-pointer border-none shadow-sm">
                            <i class="ph ph-power text-sm"></i>
                            <span>Aktifkan Chatbot</span>
                        </button>
                    @endif
                </form>
            </div>

            {{-- Cache Management --}}
            <div class="side-card">
                <div class="flex items-center gap-2 mb-2">
                    <i class="ph ph-database text-[#106c38] text-base"></i>
                    <span class="font-bold text-sm text-slate-700">Cache Chatbot</span>
                </div>
                <p class="text-[10px] text-slate-500 mb-3 leading-relaxed">
                    Setelah mengubah data, hapus cache agar chatbot memakai informasi terbaru untuk semua pertanyaan.
                </p>
                <div class="flex flex-col gap-1.5 mb-3">
                    <div class="flex items-start gap-1.5 text-[10px] text-slate-500">
                        <span class="text-amber-500 font-bold mt-px flex-shrink-0">⚠</span>
                        <span><b class="text-slate-600">Sebelum hapus:</b> Jawaban lama masih tampil.</span>
                    </div>
                    <div class="flex items-start gap-1.5 text-[10px] text-slate-500">
                        <span class="text-emerald-500 font-bold mt-px flex-shrink-0">✓</span>
                        <span><b class="text-slate-600">Setelah hapus:</b> AI baca data terbaru.</span>
                    </div>
                </div>
                <form id="form-clear-cache" action="{{ route('admin.chatbot-cache.clear') }}" method="POST">
                    @csrf
                    <button type="button" id="btn-clear-cache" onclick="openModal('modal-clear-cache')" class="btn-clear-cache">
                        <i class="ph ph-trash text-sm"></i>
                        <span id="btn-clear-cache-label">Hapus Semua Cache</span>
                    </button>
                </form>
            </div>

            {{-- Format Guide --}}
            <div class="side-card">
                <div class="flex items-center gap-2 mb-2.5">
                    <i class="ph ph-info text-[#106c38] text-base"></i>
                    <span class="font-bold text-sm text-slate-700">Panduan Format</span>
                </div>
                <ul class="text-[10px] text-slate-500 space-y-2.5 leading-relaxed">
                    <li class="flex items-start gap-1.5">
                        <span class="font-bold text-slate-500 flex-shrink-0">1.</span>
                        <span>Usahakan gunakan <code class="bg-slate-100 px-1 rounded font-mono text-[9px]">[NAMA SEKSI]</code> untuk mengelompokkan informasi.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="font-bold text-slate-500 flex-shrink-0">2.</span>
                        <span>Usahakan gunakan <code class="bg-slate-100 px-1 rounded font-mono text-[9px]">-</code> di awal baris untuk poin-poin.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="font-bold text-slate-500 flex-shrink-0">3.</span>
                        <span>Usahakan pisahkan antar seksi dengan <b>satu baris kosong</b>.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="font-bold text-slate-500 flex-shrink-0">4.</span>
                        <span>Usahakan tulis informasi <b>jelas & spesifik</b>, hindari singkatan tidak umum.</span>
                    </li>
                </ul>

                <div class="code-preview mt-3">
                    <span style="color:#4ade80">[WAKTU OPERASIONAL]</span><br>
                    <span>- Senin s/d Kamis: 08.00 - 20.00 WIB</span><br>
                    <span>- Jumat: 08.00 - 17.00 WIB</span><br>
                    <br>
                    <span style="color:#4ade80">[ATURAN DENDA]</span><br>
                    <span>- Denda: Rp 1.000/buku/hari</span>
                </div>
            </div>

            {{-- Header info --}}
            <div class="side-card" style="background: linear-gradient(135deg, #106c38 0%, #0b4d27 100%); border-color: #0b4d27;">
                <div class="flex items-start gap-2.5">
                    <i class="ph ph-robot text-white text-2xl flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold text-white text-sm">Data AI Chatbot</p>
                        <p class="text-green-200 text-[10px] mt-0.5 leading-relaxed">Edit informasi perpustakaan yang digunakan AI sebagai referensi jawaban. Perubahan aktif langsung setelah disimpan.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══ MODAL: Konfirmasi Hapus Cache ═══ --}}
    <div id="modal-clear-cache" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <div class="modal-icon" style="background:#fef3c7;">
                <i class="ph ph-trash" style="color:#d97706;font-size:1.6rem;"></i>
            </div>
            <h3 class="modal-title">Hapus Semua Cache?</h3>
            <p class="modal-desc">Semua jawaban chatbot yang tersimpan akan dihapus. Chatbot akan sedikit lebih lambat sementara sambil mengisi cache baru.</p>
            <div class="modal-actions">
                <button class="modal-btn-cancel" onclick="closeModal('modal-clear-cache')">Batal</button>
                <button class="modal-btn-confirm amber" onclick="doSubmitClearCache()">Ya, Hapus Cache</button>
            </div>
        </div>
    </div>

    {{-- ═══ MODAL: Konfirmasi Simpan — cache sudah dihapus ═══ --}}
    <div id="modal-save-safe" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <div class="modal-icon" style="background:#dcfce7;">
                <i class="ph ph-check-circle" style="color:#16a34a;font-size:1.6rem;"></i>
            </div>
            <h3 class="modal-title">Simpan Perubahan?</h3>
            <p class="modal-desc">Cache chatbot sudah dihapus di sesi ini. Data terbaru akan langsung digunakan oleh AI setelah disimpan.</p>
            <div class="modal-actions">
                <button class="modal-btn-cancel" onclick="closeModal('modal-save-safe')">Batal</button>
                <button class="modal-btn-confirm green" onclick="doSubmitSave()">Simpan Sekarang</button>
            </div>
        </div>
    </div>

    {{-- ═══ MODAL: Peringatan Simpan — cache BELUM dihapus ═══ --}}
    <div id="modal-save-warn" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <div class="modal-icon" style="background:#fff7ed;">
                <i class="ph ph-warning" style="color:#ea580c;font-size:1.6rem;"></i>
            </div>
            <h3 class="modal-title">Cache Belum Dihapus!</h3>
            <p class="modal-desc">
                Kamu belum menghapus cache chatbot di sesi ini. Jika disimpan tanpa hapus cache, chatbot masih akan memberikan <b>jawaban lama</b> untuk pertanyaan yang pernah ditanya sebelumnya.
            </p>
            <p class="modal-desc" style="margin-top:0.5rem;font-size:0.7rem;color:#94a3b8;">
                Disarankan hapus cache dulu agar semua pertanyaan mendapat jawaban dari data terbaru.
            </p>
            <div class="modal-actions" style="flex-direction:column;gap:0.5rem;">
                <button class="modal-btn-confirm amber" style="width:100%;" onclick="closeModal('modal-save-warn'); openModal('modal-clear-cache')">
                    <i class="ph ph-trash" style="margin-right:0.3rem;"></i>Hapus Cache Dulu
                </button>
                <button class="modal-btn-cancel" style="width:100%;color:#64748b;" onclick="doSubmitSave()">
                    Simpan Saja Tanpa Hapus Cache
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ MODAL: Konfirmasi Ubah Status (Aktif / Nonaktif) ═══ --}}
    <div id="modal-toggle-status" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            @if($chatbotStatus === 'active')
                <div class="modal-icon" style="background:#ffe4e6;">
                    <i class="ph ph-power" style="color:#e11d48;font-size:1.6rem;"></i>
                </div>
                <h3 class="modal-title">Nonaktifkan Chatbot AI?</h3>
                <p class="modal-desc">Widget AI Chatbot akan disembunyikan dari pengunjung website Perpustakaan USU dan tidak dapat digunakan sementara.</p>
                <div class="modal-actions">
                    <button class="modal-btn-cancel" onclick="closeModal('modal-toggle-status')">Batal</button>
                    <button class="modal-btn-confirm red" onclick="doSubmitToggleStatus()">Ya, Nonaktifkan</button>
                </div>
            @else
                <div class="modal-icon" style="background:#dcfce7;">
                    <i class="ph ph-power" style="color:#16a34a;font-size:1.6rem;"></i>
                </div>
                <h3 class="modal-title">Aktifkan Chatbot AI?</h3>
                <p class="modal-desc">Widget AI Chatbot akan ditampilkan kembali di website dan dapat diakses oleh pengunjung untuk bertanya.</p>
                <div class="modal-actions">
                    <button class="modal-btn-cancel" onclick="closeModal('modal-toggle-status')">Batal</button>
                    <button class="modal-btn-confirm green" onclick="doSubmitToggleStatus()">Ya, Aktifkan</button>
                </div>
            @endif
        </div>
    </div>

    <style>
        .modal-overlay {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(15,23,42,0.55);
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
            animation: fadeIn .18s ease;
        }
        .modal-box {
            background: #fff;
            border-radius: 1.25rem;
            padding: 1.75rem 1.75rem 1.5rem;
            width: 100%; max-width: 380px;
            box-shadow: 0 20px 50px rgba(0,0,0,.18);
            animation: slideUp .22s ease;
        }
        .modal-icon {
            width: 3rem; height: 3rem;
            border-radius: 0.875rem;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
        }
        .modal-title {
            font-size: 1rem; font-weight: 800;
            color: #1e293b; margin-bottom: 0.5rem;
        }
        .modal-desc {
            font-size: 0.78rem; color: #64748b; line-height: 1.65;
        }
        .modal-actions {
            display: flex; gap: 0.625rem;
            margin-top: 1.25rem;
        }
        .modal-btn-cancel {
            flex: 1; padding: 0.6rem 1rem;
            border: 1.5px solid #e2e8f0; border-radius: 0.625rem;
            font-size: 0.75rem; font-weight: 700; color: #475569;
            background: #fff; cursor: pointer;
            transition: background .15s;
        }
        .modal-btn-cancel:hover { background: #f8fafc; }
        .modal-btn-confirm {
            flex: 1; padding: 0.6rem 1rem;
            border: none; border-radius: 0.625rem;
            font-size: 0.75rem; font-weight: 700; color: #fff;
            cursor: pointer; transition: opacity .15s;
        }
        .modal-btn-confirm:hover { opacity: .88; }
        .modal-btn-confirm.green  { background: #106c38; }
        .modal-btn-confirm.amber  { background: #d97706; }
        .modal-btn-confirm.red    { background: #dc2626; }
        @keyframes fadeIn  { from{opacity:0} to{opacity:1} }
        @keyframes slideUp { from{transform:translateY(16px);opacity:0} to{transform:translateY(0);opacity:1} }
    </style>

    <script>
        // ─── State ───
        let cacheCleared = false;
        let editUnlocked = false;

        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'flex';
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }

        function enableEditMode() {
            editUnlocked = true;
            const textarea   = document.getElementById('ai-textarea');
            const lockBanner = document.getElementById('lock-banner');
            const btnUnlock  = document.getElementById('btn-unlock');
            const btnSave    = document.getElementById('btn-save');

            if (textarea) {
                textarea.removeAttribute('readonly');
                textarea.classList.remove('locked');
                textarea.focus();
            }
            if (lockBanner) lockBanner.classList.add('hidden');
            if (btnUnlock)  btnUnlock.style.display = 'none';
            if (btnSave)    btnSave.style.display   = 'flex';
        }

        function handleSaveClick() {
            if (cacheCleared) {
                openModal('modal-save-safe');
            } else {
                openModal('modal-save-warn');
            }
        }

        function doSubmitToggleStatus() {
            closeModal('modal-toggle-status');
            const form = document.getElementById('form-toggle-status');
            if (form) form.submit();
        }

        function doSubmitClearCache() {
            cacheCleared = true;
            const label = document.getElementById('btn-clear-cache-label');
            const btn   = document.getElementById('btn-clear-cache');
            if (label) label.textContent = 'Cache Dihapus ✓';
            if (btn)   btn.style.background = '#16a34a';
            closeModal('modal-clear-cache');
            const form = document.getElementById('form-clear-cache');
            if (form) form.submit();
        }

        function doSubmitSave() {
            closeModal('modal-save-safe');
            closeModal('modal-save-warn');
            const textarea = document.getElementById('ai-textarea');
            if (textarea) original = textarea.value;
            const form = document.getElementById('editor-form');
            if (form) form.submit();
        }

        let original = '';

        document.addEventListener('DOMContentLoaded', () => {
            // Tutup modal jika klik di luar box
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', function(e) {
                    if (e.target === this) this.style.display = 'none';
                });
            });

            const textarea     = document.getElementById('ai-textarea');
            const charCounter  = document.getElementById('char-counter');
            const lineCounter  = document.getElementById('line-counter');
            const btnSave      = document.getElementById('btn-save');
            const emptyWarn    = document.getElementById('empty-warning');
            const statChars    = document.getElementById('stat-chars');
            const statLines    = document.getElementById('stat-lines');
            const statWords    = document.getElementById('stat-words');
            const statSections = document.getElementById('stat-sections');

            if (textarea) original = textarea.value;

            function fmt(n) { return n.toLocaleString('id-ID'); }

            function update() {
                if (!textarea) return;
                const val      = textarea.value;
                const chars    = val.length;
                const lines    = val === '' ? 0 : val.split('\n').length;
                const words    = val.trim() === '' ? 0 : val.trim().split(/\s+/).length;
                const sections = (val.match(/^\[.+\]/gm) || []).length;
                const trimmed  = val.trim();

                if(charCounter) {
                    charCounter.textContent = fmt(chars) + ' kar.';
                    charCounter.className = 'text-xs font-bold tabular-nums ' + (chars > 0 ? 'char-ok' : 'char-warn');
                }
                if(lineCounter) lineCounter.textContent = fmt(lines) + ' baris';

                if(statChars)    statChars.textContent    = fmt(chars);
                if(statLines)    statLines.textContent    = fmt(lines);
                if(statWords)    statWords.textContent    = fmt(words);
                if(statSections) statSections.textContent = fmt(sections);

                if (btnSave && emptyWarn) {
                    if (trimmed.length < 10) {
                        btnSave.disabled = true;
                        emptyWarn.style.display = 'flex';
                    } else {
                        btnSave.disabled = false;
                        emptyWarn.style.display = 'none';
                    }
                }
            }

            if (textarea) {
                update();
                textarea.addEventListener('input', update);
            }

            window.addEventListener('beforeunload', (e) => {
                if (textarea && textarea.value !== original) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });
    </script>
</body>
</html>
