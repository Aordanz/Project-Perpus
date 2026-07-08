<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Galeri Pustakawan - Portal Admin OPAC USU</title>

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
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="ph ph-images text-usu-green text-3xl"></i>
                    <span>Galeri Pustakawan</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Pantau seluruh koleksi buku dalam tampilan galeri. Mudah untuk melihat sampul dan status ketersediaan.</p>
            </div>
            
            <form id="gallery-search-form" action="{{ route('admin.galeri') }}" method="GET" class="w-full sm:w-64 relative flex items-center">
                <input type="hidden" name="limit" id="admin-limit-select" value="{{ request('limit', 10) }}">
                <div class="absolute left-3.5 text-slate-400">
                    <i class="ph ph-magnifying-glass text-lg"></i>
                </div>
                <input type="text" name="search" id="gallery-search-input" value="{{ request('search') }}" placeholder="Cari buku..." class="w-full pl-10 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-sm outline-none transition focus:border-usu-green focus:ring-4 focus:ring-[#106c38]/10 font-medium">
                <button type="button" id="clear-search-btn" class="absolute right-3.5 text-slate-400 hover:text-slate-600 {{ request('search') ? '' : 'hidden' }} bg-transparent border-none cursor-pointer p-0 flex items-center">
                    <i class="ph ph-x-circle text-base"></i>
                </button>
            </form>
        </div>

        <!-- Book Gallery Grid Container -->
        <div id="gallery-container" class="transition-opacity duration-200">
            @include('admin.partials.gallery_grid')
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
        document.addEventListener('DOMContentLoaded', () => {
            const searchForm = document.getElementById('gallery-search-form');
            const searchInput = document.getElementById('gallery-search-input');
            const clearBtn = document.getElementById('clear-search-btn');
            const galleryContainer = document.getElementById('gallery-container');
            
            let debounceTimer;
            
            window.performSearch = function(url = null) {
                if (!url) {
                    const query = encodeURIComponent(searchInput.value);
                    const limitVal = document.getElementById('admin-limit-select') ? document.getElementById('admin-limit-select').value : '10';
                    url = `${searchForm.action}?search=${query}&limit=${limitVal}`;
                }
                
                if (galleryContainer) {
                    galleryContainer.style.opacity = '0.5';
                    galleryContainer.style.pointerEvents = 'none';
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
                    if (galleryContainer) {
                        galleryContainer.innerHTML = html;
                        galleryContainer.style.opacity = '1';
                        galleryContainer.style.pointerEvents = 'auto';
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
                    if (galleryContainer) {
                        galleryContainer.style.opacity = '1';
                        galleryContainer.style.pointerEvents = 'auto';
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
            
            if (galleryContainer) {
                galleryContainer.addEventListener('click', (e) => {
                    const anchor = e.target.closest('a');
                    if (anchor && anchor.href && anchor.href.includes('page=')) {
                        e.preventDefault();
                        window.performSearch(anchor.href);
                    }
                });
            }
        });
    </script>
</body>
</html>
