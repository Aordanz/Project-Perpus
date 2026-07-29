<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pusat Informasi, Pengumuman, Event, Rekomendasi Buku, Berita & Tips Resmi Perpustakaan Universitas Sumatera Utara.">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ __('Informasi & Pengumuman') }} - OPAC {{ __('Universitas Sumatera Utara') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .glass-nav {
            background: #106c38;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* ── PAGE WRAPPER ── */
        .info-page-wrapper {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px);
            padding: 0;
        }

        /* ── 3-PANEL CONTAINER ── */
        .three-panel {
            display: flex;
            flex-direction: row;
            flex: 1;
            overflow: hidden;
            background: #fff;
            border-top: 1px solid #e2e8f0;
            position: relative;
        }

        /* ── PANEL 1: CATEGORY LOGOS (LEFT) ── */
        .panel-categories {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            gap: 20px;
            width: 90px;
            min-width: 90px;
            border-right: 1px solid #e2e8f0;
            background: #fff;
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .panel-categories .section-label {
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #94a3b8;
            text-align: center;
        }

        .cat-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            width: 100%;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0 8px;
            position: relative;
        }
        .cat-btn .emblem {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .cat-btn:hover .emblem {
            border-color: #106c38;
            background: #f0fdf4;
            box-shadow: 0 4px 12px rgba(16,108,56,0.15);
            transform: scale(1.06);
        }
        .cat-btn.active .emblem {
            border-color: #106c38;
            background: #106c38;
            box-shadow: 0 0 0 4px rgba(16,108,56,0.15), 0 4px 14px rgba(16,108,56,0.3);
        }
        .cat-btn.active .emblem i {
            color: #fff !important;
        }
        .cat-btn::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 32px;
            background: #106c38;
            border-radius: 0 4px 4px 0;
            opacity: 0;
            transition: all 0.2s ease;
        }
        .cat-btn.active::before {
            opacity: 1;
            transform: translateY(-50%) scaleY(1);
        }
        .cat-btn .badge {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            background: #f59e0b;
            color: #fff;
            font-size: 9px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.12);
        }
        .cat-btn .cat-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-align: center;
            line-height: 1.2;
            transition: color 0.2s;
        }
        .cat-btn.active .cat-label {
            color: #106c38;
            font-weight: 800;
        }

        /* ── PANEL 2: TITLE LIST (MIDDLE) ── */
        .panel-titles {
            display: flex;
            flex-direction: column;
            width: 270px;
            min-width: 230px;
            border-right: 1px solid #e2e8f0;
            background: #fafafa;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .panel-titles-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
            flex-shrink: 0;
        }
        .panel-titles-header .cat-name {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 900;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .panel-titles-header .data-count {
            font-size: 10px;
            font-weight: 700;
            color: #106c38;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .panel-titles-body {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .panel-titles-body::-webkit-scrollbar,
        .panel-detail::-webkit-scrollbar { width: 4px; }
        .panel-titles-body::-webkit-scrollbar-track,
        .panel-detail::-webkit-scrollbar-track { background: #f1f5f9; }
        .panel-titles-body::-webkit-scrollbar-thumb,
        .panel-detail::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .panel-titles-body::-webkit-scrollbar-thumb:hover,
        .panel-detail::-webkit-scrollbar-thumb:hover { background: #106c38; }

        /* Title Cards */
        .title-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 11px 12px;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .title-card:hover {
            border-color: #106c38;
            box-shadow: 0 3px 10px rgba(16,108,56,0.1);
        }
        .title-card.active {
            background: #f0fdf4;
            border: 2px solid #106c38;
            box-shadow: 0 3px 12px rgba(16,108,56,0.12);
        }
        .title-card .cat-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #106c38;
            background: rgba(16,108,56,0.08);
            padding: 2px 7px;
            border-radius: 5px;
            margin-bottom: 6px;
        }
        .title-card .headline {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.35;
        }
        .title-card.active .headline {
            color: #0d5e30;
            font-weight: 800;
        }
        .title-card .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px solid #f1f5f9;
            font-size: 11px;
            color: #94a3b8;
        }
        .title-card .card-footer .date {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #64748b;
        }
        .title-card .card-footer .date i { color: #106c38; }

        /* Caret Arrow Icon Rotation */
        .caret-icon {
            display: inline-block;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .caret-icon.rotate-90 {
            transform: rotate(90deg);
        }

        /* ── MOBILE ACCORDION DRAWER WITH SMOOTH CSS GRID TRANSITION ── */
        .mobile-accordion-drawer {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition: grid-template-rows 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        margin-top 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        padding-top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            margin-top: 0;
            padding-top: 0;
            border-top: 1px solid transparent;
        }
        .mobile-accordion-drawer.open {
            grid-template-rows: 1fr;
            opacity: 1;
            margin-top: 10px;
            padding-top: 10px;
            border-top-color: rgba(226, 232, 240, 0.8);
        }
        .mobile-accordion-inner {
            min-height: 0;
            overflow: hidden;
        }

        /* ── PANEL 3: ADAPTIVE DYNAMIC DETAIL VIEWER ── */
        .panel-detail {
            flex: 1;
            overflow-y: auto;
            background: #f8fafc;
            padding: 24px 28px;
        }
        .detail-container {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            min-height: 100%;
        }

        .detail-poster-left {
            width: clamp(240px, 24vw, 290px);
            aspect-ratio: 4 / 5;
            border-radius: 18px;
            overflow: hidden;
            background: #e2e8f0;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.07);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            cursor: pointer;
        }
        .detail-poster-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .detail-poster-left:hover img { transform: scale(1.03); }

        .poster-hover-overlay {
            position: absolute;
            inset: 0;
            background: rgba(16, 108, 56, 0.4);
            backdrop-filter: blur(2px);
            opacity: 0;
            transition: opacity 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            gap: 6px;
        }
        .detail-poster-left:hover .poster-hover-overlay {
            opacity: 1;
        }

        .detail-content-right {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .badge-cat {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: #106c38;
            color: #fff;
            padding: 4px 10px;
            border-radius: 7px;
            box-shadow: 0 2px 6px rgba(16,108,56,0.2);
        }
        .badge-date {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            background: #ffffff;
            padding: 3px 10px;
            border-radius: 7px;
            border: 1px solid #e2e8f0;
        }

        .detail-title {
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.3;
        }

        .detail-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }
        .meta-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .meta-item i {
            font-size: 20px;
            color: #106c38;
        }
        .meta-label {
            display: block;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
        }
        .meta-val {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .detail-desc-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 22px;
            font-size: 13.5px;
            line-height: 1.7;
            color: #334155;
            white-space: pre-line;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        }

        .detail-widgets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }
        .widget-card {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .widget-card i {
            font-size: 22px;
            color: #106c38;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .widget-title {
            font-size: 11px;
            font-weight: 800;
            color: #106c38;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }
        .widget-text {
            font-size: 11.5px;
            color: #1e293b;
            line-height: 1.45;
            font-weight: 500;
        }

        .detail-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #106c38;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 11px 20px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 3px 10px rgba(16,108,56,0.2);
            width: fit-content;
        }
        .detail-action-btn:hover {
            background: #0d5e30;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(16,108,56,0.3);
            color: #ffffff;
        }

        .detail-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 60px 0;
            color: #94a3b8;
        }
        .detail-empty.hidden,
        .detail-container.hidden {
            display: none !important;
        }
        .detail-empty i { font-size: 48px; margin-bottom: 12px; color: #cbd5e1; }
        .detail-empty h3 { font-size: 15px; font-weight: 700; color: #475569; margin-bottom: 4px; }
        .detail-empty p { font-size: 12px; }

        /* Connected Sidebar Edge Tab Handle (Mobile) */
        .mobile-sidebar-handle {
            display: none;
        }

        /* ── MOBILE SPECIFIC RESPONSIVE STYLES (<= 768px) ── */
        @media (max-width: 768px) {
            .mobile-sidebar-handle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 10px;
                left: 66px;
                width: 22px;
                height: 36px;
                background: #106c38;
                color: #ffffff;
                border-radius: 0 10px 10px 0;
                border: 1.5px solid #106c38;
                border-left: none;
                cursor: pointer;
                z-index: 50;
                box-shadow: 3px 2px 8px rgba(16, 108, 56, 0.25);
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.2s ease;
            }
            .mobile-sidebar-handle:hover {
                background: #0d5e30;
            }
            .three-panel.sidebar-closed .mobile-sidebar-handle {
                left: 0px !important;
            }

            .three-panel {
                flex-direction: row;
            }

            /* Compact Category Sidebar on Mobile */
            .panel-categories {
                width: 66px;
                min-width: 66px;
                padding: 12px 0;
                gap: 12px;
            }
            .panel-categories.collapsed {
                width: 0 !important;
                min-width: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                opacity: 0 !important;
                border-right: none !important;
                overflow: hidden !important;
            }
            .panel-categories .section-label {
                font-size: 8px;
            }

            /* Compact Emblem buttons on Mobile */
            .cat-btn {
                padding: 0 4px;
                gap: 3px;
            }
            .cat-btn .emblem {
                width: 38px;
                height: 38px;
            }
            .cat-btn .emblem i {
                font-size: 17px !important;
            }
            .cat-btn .badge {
                width: 16px;
                height: 16px;
                font-size: 8px;
                top: -2px;
                right: -2px;
            }
            .cat-btn .cat-label {
                font-size: 8px;
                line-height: 1.15;
            }

            .panel-titles {
                flex: 1;
                width: auto;
                min-width: 0;
                border-right: none;
            }
            .panel-detail {
                display: none !important; /* Hide Panel 3 on mobile */
            }
        }

        @media (min-width: 769px) {
            .mobile-accordion-drawer {
                display: none !important; /* Hide mobile inline drawers on desktop */
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-grow info-page-wrapper" style="margin-top: 64px;">

        <div class="three-panel">

            {{-- Connected Edge Pull-Tab Handle attached to Category Sidebar edge (Mobile) --}}
            <button type="button" id="toggle-cat-sidebar-btn" class="mobile-sidebar-handle" title="Sembunyikan / Tampilkan Kategori">
                <i id="toggle-cat-icon" class="ph ph-caret-left font-bold text-xs"></i>
            </button>

            {{-- ════════════════════════════════════════
                 PANEL 1 — CATEGORY LOGO BUTTONS (LEFT)
            ════════════════════════════════════════ --}}
            <div class="panel-categories">
                <span class="section-label">Kategori</span>

                @foreach($categoryConfigs as $key => $config)
                    @php
                        $count = $categoryCounts[$key] ?? 0;
                        $isActive = ($selectedCategory === $key);
                    @endphp
                    <button type="button"
                            class="cat-btn {{ $isActive ? 'active' : '' }}"
                            data-category="{{ $key }}">
                        <div class="emblem">
                            <i class="ph {{ $config['icon'] }} text-2xl {{ $isActive ? 'text-white' : 'text-[#106c38]' }}"></i>
                            @if($count > 0)
                                <span class="badge">{{ $count }}</span>
                            @endif
                        </div>
                        <span class="cat-label">{{ $config['title'] }}</span>
                    </button>
                @endforeach
            </div>

            {{-- ════════════════════════════════════════
                 PANEL 2 — TITLE CARD LIST WITH MOBILE ACCORDION (MIDDLE)
            ════════════════════════════════════════ --}}
            <div class="panel-titles">
                <div class="panel-titles-header">
                    <div class="cat-name flex items-center gap-1.5">
                        <i id="current-cat-icon" class="ph ph-megaphone-simple text-[#106c38]"></i>
                        <span id="current-cat-title">{{ $categoryConfigs[$selectedCategory]['title'] ?? '' }}</span>
                    </div>
                    <span id="current-cat-count" class="data-count">
                        {{ $categoryCounts[$selectedCategory] ?? 0 }} Data
                    </span>
                </div>

                <div class="panel-titles-body" id="titles-list-container">
                    @forelse($items as $item)
                        @php
                            $isFirst = $loop->first;
                            $catConf = $categoryConfigs[$item['category']] ?? $categoryConfigs['announcement'];
                            $hasCustomImg = $item['has_custom_image'] ?? false;
                            $hasRawDesc   = $item['has_raw_desc'] ?? false;
                            $hasMeta      = $item['has_meta'] ?? false;
                        @endphp
                        <div class="title-card {{ $item['category'] !== $selectedCategory ? 'hidden' : '' }}"
                             data-id="{{ $item['id'] }}"
                             data-category="{{ $item['category'] }}">

                            <div class="cat-tag">
                                <i class="ph {{ $catConf['icon'] }}"></i>
                                {{ $catConf['title'] }}
                            </div>

                            <div class="headline">{{ $item['title'] }}</div>

                            <div class="card-footer">
                                <span class="date">
                                    <i class="ph ph-clock"></i>
                                    {{ $item['start_date'] }}
                                </span>
                                <i class="ph ph-caret-right text-[#106c38] caret-icon" style="font-size:11px;"></i>
                            </div>

                            {{-- ═══ MOBILE INLINE EXPANDED DETAIL ═══ --}}
                            <div class="mobile-accordion-drawer">
                                <div class="mobile-accordion-inner space-y-3">

                                    {{-- Poster Image (Only if uploaded by admin) --}}
                                    @if($hasCustomImg)
                                        <div class="w-full aspect-[4/5] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 relative group cursor-pointer mobile-lightbox-trigger"
                                             data-img="{{ $item['image_url'] }}">
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[11px] font-bold gap-1">
                                                <i class="ph ph-magnifying-glass-plus text-base"></i> Perbesar
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Meta info (Only if explicitly filled) --}}
                                    @if($hasMeta)
                                        <div class="space-y-1.5 text-[11px]">
                                            @if(!empty($item['time']))
                                                <div class="flex items-center gap-1.5 text-slate-700 font-semibold">
                                                    <i class="ph ph-clock text-[#106c38] text-sm"></i>
                                                    <span>{{ $item['time'] }}</span>
                                                </div>
                                            @endif
                                            @if(!empty($item['location']))
                                                <div class="flex items-center gap-1.5 text-slate-700 font-semibold">
                                                    <i class="ph ph-map-pin text-[#106c38] text-sm"></i>
                                                    <span>{{ $item['location'] }}</span>
                                                </div>
                                            @endif
                                            @if(!empty($item['organizer']))
                                                <div class="flex items-center gap-1.5 text-slate-700 font-semibold">
                                                    <i class="ph ph-buildings text-[#106c38] text-sm"></i>
                                                    <span>{{ $item['organizer'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Description Box (Only if provided) --}}
                                    @if($hasRawDesc)
                                        <div class="text-[11.5px] text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-200 leading-relaxed whitespace-pre-line">
                                            {{ $item['description'] }}
                                        </div>
                                    @endif

                                    {{-- Action Link Button (Only if provided) --}}
                                    @if(!empty($item['link_url']))
                                        <a href="{{ $item['link_url'] }}" target="_blank" class="inline-flex items-center gap-1.5 bg-[#106c38] text-white font-bold text-xs px-3 py-2 rounded-lg hover:bg-[#0d5e30] transition shadow-sm w-full justify-center">
                                            <i class="ph ph-arrow-square-out text-sm"></i>
                                            <span>Buka Tautan Resmi</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @empty
                        <div style="text-align:center;padding:40px 10px;color:#94a3b8;">
                            <i class="ph ph-folder-open" style="font-size:36px;display:block;margin-bottom:8px;"></i>
                            <p style="font-size:12px;">Belum ada pengumuman.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ════════════════════════════════════════
                 PANEL 3 — DESKTOP DETAIL VIEWER (EXACTLY MATCHING ADMIN INPUT)
            ════════════════════════════════════════ --}}
            <div class="panel-detail" id="detail-viewer-content">
                @php
                    $hasItems = $items->count() > 0;
                    $activeItem = ($hasItems && $selectedId > 0)
                        ? ($items->firstWhere('id', $selectedId) ?? null)
                        : null;
                    $showEmpty = !$activeItem;
                    $activeHasCustomImg = $activeItem['has_custom_image'] ?? false;
                    $activeHasRawDesc   = $activeItem['has_raw_desc'] ?? false;
                    $activeHasMeta      = $activeItem['has_meta'] ?? false;
                    $activeHasLink      = !empty($activeItem['link_url']);
                @endphp

                {{-- Detail Content Wrapper --}}
                <div id="detail-has-content" class="detail-container {{ $showEmpty ? 'hidden' : '' }}">
                    
                    {{-- Poster Image 4:5 (Shown if custom image uploaded) --}}
                    <div class="detail-poster-left" id="poster-trigger" title="Klik untuk memperbesar poster" style="{{ $activeHasCustomImg ? '' : 'display:none;' }}">
                        <img id="detail-image"
                             src="{{ $activeItem['image_url'] ?? '' }}"
                             alt="{{ $activeItem['title'] ?? '' }}">
                        <div class="poster-hover-overlay">
                            <i class="ph ph-magnifying-glass-plus text-lg"></i>
                            <span>Perbesar Poster</span>
                        </div>
                    </div>

                    {{-- Expanded Content Area --}}
                    <div class="detail-content-right">

                        {{-- Category & Date Badges --}}
                        <div class="flex items-center gap-2">
                            <span id="detail-category-badge" class="badge-cat">
                                <i class="ph ph-info"></i>
                                {{ str_replace('_', ' ', strtoupper($activeItem['category'] ?? 'ANNOUNCEMENT')) }}
                            </span>
                            <span id="detail-date" class="badge-date">
                                {{ $activeItem['start_date'] ?? '' }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h2 id="detail-title" class="detail-title">{{ $activeItem['title'] ?? '' }}</h2>

                        {{-- Meta Items Grid (Only shown if filled in Admin) --}}
                        <div class="detail-meta-grid" style="{{ $activeHasMeta ? '' : 'display:none;' }}">
                            <div class="meta-item" style="{{ !empty($activeItem['time']) ? '' : 'display:none;' }}">
                                <i class="ph ph-clock"></i>
                                <div>
                                    <span class="meta-label">Waktu Operasional / Event</span>
                                    <span id="detail-time" class="meta-val">{{ $activeItem['time'] ?? '' }}</span>
                                </div>
                            </div>
                            <div class="meta-item" style="{{ !empty($activeItem['location']) ? '' : 'display:none;' }}">
                                <i class="ph ph-map-pin"></i>
                                <div>
                                    <span class="meta-label">Lokasi Kegiatan</span>
                                    <span id="detail-location" class="meta-val">{{ $activeItem['location'] ?? '' }}</span>
                                </div>
                            </div>
                            <div class="meta-item" style="{{ !empty($activeItem['organizer']) ? '' : 'display:none;' }}">
                                <i class="ph ph-buildings"></i>
                                <div>
                                    <span class="meta-label">Penyelenggara</span>
                                    <span id="detail-organizer" class="meta-val">{{ $activeItem['organizer'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Main Description Box (Shown if description entered) --}}
                        <div class="detail-desc-box" style="{{ $activeHasRawDesc ? '' : 'display:none;' }}">
                            <div id="detail-description">{{ $activeItem['description'] ?? '' }}</div>
                        </div>

                        {{-- Useful Info Widgets (Only shown if description/event provided) --}}
                        <div class="detail-widgets-grid" style="{{ ($activeHasRawDesc || ($activeItem['category']??'')==='event') ? '' : 'display:none;' }}">
                            <div class="widget-card">
                                <i class="ph ph-identification-card"></i>
                                <div>
                                    <div class="widget-title">Ketentuan Pengunjung</div>
                                    <div class="widget-text">Harap menunjukkan Kartu Tanda Mahasiswa (KTM) atau Kartu Anggota Perpustakaan yang berlaku.</div>
                                </div>
                            </div>
                            <div class="widget-card">
                                <i class="ph ph-headset"></i>
                                <div>
                                    <div class="widget-title">Layanan Pustakawan & Helpdesk</div>
                                    <div class="widget-text">Butuh bantuan? Hubungi meja layanan utama di Lantai 1 atau via Email: <strong>library@usu.ac.id</strong></div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Link Button (Shown if link entered in Admin) --}}
                        <div id="detail-actions" class="pt-1" style="{{ $activeHasLink ? '' : 'display:none;' }}">
                            <a id="detail-link-btn" href="{{ $activeItem['link_url'] ?? '#' }}" target="_blank" class="detail-action-btn">
                                <i class="ph ph-arrow-square-out text-base"></i>
                                <span>Buka Tautan / Halaman Resmi</span>
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Empty State Wrapper --}}
                <div id="detail-empty-view" class="detail-empty {{ $showEmpty ? '' : 'hidden' }}">
                    <i class="ph ph-hand-pointing text-[#106c38]" style="font-size:48px;margin-bottom:12px;"></i>
                    <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:4px;">Pilih Judul Informasi</h3>
                    <p style="font-size:12px;color:#64748b;max-width:320px;margin:0 auto;line-height:1.5;">
                        Silakan klik salah satu judul informasi di sebelah kiri untuk melihat detail selengkapnya.
                    </p>
                </div>

            </div>

        </div>{{-- .three-panel --}}

    </main>

    {{-- LIGHTBOX MODAL FOR FULL-SIZE POSTER VIEWING --}}
    <div id="poster-lightbox">
        <button id="close-lightbox-btn" class="absolute top-5 right-5 w-11 h-11 rounded-full bg-white/20 hover:bg-white text-white hover:text-black flex items-center justify-center text-xl transition cursor-pointer">
            <i class="ph ph-x"></i>
        </button>
        <img id="poster-lightbox-img" src="" alt="Poster Preview Full">
    </div>

    @include('partials.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemsData = @json($items);
        const categoryConfigs = @json($categoryConfigs);

        let currentCategory = "{{ $selectedCategory }}";
        let currentSelectedId = {{ $selectedId > 0 ? $selectedId : 0 }};

        const catBtns  = document.querySelectorAll('.cat-btn');
        const titleCards = document.querySelectorAll('.title-card');

        /* ── MOBILE SIDEBAR TOGGLE HIDE / SHOW (CONNECTED HANDLE TAB) ── */
        const toggleSidebarBtn = document.getElementById('toggle-cat-sidebar-btn');
        const panelCategories  = document.querySelector('.panel-categories');
        const threePanel       = document.querySelector('.three-panel');
        const toggleCatIcon    = document.getElementById('toggle-cat-icon');

        if (toggleSidebarBtn && panelCategories) {
            toggleSidebarBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                panelCategories.classList.toggle('collapsed');
                if (threePanel) threePanel.classList.toggle('sidebar-closed');
                const isCollapsed = panelCategories.classList.contains('collapsed');

                if (toggleCatIcon) {
                    toggleCatIcon.className = isCollapsed
                        ? 'ph ph-caret-right font-bold text-xs'
                        : 'ph ph-caret-left font-bold text-xs';
                }
            });
        }

        /* ── LIGHTBOX ZOOM ── */
        const lightbox = document.getElementById('poster-lightbox');
        const lightboxImg = document.getElementById('poster-lightbox-img');
        const posterTrigger = document.getElementById('poster-trigger');
        const closeLightboxBtn = document.getElementById('close-lightbox-btn');

        function openLightbox(srcUrl) {
            const imgSrc = srcUrl || document.getElementById('detail-image')?.src;
            if (imgSrc && lightboxImg) {
                lightboxImg.src = imgSrc;
                lightbox.classList.add('active');
            }
        }
        function closeLightbox() {
            if (lightbox) lightbox.classList.remove('active');
        }

        if (posterTrigger) posterTrigger.addEventListener('click', () => openLightbox());
        if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);
        if (lightbox) {
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) closeLightbox();
            });
        }

        // Mobile lightbox triggers
        document.querySelectorAll('.mobile-lightbox-trigger').forEach(el => {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                openLightbox(this.dataset.img);
            });
        });

        /* ── SWITCH CATEGORY ── */
        function switchCategory(catKey) {
            currentCategory = catKey;

            catBtns.forEach(btn => btn.classList.toggle('active', btn.dataset.category === catKey));

            const conf = categoryConfigs[catKey] || {};
            const titleEl = document.getElementById('current-cat-title');
            const iconEl  = document.getElementById('current-cat-icon');
            const countEl = document.getElementById('current-cat-count');

            if (titleEl) titleEl.textContent = conf.title || catKey;
            if (iconEl)  iconEl.className = `ph ${conf.icon || 'ph-info'} text-[#106c38]`;

            let count = 0;
            let targetToSelect = null;

            titleCards.forEach(card => {
                const show = card.dataset.category === catKey;
                card.classList.toggle('hidden', !show);

                const drawer = card.querySelector('.mobile-accordion-drawer');
                const caretIcon = card.querySelector('.caret-icon');
                card.classList.remove('active');
                if (drawer) drawer.classList.remove('open');
                if (caretIcon) caretIcon.classList.remove('rotate-90');

                if (show) {
                    count++;
                    if (currentSelectedId > 0 && parseInt(card.dataset.id) === currentSelectedId) {
                        targetToSelect = currentSelectedId;
                    }
                }
            });

            if (countEl) countEl.textContent = `${count} Data`;

            if (targetToSelect) {
                selectItem(targetToSelect, false);
            } else {
                currentSelectedId = 0;
                renderEmpty();
            }
        }

        /* ── SELECT ITEM (DESKTOP PANEL 3 & OPTIONAL USER CLICK MOBILE EXPANSION) ── */
        function selectItem(itemId, isUserClick = false) {
            currentSelectedId = itemId;
            const item = itemsData.find(i => i.id === itemId);

            titleCards.forEach(card => {
                const cid = parseInt(card.dataset.id);
                const isTarget = (cid === itemId);

                const drawer = card.querySelector('.mobile-accordion-drawer');
                const caretIcon = card.querySelector('.caret-icon');

                if (isTarget) {
                    card.classList.add('active');

                    if (isUserClick) {
                        const isOpen = drawer ? drawer.classList.contains('open') : false;
                        if (isOpen) {
                            card.classList.remove('active');
                            if (drawer) drawer.classList.remove('open');
                            if (caretIcon) caretIcon.classList.remove('rotate-90');
                        } else {
                            if (drawer) drawer.classList.add('open');
                            if (caretIcon) caretIcon.classList.add('rotate-90');
                        }
                    }
                } else {
                    card.classList.remove('active');
                    if (drawer) drawer.classList.remove('open');
                    if (caretIcon) caretIcon.classList.remove('rotate-90');
                }
            });

            if (item) renderDetail(item);
        }

        /* ── RENDER DETAIL (EXACTLY MATCHING ADMIN INPUT) ── */
        function renderDetail(item) {
            const hasContent = document.getElementById('detail-has-content');
            const emptyView  = document.getElementById('detail-empty-view');

            if (hasContent) hasContent.classList.remove('hidden');
            if (emptyView)  emptyView.classList.add('hidden');

            const el = id => document.getElementById(id);

            const posterWrap  = el('poster-trigger');
            const imgEl       = el('detail-image');
            const badgeEl     = el('detail-category-badge');
            const dateEl      = el('detail-date');
            const titleEl     = el('detail-title');
            const descEl      = el('detail-description');
            const descBoxEl   = descEl ? descEl.closest('.detail-desc-box') : null;
            const metaGridEl  = document.querySelector('.detail-meta-grid');
            const widgetGridEl= document.querySelector('.detail-widgets-grid');
            const actionsWrap = el('detail-actions');
            const linkEl      = el('detail-link-btn');

            // 1. Poster Image Visibility
            if (posterWrap) {
                if (item.has_custom_image) {
                    posterWrap.style.display = 'block';
                    if (imgEl) { imgEl.src = item.image_url; imgEl.alt = item.title || ''; }
                } else {
                    posterWrap.style.display = 'none';
                }
            }

            // 2. Meta Grid Visibility (Time, Location, Organizer)
            if (metaGridEl) {
                if (item.has_meta) {
                    metaGridEl.style.display = 'grid';
                    const timeItem = el('detail-time')?.closest('.meta-item');
                    const locItem  = el('detail-location')?.closest('.meta-item');
                    const orgItem  = el('detail-organizer')?.closest('.meta-item');

                    if (timeItem) timeItem.style.display = item.time ? 'flex' : 'none';
                    if (locItem)  locItem.style.display  = item.location ? 'flex' : 'none';
                    if (orgItem)  orgItem.style.display  = item.organizer ? 'flex' : 'none';

                    if (el('detail-time'))      el('detail-time').textContent = item.time || '';
                    if (el('detail-location'))  el('detail-location').textContent = item.location || '';
                    if (el('detail-organizer')) el('detail-organizer').textContent = item.organizer || '';
                } else {
                    metaGridEl.style.display = 'none';
                }
            }

            // 3. Description Box Visibility
            if (descBoxEl) {
                if (item.has_raw_desc) {
                    descBoxEl.style.display = 'block';
                    if (descEl) descEl.textContent = item.description || '';
                } else {
                    descBoxEl.style.display = 'none';
                }
            }

            // 4. Widget Cards Visibility (Only show widgets if description or event exists)
            if (widgetGridEl) {
                if (item.has_raw_desc || item.category === 'event') {
                    widgetGridEl.style.display = 'grid';
                } else {
                    widgetGridEl.style.display = 'none';
                }
            }

            // 5. Action Button Link Visibility
            if (actionsWrap && linkEl) {
                if (item.link_url) {
                    actionsWrap.style.display = 'block';
                    linkEl.href = item.link_url;
                } else {
                    actionsWrap.style.display = 'none';
                }
            }

            if (badgeEl) badgeEl.innerHTML = `<i class="ph ph-info"></i> ${(item.category||'').toUpperCase().replace(/_/g,' ')}`;
            if (dateEl)  dateEl.textContent = item.start_date || '';
            if (titleEl) titleEl.textContent = item.title || '';
        }

        function renderEmpty() {
            const hasContent = document.getElementById('detail-has-content');
            const emptyView  = document.getElementById('detail-empty-view');

            if (hasContent) hasContent.classList.add('hidden');
            if (emptyView)  emptyView.classList.remove('hidden');
        }

        /* ── INITIAL SELECTION ── */
        if (currentSelectedId > 0) {
            selectItem(currentSelectedId, true);
        } else {
            renderEmpty();
        }

        /* ── EVENT LISTENERS ── */
        catBtns.forEach(btn => btn.addEventListener('click', () => switchCategory(btn.dataset.category)));
        titleCards.forEach(card => card.addEventListener('click', function(e) {
            if (e.target.closest('a')) return;
            selectItem(parseInt(this.dataset.id), true);
        }));
    });
    </script>
</body>
</html>
