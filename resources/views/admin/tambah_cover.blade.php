<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link class="flex-shrink-0" rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Tambah Cover - Portal Admin OPAC USU</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-6">
        
                <!-- Header -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                            <i class="ph ph-image-plus text-usu-green text-3xl"></i>
                            <span>Tambah Cover Buku</span>
                        </h1>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">Pilih buku di bawah ini untuk menambahkan atau mengubah gambar sampul (cover) buku.</p>
                    </div>
                </div>

                <!-- Success & Error Alerts -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                        <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                        <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">
                            <p class="font-bold">Terjadi Kesalahan:</p>
                            <ul class="list-disc pl-5 mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Content Area -->
                <div class="flex flex-col gap-6 items-start w-full">
                    
                    <!-- Search Panel -->
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6 w-full">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i class="ph ph-magnifying-glass text-usu-green"></i>
                                    <span>Cari Buku Terlebih Dahulu</span>
                                </h2>
                                <p class="text-slate-500 text-xs mt-0.5">Masukkan judul buku, nama pengarang, atau nomor ISBN untuk mencari buku.</p>
                            </div>
                            
                            <!-- Search & Filter Controls -->
                            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                                <!-- Custom Filter Dropdown -->
                                <div class="w-full sm:w-56 relative custom-select-container">
                                    <input type="hidden" name="cover_filter" id="admin-cover-filter" value="{{ request('cover_filter', 'all') }}">
                                    
                                    <button type="button" id="cover-filter-trigger" class="w-full flex items-center justify-between px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 outline-none transition-all duration-200 focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 cursor-pointer shadow-sm">
                                        <span class="flex items-center gap-2" id="cover-filter-label">
                                            @if(request('cover_filter') == 'no_cover')
                                                <i class="ph ph-image-square text-rose-500 text-lg"></i>
                                                <span>Belum Ada Cover</span>
                                            @elseif(request('cover_filter') == 'has_cover')
                                                <i class="ph ph-check-square text-emerald-500 text-lg"></i>
                                                <span>Sudah Ada Cover</span>
                                            @else
                                                <i class="ph ph-books text-blue-500 text-lg"></i>
                                                <span>Semua Buku</span>
                                            @endif
                                        </span>
                                        <i class="ph ph-caret-down text-slate-400 transition-transform duration-200" id="cover-filter-caret"></i>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div id="cover-filter-menu" class="hidden absolute left-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 transition-all transform origin-top scale-95 opacity-0 duration-200">
                                        <!-- Option 1: Semua Buku -->
                                        <button type="button" class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors cursor-pointer border-none bg-transparent" data-value="all">
                                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center">
                                                <i class="ph ph-books text-lg"></i>
                                            </div>
                                            <div class="flex-grow">
                                                <span class="block">Semua Buku</span>
                                            </div>
                                            <i class="ph ph-check text-usu-green font-bold {{ request('cover_filter', 'all') == 'all' ? '' : 'hidden' }} option-check"></i>
                                        </button>

                                        <!-- Option 2: Belum Ada Cover -->
                                        <button type="button" class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors cursor-pointer border-none bg-transparent" data-value="no_cover">
                                            <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center">
                                                <i class="ph ph-image-square text-lg"></i>
                                            </div>
                                            <div class="flex-grow">
                                                <span class="block">Belum Ada Cover</span>
                                            </div>
                                            <i class="ph ph-check text-usu-green font-bold {{ request('cover_filter', 'all') == 'no_cover' ? '' : 'hidden' }} option-check"></i>
                                        </button>

                                        <!-- Option 3: Sudah Ada Cover -->
                                        <button type="button" class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors cursor-pointer border-none bg-transparent" data-value="has_cover">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                                                <i class="ph ph-check-square text-lg"></i>
                                            </div>
                                            <div class="flex-grow">
                                                <span class="block">Sudah Ada Cover</span>
                                            </div>
                                            <i class="ph ph-check text-usu-green font-bold {{ request('cover_filter', 'all') == 'has_cover' ? '' : 'hidden' }} option-check"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Custom Location Filter Dropdown -->
                                <div class="w-full sm:w-56 relative custom-location-select-container">
                                    <input type="hidden" name="location_filter" id="admin-location-filter" value="{{ request('location_filter', 'all') }}">
                                    
                                    <button type="button" id="location-filter-trigger" class="w-full flex items-center justify-between px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 outline-none transition-all duration-200 focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 cursor-pointer shadow-sm">
                                        <span class="flex items-center gap-2" id="location-filter-label">
                                            @php
                                                $activeLoc = isset($locations) ? $locations->firstWhere('idlokasi', request('location_filter')) : null;
                                            @endphp
                                            @if($activeLoc)
                                                <i class="ph {{ $activeLoc->icon ?: 'ph-map-pin' }} text-usu-green text-lg"></i>
                                                <span>{{ $activeLoc->lokasi }}</span>
                                            @else
                                                <i class="ph ph-map-pin text-[#106c38] text-lg"></i>
                                                <span>Semua Lokasi</span>
                                            @endif
                                        </span>
                                        <i class="ph ph-caret-down text-slate-400 transition-transform duration-200" id="location-filter-caret"></i>
                                    </button>
 
                                    <!-- Dropdown Menu -->
                                    <div id="location-filter-menu" class="hidden absolute left-0 top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 transition-all transform origin-top scale-95 opacity-0 duration-200 max-h-60 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                                        <!-- Option: Semua Lokasi -->
                                        <button type="button" class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors cursor-pointer border-none bg-transparent" data-value="all">
                                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#106c38] flex items-center justify-center">
                                                <i class="ph ph-map-pin text-lg"></i>
                                            </div>
                                            <div class="flex-grow">
                                                <span class="block">Semua Lokasi</span>
                                            </div>
                                            <i class="ph ph-check text-usu-green font-bold {{ request('location_filter', 'all') == 'all' ? '' : 'hidden' }} option-check"></i>
                                        </button>
 
                                        @if(isset($locations))
                                            @foreach($locations as $loc)
                                                <button type="button" class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors cursor-pointer border-none bg-transparent" data-value="{{ $loc->idlokasi }}">
                                                    <div class="w-8 h-8 rounded-xl bg-green-50 text-[#106c38] flex items-center justify-center">
                                                        <i class="ph {{ $loc->icon ?: 'ph-map-pin' }} text-lg"></i>
                                                    </div>
                                                    <div class="flex-grow">
                                                        <span class="block truncate max-w-[150px]" title="{{ $loc->lokasi }}">{{ $loc->lokasi }}</span>
                                                    </div>
                                                    <i class="ph ph-check text-usu-green font-bold {{ request('location_filter') == $loc->idlokasi ? '' : 'hidden' }} option-check"></i>
                                                </button>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Large Search Input -->
                                <div class="w-full sm:w-72">
                                    <form id="admin-search-form" action="{{ route('admin.tambah-cover') }}" method="GET" class="relative flex items-center w-full">
                                        <input type="hidden" name="limit" id="admin-limit-select" value="{{ request('limit', 10) }}">
                                        <div class="absolute left-3.5 text-slate-400">
                                            <i class="ph ph-magnifying-glass text-lg"></i>
                                        </div>
                                        <input type="text" name="search" id="admin-search-input" value="{{ request('search') }}" placeholder="Cari judul, pengarang, ISBN..." class="w-full pl-10 pr-8 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-sm outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                                        <button type="button" id="clear-search-btn" class="absolute right-3.5 text-slate-400 hover:text-slate-600 {{ request('search') ? '' : 'hidden' }} bg-transparent border-none cursor-pointer p-0 flex items-center">
                                            <i class="ph ph-x-circle text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Books Table Container -->
                        <div id="books-table-container" class="w-full">
                            @include('admin.partials.books_table')
                        </div>
                    </div>
                </div>

            </main>

            <!-- Custom Toast Notification Container -->
            <div id="toast-container" class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-3 pointer-events-none items-center"></div>

            <!-- Footer -->
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Live Search Ajax Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchForm = document.getElementById('admin-search-form');
            const searchInput = document.getElementById('admin-search-input');
            const clearBtn = document.getElementById('clear-search-btn');
            const tableContainer = document.getElementById('books-table-container');
            let debounceTimer;

            window.performSearch = function() {
                if (tableContainer) {
                    tableContainer.style.opacity = '0.5';
                    tableContainer.style.pointerEvents = 'none';
                }

                const query = searchInput ? searchInput.value.trim() : '';
                const limit = document.getElementById('admin-limit-select') ? document.getElementById('admin-limit-select').value : 10;
                const filter = document.getElementById('admin-cover-filter') ? document.getElementById('admin-cover-filter').value : 'all';
                const locFilter = document.getElementById('admin-location-filter') ? document.getElementById('admin-location-filter').value : 'all';
                
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.set('limit', limit);
                url.searchParams.set('cover_filter', filter);
                url.searchParams.set('location_filter', locFilter);
                url.searchParams.delete('page'); // Go back to page 1 on new search

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (tableContainer) {
                        tableContainer.innerHTML = html;
                        tableContainer.style.opacity = '1';
                        tableContainer.style.pointerEvents = 'auto';
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

            // --- Custom Cover Filter Dropdown ---
            const coverTrigger = document.getElementById('cover-filter-trigger');
            const coverMenu = document.getElementById('cover-filter-menu');
            const coverCaret = document.getElementById('cover-filter-caret');
            const coverLabel = document.getElementById('cover-filter-label');
            const coverInput = document.getElementById('admin-cover-filter');

            if (coverTrigger && coverMenu) {
                const coverOptions = coverMenu.querySelectorAll('button');

                coverTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isClosed = coverMenu.classList.contains('hidden');
                    
                    // Close location menu if open
                    closeLocationMenu();

                    if (isClosed) {
                        openCoverMenu();
                    } else {
                        closeCoverMenu();
                    }
                });

                function openCoverMenu() {
                    coverMenu.classList.remove('hidden');
                    coverMenu.offsetHeight; // trigger reflow
                    coverMenu.classList.remove('scale-95', 'opacity-0');
                    coverMenu.classList.add('scale-100', 'opacity-100');
                    coverCaret.classList.add('rotate-180');
                }

                function closeCoverMenu() {
                    coverMenu.classList.remove('scale-100', 'opacity-100');
                    coverMenu.classList.add('scale-95', 'opacity-0');
                    coverCaret.classList.remove('rotate-180');
                    setTimeout(() => {
                        coverMenu.classList.add('hidden');
                    }, 200);
                }

                coverOptions.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = opt.getAttribute('data-value');
                        const optHtml = opt.querySelector('.flex-grow span').textContent.trim();
                        const optIcon = opt.querySelector('i').className;

                        coverInput.value = val;

                        let iconColor = 'text-blue-500';
                        if (val === 'no_cover') iconColor = 'text-rose-500';
                        if (val === 'has_cover') iconColor = 'text-emerald-500';

                        coverLabel.innerHTML = `
                            <i class="${optIcon} ${iconColor} text-lg"></i>
                            <span>${optHtml}</span>
                        `;

                        coverOptions.forEach(o => {
                            const chk = o.querySelector('.option-check');
                            if (o === opt) {
                                chk.classList.remove('hidden');
                            } else {
                                chk.classList.add('hidden');
                            }
                        });

                        closeCoverMenu();
                        window.performSearch();
                    });
                });

                window.closeCoverMenu = closeCoverMenu;
            }

            // --- Custom Location Filter Dropdown ---
            const locTrigger = document.getElementById('location-filter-trigger');
            const locMenu = document.getElementById('location-filter-menu');
            const locCaret = document.getElementById('location-filter-caret');
            const locLabel = document.getElementById('location-filter-label');
            const locInput = document.getElementById('admin-location-filter');

            if (locTrigger && locMenu) {
                const locOptions = locMenu.querySelectorAll('button');

                locTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isClosed = locMenu.classList.contains('hidden');

                    // Close cover menu if open
                    if (window.closeCoverMenu) window.closeCoverMenu();

                    if (isClosed) {
                        openLocationMenu();
                    } else {
                        closeLocationMenu();
                    }
                });

                function openLocationMenu() {
                    locMenu.classList.remove('hidden');
                    locMenu.offsetHeight; // trigger reflow
                    locMenu.classList.remove('scale-95', 'opacity-0');
                    locMenu.classList.add('scale-100', 'opacity-100');
                    locCaret.classList.add('rotate-180');
                }

                function closeLocationMenu() {
                    locMenu.classList.remove('scale-100', 'opacity-100');
                    locMenu.classList.add('scale-95', 'opacity-0');
                    locCaret.classList.remove('rotate-180');
                    setTimeout(() => {
                        locMenu.classList.add('hidden');
                    }, 200);
                }

                locOptions.forEach(opt => {
                    opt.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = opt.getAttribute('data-value');
                        const optHtml = opt.querySelector('.flex-grow span').textContent.trim();
                        const optIcon = opt.querySelector('i').className;

                        locInput.value = val;

                        let iconColor = 'text-usu-green';
                        if (val === 'all') iconColor = 'text-[#106c38]';

                        locLabel.innerHTML = `
                            <i class="${optIcon} ${iconColor} text-lg"></i>
                            <span>${optHtml}</span>
                        `;

                        locOptions.forEach(o => {
                            const chk = o.querySelector('.option-check');
                            if (o === opt) {
                                chk.classList.remove('hidden');
                            } else {
                                chk.classList.add('hidden');
                            }
                        });

                        closeLocationMenu();
                        window.performSearch();
                    });
                });

                window.closeLocationMenu = closeLocationMenu;
            }

            // Close all dropdowns when clicking outside
            document.addEventListener('click', () => {
                if (window.closeCoverMenu) window.closeCoverMenu();
                if (window.closeLocationMenu) window.closeLocationMenu();
            });

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
                        window.performSearch();
                    }, 300);
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    clearBtn.classList.add('hidden');
                    window.performSearch();
                });
            }

            if (searchForm) {
                searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    window.performSearch();
                });
            }
        });

        // Modal functions for Uploading and Reordering Cover/Gallery images (Max 4 images)
        let slots = [];
        let uploadedNewFiles = [];
        let draggedSlotIndex = null;
        let activeReplaceIndex = null;

        function initSortable() {
            const grid = document.getElementById('image-slots-grid');
            if (window.sortableInstance) {
                window.sortableInstance.destroy();
            }
            window.sortableInstance = new Sortable(grid, {
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: function (evt) {
                    const oldIndex = evt.oldIndex;
                    const newIndex = evt.newIndex;
                    
                    if (oldIndex !== newIndex) {
                        // Swap or move items in slots array
                        const movedItem = slots.splice(oldIndex, 1)[0];
                        slots.splice(newIndex, 0, movedItem);
                        
                        // Re-render and update hidden inputs
                        reRenderSlots();
                        updateFormOrder();
                    }
                }
            });
        }

        function reRenderSlots() {
            const grid = document.getElementById('image-slots-grid');
            if (!grid) return;

            grid.innerHTML = '';

            if (slots.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center text-slate-400 gap-1.5 py-8">
                        <i class="ph ph-image-square text-4xl text-slate-300"></i>
                        <span class="text-xs font-semibold text-slate-500">Belum ada gambar yang dipilih</span>
                        <span class="text-[10px] text-slate-400">Silakan klik tombol unggah di atas atau seret foto ke sini</span>
                    </div>
                `;
                return;
            }

            slots.forEach((item, index) => {
                const slotCard = document.createElement('div');
                slotCard.className = `relative aspect-[3/4] rounded-2xl border border-slate-200 bg-slate-900 flex flex-col items-center justify-center overflow-hidden transition-all duration-200 select-none cursor-grab`;
                slotCard.setAttribute('data-index', index);

                // Slot header/badge text
                let badgeText = "Gambar Tambahan";
                if (index === 0) badgeText = "Cover Utama";

                // Image source
                let imgSrc = '';
                if (item.type === 'existing') {
                    imgSrc = item.path;
                } else if (item.type === 'new') {
                    imgSrc = URL.createObjectURL(item.file);
                }

                slotCard.innerHTML = `
                    <!-- Full Image Preview -->
                    <img src="${imgSrc}" class="w-full h-full object-contain pointer-events-none">
                    
                    <!-- Badge -->
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold ${index === 0 ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-800/80 text-slate-100'} select-none pointer-events-none">
                        ${badgeText}
                    </span>

                    <!-- Hover Replace Overlay -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[10px] font-extrabold text-center gap-1 cursor-pointer">
                        <i class="ph ph-pencil-simple text-sm"></i>
                        Ganti Gambar
                    </div>

                    <!-- Delete Button -->
                    <button type="button" onclick="event.stopPropagation(); removeImageFromSlot(${index})" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center border-none shadow-md cursor-pointer transition z-10">
                        <i class="ph ph-trash text-xs"></i>
                    </button>
                `;

                // Click to replace image file picker trigger
                slotCard.addEventListener('click', (e) => {
                    if (e.target.closest('button')) return;
                    activeReplaceIndex = index;
                    document.getElementById('replace-file-picker').click();
                });

                grid.appendChild(slotCard);
            });
            
            // Re-initialize Sortable after rendering
            initSortable();
        }

        window.removeImageFromSlot = function(index) {
            slots.splice(index, 1);
            reRenderSlots();
            updateFormOrder();
        };

        function updateFormOrder() {
            // Re-index new files based on their current order in slots
            // This is crucial because DataTransfer appends files in the loop order,
            // so the backend index must match the loop index.
            let newFileCounter = 0;
            
            const orderData = slots.map(item => {
                if (item.type === 'existing') {
                    return { type: 'existing', path: item.path };
                }
                if (item.type === 'new') {
                    const currentIndex = newFileCounter;
                    newFileCounter++;
                    return { type: 'new', index: currentIndex };
                }
            });

            document.getElementById('modal-image-order-input').value = JSON.stringify(orderData);

            // Sync new files array to new_files[] file input using DataTransfer
            const dt = new DataTransfer();
            slots.forEach(item => {
                if (item.type === 'new') {
                    const file = item.file;
                    if (file) dt.items.add(file);
                }
            });
            document.getElementById('modal-file-input').files = dt.files;
        }

        window.openUploadCoverModal = function(button) {
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const author = button.getAttribute('data-author');
            const coverUrl = button.getAttribute('data-cover');
            const additional = JSON.parse(button.getAttribute('data-additional') || '[]');

            const modal = document.getElementById('upload-cover-modal');
            const card = document.getElementById('upload-cover-card');
            const form = document.getElementById('modal-upload-form');
            
            // Set form action dynamically
            form.action = "{{ url('admin/books') }}/" + id;

            // Set hidden inputs
            document.getElementById('modal-book-title-val').value = title;
            document.getElementById('modal-book-author-val').value = author;

            // Set UI text
            document.getElementById('modal-book-title').innerText = title;
            document.getElementById('modal-book-author').innerText = "oleh " + author;
            document.getElementById('modal-title-action').innerText = coverUrl ? "Atur Gambar & Cover Buku" : "Tambah Gambar & Cover Buku";

            // Initialize slot state
            slots = [];
            uploadedNewFiles = [];

            if (coverUrl) {
                slots.push({ type: 'existing', path: coverUrl });
            }
            
            additional.forEach((url, i) => {
                slots.push({ type: 'existing', path: url });
            });

            reRenderSlots();
            updateFormOrder();

            // Show Modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        };

        window.closeUploadCoverModal = function() {
            const modal = document.getElementById('upload-cover-modal');
            const card = document.getElementById('upload-cover-card');
            
            if (!modal || !card) return;
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        };

        // File picker triggers, drag & drop, and form submit validation
        document.addEventListener('DOMContentLoaded', () => {
            const uploadZone = document.getElementById('modal-multiple-upload-zone');
            const multipleFilePicker = document.getElementById('multiple-file-picker');
            const replaceFilePicker = document.getElementById('replace-file-picker');
            const uploadForm = document.getElementById('modal-upload-form');

            // Individual Image Replacement Picker
            if (replaceFilePicker) {
                replaceFilePicker.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file && activeReplaceIndex !== null && file.type.startsWith('image/')) {
                        uploadedNewFiles.push(file);
                        slots[activeReplaceIndex] = {
                            type: 'new',
                            file: file,
                            index: uploadedNewFiles.length - 1
                        };
                        activeReplaceIndex = null;
                        reRenderSlots();
                        updateFormOrder();
                    }
                    replaceFilePicker.value = ''; // Reset
                });
            }

            // Form Submit Validation & AJAX Submission
            if (uploadForm) {
                uploadForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    if (slots.length === 0) {
                        alert('Harap unggah minimal 1 gambar sebagai cover utama!');
                        return;
                    }

                    const submitBtn = uploadForm.querySelector('button[type="submit"]');
                    const originalBtnHTML = submitBtn.innerHTML;
                    
                    // Show Loading UI on button
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="ph ph-spinner animate-spin text-base"></i> Menyimpan...';
                    
                    // Show loading toast
                    let toast = document.getElementById('loading-toast');
                    if (!toast) {
                        toast = document.createElement('div');
                        toast.id = 'loading-toast';
                        toast.className = 'fixed top-5 left-1/2 transform -translate-x-1/2 z-[99999] bg-white border border-blue-200 rounded-2xl shadow-xl flex items-center p-4 gap-3 transition-all duration-300 pointer-events-none';
                        toast.innerHTML = `
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-spinner animate-spin text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Menyimpan...</h4>
                                <p class="text-[11px] text-slate-500 mt-0.5">Mohon tunggu sebentar, sedang mengunggah gambar.</p>
                            </div>
                        `;
                        document.body.appendChild(toast);
                    } else {
                        toast.classList.remove('hidden');
                    }

                    // Perform AJAX Submission
                    try {
                        const formData = new FormData(uploadForm);
                        // Add method spoofing for Laravel PUT
                        formData.append('_method', 'PUT');

                        const response = await fetch(uploadForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok || response.redirected) {
                            window.location.reload();
                        } else {
                            throw new Error('Gagal menyimpan data.');
                        }
                    } catch (error) {
                        alert(error.message);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHTML;
                        if (toast) toast.classList.add('hidden');
                    }
                });
            }

            if (uploadZone && multipleFilePicker) {
                // Click to upload
                uploadZone.addEventListener('click', () => {
                    multipleFilePicker.click();
                });

                multipleFilePicker.addEventListener('change', (e) => {
                    const files = Array.from(e.target.files);
                    if (files.length > 0) {
                        let slotsUpdated = false;
                        files.forEach(file => {
                            if (slots.length < 4 && file.type.startsWith('image/')) {
                                uploadedNewFiles.push(file);
                                slots.push({
                                    type: 'new',
                                    file: file,
                                    index: uploadedNewFiles.length - 1
                                });
                                slotsUpdated = true;
                            }
                        });

                        if (slotsUpdated) {
                            reRenderSlots();
                            updateFormOrder();
                        } else if (slots.length >= 4) {
                            alert('Maksimal total gambar adalah 4 foto buku!');
                        }
                    }
                    multipleFilePicker.value = ''; // Reset
                });

                // Drop files onto upload zone
                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        uploadZone.classList.add('bg-green-50/70', 'border-[#106c38]');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    uploadZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        uploadZone.classList.remove('bg-green-50/70', 'border-[#106c38]');
                    }, false);
                });

                uploadZone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadZone.classList.remove('bg-green-50/70', 'border-[#106c38]');
                    
                    if (e.dataTransfer.types.includes('Files')) {
                        const files = Array.from(e.dataTransfer.files);
                        if (files.length > 0) {
                            let slotsUpdated = false;
                            files.forEach(file => {
                                if (slots.length < 4 && file.type.startsWith('image/')) {
                                    uploadedNewFiles.push(file);
                                    slots.push({
                                        type: 'new',
                                        file: file,
                                        index: uploadedNewFiles.length - 1
                                    });
                                    slotsUpdated = true;
                                }
                            });

                            if (slotsUpdated) {
                                reRenderSlots();
                                updateFormOrder();
                            } else if (slots.length >= 4) {
                                alert('Maksimal total gambar adalah 4 foto buku!');
                            }
                        }
                    }
                }, false);
            }
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

        // Global Book Cover Deletion Handler
        window.confirmDeleteCover = function(button) {
            const form = button.closest('form');
            if (form) {
                showCustomConfirm('Apakah Anda yakin ingin menghapus gambar cover untuk buku ini? (Cover akan dikembalikan ke gambar default)', () => {
                    form.submit();
                });
            }
        };

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
        });
    </script>

    <!-- Upload Cover Modal -->
    <div id="upload-cover-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeUploadCoverModal()"></div>
        
        <!-- Modal Content Card -->
        <div class="relative bg-white rounded-3xl max-w-3xl w-full p-6 shadow-2xl border border-slate-100 transform transition-all scale-95 opacity-0 duration-200" id="upload-cover-card">
            <div class="flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="ph ph-image text-usu-green text-2xl"></i>
                        <span id="modal-title-action">Atur Gambar & Cover Buku</span>
                    </h3>
                    <button type="button" onclick="closeUploadCoverModal()" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition flex items-center justify-center border-none cursor-pointer">
                        <i class="ph ph-x text-lg"></i>
                    </button>
                </div>
                
                <!-- Form -->
                <form id="modal-upload-form" action="" method="POST" enctype="multipart/form-data" class="mt-4 flex flex-col gap-4">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden elements needed for Laravel's controller validation requirements -->
                    <input type="hidden" name="title" id="modal-book-title-val">
                    <input type="hidden" name="author" id="modal-book-author-val">

                    <!-- Book Information Info Card -->
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Buku yang Dipilih</span>
                        <h4 id="modal-book-title" class="text-sm font-bold text-slate-800 mt-1 leading-snug"></h4>
                        <span id="modal-book-author" class="text-xs text-slate-500 font-medium mt-0.5 block"></span>
                    </div>

                    <!-- Cover Upload Area -->
                    <div class="flex flex-col gap-3">
                        <!-- Large, prominent upload button area -->
                        <div class="w-full py-8 bg-green-50/30 hover:bg-green-50/60 border-2 border-dashed border-[#106c38] rounded-3xl flex flex-col items-center justify-center gap-3 cursor-pointer transition-all duration-200 text-center shadow-sm" id="modal-multiple-upload-zone">
                            <i class="ph ph-cloud-arrow-up text-5xl text-[#106c38]"></i>
                            <div class="px-4">
                                <h4 class="text-sm font-extrabold text-slate-800">Klik di Sini untuk Mengunggah Foto Buku</h4>
                                <p class="text-xs text-slate-500 mt-1 font-medium">Bisa memilih banyak foto sekaligus (Maksimal 4 Gambar)</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-medium">Mendukung format JPG, PNG, GIF (Maks. 20MB per berkas)</p>
                            </div>
                        </div>

                        <!-- Hidden inputs for form submit -->
                        <input type="hidden" name="image_order_json" id="modal-image-order-input">
                        <!-- Multiple file input to send all new uploaded files -->
                        <input type="file" name="new_files[]" id="modal-file-input" multiple class="hidden">
                        <!-- Temporary multiple picker & single replace picker triggered programmatically -->
                        <input type="file" id="multiple-file-picker" accept="image/*" multiple class="hidden">
                        <input type="file" id="replace-file-picker" accept="image/*" class="hidden">
                    </div>

                    <!-- Uploaded Previews List -->
                    <div class="flex flex-col gap-2 mt-2">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Urutan Gambar Buku (Seret untuk Mengatur Urutan)</label>
                        
                        <div id="image-slots-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4 min-h-[120px] bg-slate-50/50 p-4 rounded-3xl border border-slate-100">
                            <!-- Previews will be rendered here dynamically via JS -->
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3 mt-4 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeUploadCoverModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-4 rounded-xl transition text-xs border-none cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-[#106c38] hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition text-xs border-none cursor-pointer shadow-md shadow-green-100 flex items-center justify-center gap-1.5">
                            <i class="ph ph-floppy-disk text-base"></i> Simpan Gambar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                <p id="confirm-modal-message" class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus cover untuk buku ini?</p>
                
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
