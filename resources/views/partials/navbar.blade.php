<!-- Navigation -->
<nav class="glass-nav fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-3">
            <!-- Logo & Links -->
            <div class="flex items-center gap-2 sm:gap-4 lg:gap-6 min-w-0 flex-1">
                <!-- USU Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group min-w-0">
                    <img src="{{ asset('logousu.webp') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 object-contain shrink-0">
                    <div class="flex flex-col min-w-0">
                        <span class="font-bold text-white leading-none text-[11px] sm:text-sm group-hover:text-green-200 transition truncate">{{ __('Perpustakaan ') }}</span>
                        <span class="font-bold text-white leading-none text-[10px] sm:text-sm group-hover:text-green-200 transition truncate">{{ __('Universitas Sumatera Utara') }}</span>
                    </div>
                </a>
            </div>

            <!-- Center Navigation Links (Desktop) -->
            <div class="hidden lg:flex space-x-3 xl:space-x-6 items-center justify-center flex-grow mx-2 xl:mx-4 lg:text-xs xl:text-sm">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Beranda') }}</a>
                <a href="{{ route('koleksi.terbaru') }}" class="{{ request()->routeIs('koleksi.terbaru') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Koleksi Terbaru') }}</a>
                <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Galeri') }}</a>
                <a href="{{ route('index-judul') }}" class="{{ request()->routeIs('index-judul') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Index Judul') }}</a>
                <a href="#" class="text-green-100 font-medium hover:text-white transition pb-1 whitespace-nowrap">{{ __('Cek Pinjaman') }}</a>
                <a href="#" id="navbar-event-btn" class="text-green-100 font-medium hover:text-white transition pb-1 whitespace-nowrap cursor-pointer">
                    {{ __('Informasi') }}
                </a>
                <div class="relative group">
                    <button class="text-green-100 font-medium hover:text-white transition flex items-center gap-1 pb-1 whitespace-nowrap cursor-pointer">
                        {{ __('Tautan Lain') }} <i class="ph ph-caret-down"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden border border-slate-100">
                        <a href="https://www.usu.ac.id/" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">{{ __('Universitas Sumatera Utara') }}</a>
                        <a href="https://library.usu.ac.id/id" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">{{ __('Perpustakaan') }}</a>
                        <a href="https://repositori.usu.ac.id/" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">USU-IR</a>
                        <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">{{ __('Scientific eJournals') }}</a>
                        <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">{{ __('Scientific eBooks') }}</a>
                    </div>
                </div>
                
                <!-- Spacer -->
                <div class="w-4 lg:w-8 xl:w-12"></div>

                <a href="{{ route('bantuan') }}" class="{{ request()->routeIs('bantuan') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Bantuan') }}</a>
                <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Kontak Kami') }}</a>
            </div>
            
            <!-- Right Side (Desktop) -->
            <div class="hidden lg:flex space-x-4 xl:space-x-5 items-center flex-shrink-0 lg:text-xs xl:text-sm">
                <!-- Language Dropdown -->
                <div class="relative group cursor-pointer">
                    <div class="text-green-100 font-medium hover:text-white transition flex items-center gap-1 pb-1">
                        <i class="ph ph-translate text-lg"></i> {{ __('Bahasa') }} <i class="ph ph-caret-down"></i>
                    </div>
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden border border-slate-100">
                        <a href="{{ url('/lang/id') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition {{ session('locale') === 'id' || !session('locale') ? 'font-bold bg-green-50 text-[#106c38]' : '' }}">Indonesia</a>
                        <a href="{{ url('/lang/en') }}" class="block px-4 py-2.5 text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition {{ session('locale') === 'en' ? 'font-bold bg-green-50 text-[#106c38]' : '' }}">English</a>
                    </div>
                </div>


            </div>

            <!-- Mobile Hamburger Button -->
            <button id="mobile-menu-btn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl text-white bg-white/15 hover:bg-white/25 active:scale-95 transition cursor-pointer shrink-0" aria-label="Menu">
                <i class="ph ph-list text-2xl" id="mobile-menu-icon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Slide-Out Menu -->
    <div id="mobile-menu-panel" class="lg:hidden fixed inset-0 z-[60] pointer-events-none">
        <!-- Backdrop -->
        <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
        <!-- Panel -->
        <div id="mobile-menu-drawer" class="absolute top-0 right-0 h-full w-[280px] sm:w-[320px] bg-[#106c38] transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl overflow-y-auto">
            <!-- Close Button -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
                <span class="text-white font-bold text-sm tracking-wide">{{ __('Menu') }}</span>
                <button id="mobile-menu-close" aria-label="{{ __('Tutup Menu') }}" class="w-9 h-9 rounded-lg flex items-center justify-center text-white hover:bg-white/10 transition cursor-pointer">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>
            <!-- Navigation Links -->
            <div class="flex flex-col py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('home') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-house text-lg"></i> {{ __('Beranda') }}
                </a>
                <a href="{{ route('koleksi.terbaru') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('koleksi.terbaru') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-book-open text-lg"></i> {{ __('Koleksi Terbaru') }}
                </a>
                <a href="{{ route('galeri') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('galeri') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-squares-four text-lg"></i> {{ __('Galeri') }}
                </a>
                <a href="{{ route('index-judul') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('index-judul') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-list-bullets text-lg"></i> {{ __('Index Judul') }}
                </a>
                <a href="#" class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-clipboard-text text-lg"></i> {{ __('Cek Pinjaman') }}
                </a>
                <a href="#" id="mobile-navbar-event-btn" class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-green-100 hover:text-white hover:bg-white/5 transition cursor-pointer">
                    <i class="ph ph-megaphone text-lg"></i> {{ __('Informasi') }}
                </a>

                <div class="border-t border-white/10 my-2"></div>
                <span class="px-5 py-2 text-[10px] font-bold uppercase tracking-widest text-green-300/60">{{ __('Tautan Lain') }}</span>
                <a href="https://www.usu.ac.id/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-globe text-base"></i> {{ __('Universitas Sumatera Utara') }}
                </a>
                <a href="https://library.usu.ac.id/id" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-buildings text-base"></i> {{ __('Perpustakaan') }}
                </a>
                <a href="https://repositori.usu.ac.id/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-database text-base"></i> USU-IR
                </a>
                <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-article text-base"></i> {{ __('Scientific eJournals') }}
                </a>
                <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-book text-base"></i> {{ __('Scientific eBooks') }}
                </a>

                <div class="border-t border-white/10 my-2"></div>
                <a href="{{ route('bantuan') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('bantuan') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-question text-lg"></i> {{ __('Bantuan') }}
                </a>
                <a href="{{ route('kontak') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-medium {{ request()->routeIs('kontak') ? 'text-white bg-white/10 font-bold' : 'text-green-100 hover:text-white hover:bg-white/5' }} transition">
                    <i class="ph ph-envelope text-lg"></i> {{ __('Kontak Kami') }}
                </a>

                <!-- Language Switcher -->
                <div class="border-t border-white/10 my-2"></div>
                <span class="px-5 py-2 text-[10px] font-bold uppercase tracking-widest text-green-300/60">{{ __('Bahasa') }}</span>
                <div class="flex gap-2 px-5 py-2">
                    <a href="{{ url('/lang/id') }}" class="flex-1 text-center py-2 rounded-lg text-xs font-bold transition {{ session('locale') === 'id' || !session('locale') ? 'bg-white text-[#106c38]' : 'bg-white/10 text-green-100 hover:bg-white/20' }}">Indonesia</a>
                    <a href="{{ url('/lang/en') }}" class="flex-1 text-center py-2 rounded-lg text-xs font-bold transition {{ session('locale') === 'en' ? 'bg-white text-[#106c38]' : 'bg-white/10 text-green-100 hover:bg-white/20' }}">English</a>
                </div>



                <!-- Footer / Social Elements -->
                <div class="border-t border-white/10 mt-6 pt-4 pb-6 px-5 flex flex-col items-center gap-3">
                    <div class="flex items-center gap-3">
                        <a href="https://library.usu.ac.id/" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition" aria-label="Website">
                            <i class="ph ph-globe text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/usu.library/" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition" aria-label="Instagram">
                            <i class="ph ph-instagram-logo text-lg"></i>
                        </a>
                    </div>
                    <span class="text-[10px] text-green-200/50 text-center font-medium font-sans">
                        &copy; 2026 {{ __('Perpustakaan USU') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('mobile-menu-btn');
        const menuPanel = document.getElementById('mobile-menu-panel');
        const menuBackdrop = document.getElementById('mobile-menu-backdrop');
        const menuDrawer = document.getElementById('mobile-menu-drawer');
        const menuClose = document.getElementById('mobile-menu-close');
        const menuIcon = document.getElementById('mobile-menu-icon');

        function openMenu() {
            menuPanel.classList.remove('pointer-events-none');
            menuBackdrop.classList.remove('opacity-0');
            menuBackdrop.classList.add('opacity-100');
            menuDrawer.classList.remove('translate-x-full');
            menuDrawer.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            menuBackdrop.classList.remove('opacity-100');
            menuBackdrop.classList.add('opacity-0');
            menuDrawer.classList.remove('translate-x-0');
            menuDrawer.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => menuPanel.classList.add('pointer-events-none'), 300);
        }

        // Close menu function exported for event popup
        window.closeMobileMenu = closeMenu;

        if (menuBtn) menuBtn.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        if (menuBackdrop) menuBackdrop.addEventListener('click', closeMenu);
    });
</script>

<!-- Event Popup Modal -->
<div id="event-popup-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4 sm:p-6 transition-all duration-300">
    <div class="bg-white rounded-[24px] shadow-2xl relative overflow-hidden w-full max-w-[860px] h-auto max-h-[85vh] md:h-[500px] my-auto transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col animate-in fade-in duration-300" id="event-popup-content">
        <!-- Close Button (Fixed) -->
        <button id="close-event-popup" class="absolute top-3 right-3 sm:top-4 sm:right-4 z-50 text-slate-700 md:text-slate-500 bg-white/85 md:bg-slate-100/90 hover:bg-white md:hover:bg-slate-200 rounded-full p-2 flex items-center justify-center transition cursor-pointer shadow-md border border-slate-200/80 hover:scale-105 backdrop-blur-md">
            <i class="ph ph-x text-lg font-bold"></i>
        </button>

        <!-- Slider Track Container (Main Content Area) -->
        <div class="w-full flex-1 relative overflow-hidden min-h-0">
            <!-- Slides Track -->
            <div id="event-slider-track" class="flex flex-nowrap h-full w-full">
                <!-- Slides will be inserted dynamically -->
            </div>
        </div>

        <!-- Global Modal Footer -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 px-5 sm:px-6 md:px-8 py-3.5 border-t border-slate-100 bg-slate-50/50 relative overflow-hidden select-none shrink-0 rounded-b-[24px]">
            <!-- Checkbox: Jangan Tampilkan Lagi -->
            <div class="flex items-center gap-2 z-20">
                <input type="checkbox" id="global-dont-show-checkbox" class="w-4 h-4 text-[#106c38] border-slate-300 rounded focus:ring-[#106c38] cursor-pointer">
                <label for="global-dont-show-checkbox" class="text-[11px] md:text-xs text-slate-600 font-semibold cursor-pointer hover:text-slate-800 transition">
                    {{ __('Jangan tampilkan lagi hari ini') }}
                </label>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="event-pagination-container" class="flex items-center gap-3 z-20 bg-emerald-50 px-3 sm:px-4 py-1.5 rounded-full border border-emerald-100 shadow-sm hidden">
                <button id="prev-event-btn-floating" type="button" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white hover:bg-[#106c38] text-[#106c38] hover:text-white flex items-center justify-center transition-all cursor-pointer hidden shadow border border-[#106c38]/20 group">
                    <i class="ph ph-caret-left font-bold text-base group-hover:-translate-x-0.5 transition-transform"></i>
                </button>
                <span id="event-pagination-text" class="text-xs sm:text-[13px] font-black text-[#106c38] tracking-widest w-8 sm:w-10 text-center">1 / 3</span>
                <button id="next-event-btn-floating" type="button" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#106c38] hover:bg-[#0c562c] text-white flex items-center justify-center transition-all cursor-pointer hidden shadow-md shadow-[#106c38]/30 group animate-pulse hover:animate-none">
                    <i class="ph ph-caret-right font-bold text-base group-hover:translate-x-0.5 transition-transform"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 for empty notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventModal = document.getElementById('event-popup-modal');
        const eventContent = document.getElementById('event-popup-content');
        const closeEventBtn = document.getElementById('close-event-popup');
        const sliderTrack = document.getElementById('event-slider-track');
        const prevBtn = document.getElementById('prev-event-btn-floating');
        const nextBtn = document.getElementById('next-event-btn-floating');
        const paginationText = document.getElementById('event-pagination-text');
        const globalDontShowCheckbox = document.getElementById('global-dont-show-checkbox');
        
        const navbarEventBtn = document.getElementById('navbar-event-btn');
        const mobileNavbarEventBtn = document.getElementById('mobile-navbar-event-btn');

        window.logoUsuUrl = "{{ asset('logousu.webp') }}";
        window.assetRoot = "{{ asset('') }}";
        window.currentLocale = "{{ app()->getLocale() }}";

        let loadedEvents = [];
        let currentSlideIndex = 0;

        // Auto-show & Auto-hide Timer Variables
        let autoShowTimeout = null;
        let autoHideTimer = null;
        let remainingTime = 8000; // 8 seconds
        let timerStartedAt = null;
        let isPaused = false;
        let autoHideDisabled = false;

        // Fetch active events
        fetch('/api/events/active')
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data && res.data.length > 0) {
                    loadedEvents = res.data;
                    
                    // Render slides
                    let slidesHtml = '';

                    loadedEvents.forEach((event) => {
                        const cat = event.category || 'general';

                        // ─── Category Theme Config ─────────────────────────────────
                        let badgeLabel, badgeIcon, badgeCls, rightGrad, rightOverlay, accentColor;

                        if (cat === 'event') {
                            badgeLabel = 'EVENT / KEGIATAN'; badgeIcon = 'ph-calendar-check';
                            badgeCls = 'bg-emerald-50 text-[#106c38] border-emerald-200';
                            rightGrad = 'linear-gradient(150deg,#04200f,#0c4825,#167c45)';
                            rightOverlay = 'rgba(4,32,15,0.18)'; accentColor = 'green';
                        } else if (cat === 'announcement') {
                            badgeLabel = 'PENGUMUMAN'; badgeIcon = 'ph-megaphone-simple';
                            badgeCls = 'bg-blue-50 text-blue-700 border-blue-200';
                            rightGrad = 'linear-gradient(150deg,#0c1e5c,#1d4ed8,#3b82f6)';
                            rightOverlay = 'rgba(12,30,92,0.3)'; accentColor = 'blue';
                        } else if (cat === 'maintenance') {
                            badgeLabel = 'PEMELIHARAAN'; badgeIcon = 'ph-wrench';
                            badgeCls = 'bg-red-50 text-red-700 border-red-200';
                            rightGrad = 'linear-gradient(150deg,#500c0c,#b91c1c,#f87171)';
                            rightOverlay = 'rgba(80,12,12,0.35)'; accentColor = 'red';
                        } else if (cat === 'new_collection') {
                            badgeLabel = 'BUKU BARU'; badgeIcon = 'ph-book-open';
                            badgeCls = 'bg-purple-50 text-purple-700 border-purple-200';
                            rightGrad = 'linear-gradient(150deg,#1e0640,#5b21b6,#8b5cf6)';
                            rightOverlay = 'rgba(30,6,64,0.45)'; accentColor = 'purple';
                        } else if (cat === 'tips') {
                            badgeLabel = 'TIPS & TRIK'; badgeIcon = 'ph-lightbulb-filament';
                            badgeCls = 'bg-amber-50 text-amber-700 border-amber-200';
                            rightGrad = 'linear-gradient(150deg,#431407,#c2410c,#f59e0b)';
                            rightOverlay = 'rgba(67,20,7,0.3)'; accentColor = 'amber';
                        } else if (cat === 'promotion') {
                            badgeLabel = 'PROMO SPESIAL'; badgeIcon = 'ph-tag';
                            badgeCls = 'bg-orange-50 text-orange-700 border-orange-200';
                            rightGrad = 'linear-gradient(150deg,#7c1d0c,#c2410c,#fb923c)';
                            rightOverlay = 'rgba(124,29,12,0.28)'; accentColor = 'orange';
                        } else {
                            badgeLabel = 'INFORMASI'; badgeIcon = 'ph-info';
                            badgeCls = 'bg-slate-100 text-slate-600 border-slate-200';
                            rightGrad = 'linear-gradient(150deg,#0f172a,#1e293b,#334155)';
                            rightOverlay = 'rgba(15,23,42,0.2)'; accentColor = 'green';
                        }

                        // ─── Accent Button Color ───────────────────────────────────
                        let accentBtnCls = 'bg-[#106c38] hover:bg-[#0e5e30] text-white';
                        if (accentColor === 'blue')   accentBtnCls = 'bg-blue-600 hover:bg-blue-700 text-white';
                        if (accentColor === 'purple') accentBtnCls = 'bg-purple-600 hover:bg-purple-700 text-white';
                        if (accentColor === 'amber')  accentBtnCls = 'bg-amber-500 hover:bg-amber-600 text-white';
                        if (accentColor === 'orange') accentBtnCls = 'bg-orange-600 hover:bg-orange-700 text-white';
                        if (accentColor === 'red')    accentBtnCls = 'bg-red-600 hover:bg-red-700 text-white';

                        // ─── Category Detail Content ───────────────────────────────
                        let detailHtml = '';
                        let showDesc = true;
                        let actionLinks = (event.action_buttons && Array.isArray(event.action_buttons) && event.action_buttons.length > 0)
                            ? event.action_buttons : null;

                        if (cat === 'event') {
                            detailHtml = `
                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-2.5">
                                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0"><i class="ph ph-calendar-blank text-[#106c38] text-sm"></i></div>
                                        <div class="min-w-0"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-0.5">Tanggal</p><p class="text-[10.5px] font-bold text-slate-800 leading-tight truncate">${event.date_text || '-'}</p></div>
                                    </div>
                                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-2.5">
                                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0"><i class="ph ph-clock text-[#106c38] text-sm"></i></div>
                                        <div class="min-w-0"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-0.5">Waktu</p><p class="text-[10.5px] font-bold text-slate-800 leading-tight truncate">${event.time || '-'}</p></div>
                                    </div>
                                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-2.5">
                                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0"><i class="ph ph-map-pin text-[#106c38] text-sm"></i></div>
                                        <div class="min-w-0"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-0.5">Lokasi</p><p class="text-[10.5px] font-bold text-slate-800 leading-tight truncate">${event.location || '-'}</p></div>
                                    </div>
                                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl p-2.5">
                                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0"><i class="ph ph-users text-[#106c38] text-sm"></i></div>
                                        <div class="min-w-0"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-0.5">Penyelenggara</p><p class="text-[10.5px] font-bold text-slate-800 leading-tight truncate">${event.organizer || '-'}</p></div>
                                    </div>
                                </div>
                                ${(event.left_features && Array.isArray(event.left_features) && event.left_features.length > 0) ? `
                                    <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-3 mb-3">
                                        <p class="text-[9px] font-black text-emerald-800 uppercase tracking-wider mb-1.5">Informasi Tambahan</p>
                                        <ul class="space-y-1">
                                            ${event.left_features.map(feat => `
                                                <li class="flex items-center gap-2 text-xs font-bold text-slate-700">
                                                    <i class="ph ph-check text-emerald-600 font-bold text-xs"></i>
                                                    <span>${feat}</span>
                                                </li>
                                            `).join('')}
                                        </ul>
                                    </div>
                                ` : ''}
                                ${(event.contact_whatsapp || event.contact_email) ? `<div class="flex items-center gap-2.5 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 mb-1"><span class="text-[8px] font-black text-slate-400 uppercase tracking-wide shrink-0">Hubungi Kami</span><div class="flex flex-wrap gap-3 min-w-0">${event.contact_whatsapp ? `<a href="https://wa.me/${event.contact_whatsapp.replace(/[^0-9]/g, '')}" target="_blank" class="flex items-center gap-1.5 hover:opacity-75 transition shrink-0"><div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center"><i class="ph ph-whatsapp-logo text-emerald-600 text-[11px]"></i></div><span class="text-[10px] font-bold text-slate-700">${event.contact_whatsapp}</span></a>` : ''}${event.contact_email ? `<a href="mailto:${event.contact_email}" class="flex items-center gap-1.5 hover:opacity-75 transition shrink-0"><div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center"><i class="ph ph-envelope-simple text-blue-600 text-[11px]"></i></div><span class="text-[10px] font-bold text-slate-700">${event.contact_email}</span></a>` : ''}</div></div>` : ''}
                            `;
                            if (!actionLinks) actionLinks = [{name: 'Lihat Detail', url: event.link_url || event.library_url || 'https://library.usu.ac.id/id', new_tab: true}];

                        } else if (cat === 'announcement') {
                            detailHtml = `
                                <div class="flex flex-wrap gap-2 mb-3">
                                    ${event.date_text ? `<div class="flex items-center gap-1.5 bg-blue-50 border border-blue-100 rounded-lg px-2.5 py-1.5"><i class="ph ph-calendar-blank text-blue-600 text-xs"></i><span class="text-[10.5px] font-bold text-blue-800">${event.date_text}</span></div>` : ''}
                                    ${event.time ? `<div class="flex items-center gap-1.5 bg-blue-50 border border-blue-100 rounded-lg px-2.5 py-1.5"><i class="ph ph-clock text-blue-600 text-xs"></i><span class="text-[10.5px] font-bold text-blue-800">${event.time}</span></div>` : ''}
                                </div>
                                ${event.affected_services ? `<div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-2"><p class="text-[8px] font-black text-blue-400 uppercase tracking-wide mb-1">Dampak Layanan</p><p class="text-[11px] font-bold text-blue-900">${event.affected_services}</p></div>` : ''}
                            `;

                        } else if (cat === 'maintenance') {
                            detailHtml = `
                                <div class="flex items-start gap-2.5 bg-red-50 border border-red-100 rounded-xl p-3 mb-3">
                                    <i class="ph ph-warning text-red-500 text-xl animate-pulse shrink-0 mt-0.5"></i>
                                    <div><p class="text-[8px] font-black text-red-400 uppercase tracking-wide mb-0.5">Layanan Terdampak</p><p class="text-[11px] font-bold text-red-900">${event.affected_services || 'Sistem Perpustakaan'}</p></div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    ${event.date_text ? `<div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide mb-0.5">Tanggal</p><p class="text-[10.5px] font-bold text-slate-800">${event.date_text}</p></div>` : ''}
                                    ${event.time ? `<div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide mb-0.5">Waktu</p><p class="text-[10.5px] font-bold text-slate-800">${event.time}</p></div>` : ''}
                                    ${event.estimated_downtime ? `<div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5 col-span-2"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide mb-0.5">Perkiraan Selesai</p><p class="text-[10.5px] font-bold text-slate-800">${event.estimated_downtime}</p></div>` : ''}
                                </div>
                                ${event.alternative_link ? `<div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5 mb-1"><p class="text-[8px] font-black text-slate-400 uppercase tracking-wide mb-0.5">Akses Alternatif</p><a href="${event.alternative_link}" target="_blank" class="text-[10.5px] font-bold text-blue-600 hover:underline truncate block">${event.alternative_link}</a></div>` : ''}
                            `;

                        } else if (cat === 'new_collection') {
                            detailHtml = `
                                <div class="bg-slate-50 border border-slate-100 rounded-xl overflow-hidden mb-3">
                                    ${event.book_author ? `<div class="flex items-center gap-2.5 px-3 py-2 border-b border-slate-100"><i class="ph ph-user-circle text-purple-500 text-sm shrink-0"></i><span class="text-[8.5px] font-black text-slate-400 uppercase w-14 shrink-0">Penulis</span><span class="text-[10.5px] font-bold text-slate-800 truncate flex-1">${event.book_author}</span></div>` : ''}
                                    ${event.book_publisher ? `<div class="flex items-center gap-2.5 px-3 py-2 border-b border-slate-100"><i class="ph ph-buildings text-purple-500 text-sm shrink-0"></i><span class="text-[8.5px] font-black text-slate-400 uppercase w-14 shrink-0">Penerbit</span><span class="text-[10.5px] font-bold text-slate-800 truncate flex-1">${event.book_publisher}</span></div>` : ''}
                                    ${event.shelf_location ? `<div class="flex items-center gap-2.5 px-3 py-2"><i class="ph ph-map-pin text-purple-500 text-sm shrink-0"></i><span class="text-[8.5px] font-black text-slate-400 uppercase w-14 shrink-0">Lokasi Rak</span><span class="text-[10.5px] font-bold text-slate-800 truncate flex-1">${event.shelf_location}</span></div>` : ''}
                                </div>
                            `;
                            if (!actionLinks) actionLinks = [{name: 'Lihat Detail Buku', url: event.link_url || event.library_url || 'https://library.usu.ac.id/id', new_tab: true}];

                        } else if (cat === 'tips') {
                            const bullets = Array.isArray(event.tips_bullets) && event.tips_bullets.length > 0
                                ? event.tips_bullets
                                : (event.description || '').split(/\n+/).map(l => l.trim()).filter(l => l.length > 8);
                            showDesc = bullets.length < 2;
                            if (bullets.length >= 2) {
                                detailHtml = `<ul class="space-y-2 mb-1">${bullets.slice(0, 5).map(tip => `<li class="flex items-start gap-2.5"><div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5" style="min-width:20px"><i class="ph ph-check-fat text-amber-600" style="font-size:9px"></i></div><span class="text-[11px] text-slate-700 leading-relaxed">${tip}</span></li>`).join('')}</ul>`;
                            }

                        } else if (cat === 'promotion') {
                            detailHtml = `
                                ${event.promo_period ? `<div class="inline-flex items-center gap-2 bg-orange-50 border border-orange-100 rounded-xl px-3 py-2 mb-3"><i class="ph ph-calendar text-orange-500 text-base"></i><div><p class="text-[8px] font-black text-orange-400 uppercase tracking-wide leading-none mb-0.5">Periode Promo</p><p class="text-[11px] font-bold text-orange-900">${event.promo_period}</p></div></div>` : ''}
                                ${event.promo_benefit ? `<div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-2"><p class="text-[8px] font-black text-orange-400 uppercase tracking-wide mb-1.5">Yang Kamu Dapatkan &#127873;</p><p class="text-sm font-black text-orange-900">${event.promo_benefit}</p></div>` : ''}
                            `;
                            if (!actionLinks) actionLinks = [{name: 'Lihat Penawaran', url: event.link_url || event.library_url || '#', new_tab: true}];
                        }

                        // ─── Action Buttons ────────────────────────────────────────
                        let actionsHtml = '';
                        if (actionLinks && actionLinks.length > 0) {
                            actionsHtml = actionLinks.slice(0, 2).map((btn, i) => `
                                <a href="${btn.url}" target="${btn.new_tab !== false ? '_blank' : '_self'}"
                                   class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl font-bold text-[11.5px] transition-all duration-200 shadow-sm hover:shadow-md hover:-translate-y-px ${i === 0 ? accentBtnCls : 'bg-slate-100 hover:bg-slate-200 text-slate-700'}">
                                    <span>${btn.name}</span>
                                    <i class="ph ph-arrow-right text-xs"></i>
                                </a>
                            `).join('');
                        }

                        // ─── Description text (Instagram/TikTok style with Lihat Selengkapnya) ──
                        const cleanDesc = (event.description || '').trim();
                        let descHtml = '';
                        if (cleanDesc) {
                            const isLongDesc = cleanDesc.length > 100;
                            const shortDesc = isLongDesc ? cleanDesc.slice(0, 95) + '...' : cleanDesc;
                            const showMoreText = window.currentLocale === 'en' ? 'Show More' : 'Lihat Selengkapnya';
                            
                            if (isLongDesc) {
                                descHtml = `
                                    <div class="mb-3.5 text-xs sm:text-[13px] text-slate-700 leading-relaxed text-justify break-words [overflow-wrap:anywhere]">
                                        <div class="desc-box max-h-[65px] overflow-hidden transition-all duration-300">
                                            <span class="desc-short inline">${shortDesc}</span>
                                            <span class="desc-full hidden whitespace-pre-line">${cleanDesc}</span>
                                        </div>
                                        <button type="button" class="desc-toggle-btn text-[#106c38] font-bold hover:underline cursor-pointer inline-flex items-center gap-1 text-xs mt-1 transition-all active:scale-95">
                                            <span>${showMoreText}</span>
                                            <i class="ph ph-caret-down text-xs"></i>
                                        </button>
                                    </div>
                                `;
                            } else {
                                descHtml = `
                                    <div class="mb-3.5 text-xs sm:text-[13px] text-slate-700 leading-relaxed text-justify break-words [overflow-wrap:anywhere] whitespace-pre-line max-h-[140px] overflow-y-auto pr-1 custom-scrollbar">
                                        ${cleanDesc}
                                    </div>
                                `;
                            }
                        }

                        // ─── Slide HTML ────────────────────────────────────────────
                        slidesHtml += `
                            <div class="w-full shrink-0 h-auto md:h-full overflow-hidden">
                                <div class="flex flex-col md:flex-row h-auto md:h-full items-stretch">

                                    <!-- ══ LEFT CONTENT PANEL ══ -->
                                    <div class="w-full md:w-[58%] flex flex-col justify-start md:justify-between h-auto md:h-full bg-white z-10">

                                        <!-- Scrollable body -->
                                        <div class="flex-1 overflow-y-auto px-5 sm:px-6 md:px-8 pt-5 sm:pt-6 pb-2 min-h-0 break-words [overflow-wrap:anywhere]">

                                            <!-- Category Badge -->
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full font-black uppercase tracking-wide text-[10px] mb-3 border w-fit ${badgeCls}">
                                                <i class="ph ${badgeIcon} text-sm"></i>
                                                <span>${badgeLabel}</span>
                                            </div>

                                            <!-- Title -->
                                            <h2 class="text-lg sm:text-[19px] md:text-[21px] font-black text-slate-900 leading-tight tracking-tight mb-3 pr-10 md:pr-0 break-words [overflow-wrap:anywhere]">
                                                ${event.title}
                                            </h2>

                                            <!-- Description -->
                                            ${descHtml}

                                            <!-- Category Detail -->
                                            ${detailHtml}

                                        </div>

                                        <!-- Action Button Container -->
                                        ${actionsHtml ? `
                                        <div class="px-5 sm:px-6 md:px-8 pb-4 pt-2 bg-white shrink-0 flex flex-col gap-2">
                                            ${actionsHtml}
                                        </div>` : `<div class="h-2 shrink-0"></div>`}
                                    </div>

                                    <!-- ══ RIGHT / TOP IMAGE PANEL ══ -->
                                    <div class="w-full md:w-[42%] relative overflow-hidden shrink-0 bg-white h-[160px] sm:h-[200px] md:h-full order-first md:order-last">

                                        <!-- Wavy left-edge divider with golden accent (Desktop only) -->
                                        <div class="hidden md:block absolute top-0 h-full z-30 pointer-events-none" style="width: 32%; left: -3px;">
                                            <svg class="h-full w-full" viewBox="0 0 100 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                                <!-- Seamless White Fill Layer -->
                                                <path d="M 0,0 C 55,100 75,250 20,380 C 0,430 35,480 50,500 L 0,500 Z" fill="white" />
                                                <!-- Golden S-Curve Border Line -->
                                                <path d="M 0,0 C 55,100 75,250 20,380 C 0,430 35,480 50,500" fill="none" stroke="#eab308" stroke-width="3.5" vector-effect="non-scaling-stroke" />
                                            </svg>
                                        </div>

                                        <!-- Horizontal Wavy bottom-edge divider with golden accent (Mobile only) -->
                                        <div class="block md:hidden absolute bottom-0 left-0 w-full z-30 pointer-events-none" style="height: 20px;">
                                            <svg class="w-full h-full" viewBox="0 0 500 30" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                                <!-- White Fill Layer -->
                                                <path d="M 0,30 Q 125,5 250,20 T 500,10 L 500,30 L 0,30 Z" fill="white" />
                                                <!-- Golden Curve Line -->
                                                <path d="M 0,28 Q 125,3 250,18 T 500,8" fill="none" stroke="#eab308" stroke-width="3" vector-effect="non-scaling-stroke" />
                                            </svg>
                                        </div>

                                        <!-- Images Slider -->
                                        <div class="absolute inset-0 w-full h-full" id="img-slider-${event.id}">
                                            ${(event.images_url || [event.image_url]).map((img, idx) => `
                                                <img src="${img}"
                                                     alt="${event.title}"
                                                     class="absolute inset-0 w-full h-full transition-opacity duration-500 ${idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'}"
                                                     style="object-fit: ${event.image_fit || 'cover'}; object-position: ${event.image_x !== undefined ? event.image_x : 50}% ${event.image_y !== undefined ? event.image_y : 50}%; transform: scale(${(event.image_scale || 100) / 100});"
                                                     loading="lazy"
                                                     id="img-${event.id}-${idx}"
                                                     onerror="this.onerror=null; this.src='${window.assetRoot}perpustakaan_depan.webp';">
                                            `).join('')}
                                        </div>

                                        <!-- Image Navigation Dots (Only if multiple images) -->
                                        ${(event.images_url && event.images_url.length > 1) ? `
                                            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex gap-2">
                                                ${event.images_url.map((_, idx) => `
                                                    <button type="button" onclick="
                                                        const container = document.getElementById('img-slider-${event.id}');
                                                        const images = container.querySelectorAll('img');
                                                        const dots = this.parentElement.querySelectorAll('button');
                                                        images.forEach((img, i) => {
                                                            if (i === ${idx}) {
                                                                img.classList.remove('opacity-0', 'z-0');
                                                                img.classList.add('opacity-100', 'z-10');
                                                            } else {
                                                                img.classList.add('opacity-0', 'z-0');
                                                                img.classList.remove('opacity-100', 'z-10');
                                                            }
                                                        });
                                                        dots.forEach((dot, i) => {
                                                            if (i === ${idx}) {
                                                                dot.classList.add('bg-white', 'scale-110');
                                                                dot.classList.remove('bg-white/50');
                                                            } else {
                                                                dot.classList.remove('bg-white', 'scale-110');
                                                                dot.classList.add('bg-white/50');
                                                            }
                                                        });
                                                    " class="w-2 h-2 rounded-full transition-all duration-300 ${idx === 0 ? 'bg-white scale-110' : 'bg-white/50 hover:bg-white/75'}"></button>
                                                `).join('')}
                                            </div>
                                        ` : ''}

                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    sliderTrack.innerHTML = slidesHtml;

                    // Initialize slider
                    initSlider();

                    // Check if user chose "Jangan tampilkan lagi hari ini" for today
                    const todayString = new Date().toDateString();
                    let hideToday = false;
                    try {
                        hideToday = (localStorage.getItem('event_popup_hide_date') === todayString);
                    } catch (e) {}

                    // Auto-show delay: 1.5 seconds (only if not hidden for today)
                    if (!hideToday) {
                        autoShowTimeout = setTimeout(() => {
                            openEventModal();
                            // Auto-hide timing: 8 seconds (only for single slide, otherwise let user navigate)
                            if (loadedEvents.length <= 1) {
                                startAutoHideTimer();
                            }
                        }, 1500);
                    }
                } else {
                    // Tampilkan pemberitahuan kosong jika tidak ada informasi
                    sliderTrack.innerHTML = `
                        <div class="w-full shrink-0 h-full overflow-hidden flex flex-col items-center justify-center p-8 bg-white">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <i class="ph ph-info text-5xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-3 text-center">{{ __('Belum Ada Informasi') }}</h3>
                            <p class="text-slate-500 text-[13px] md:text-sm text-center max-w-sm mx-auto leading-relaxed">
                                {{ __('Saat ini belum ada pengumuman, event, atau informasi terbaru dari Perpustakaan Universitas Sumatera Utara.') }}
                            </p>
                        </div>
                    `;
                    // Sembunyikan navigasi slider & checkbox karena tidak diperlukan
                    if (document.getElementById('event-pagination-container')) document.getElementById('event-pagination-container').classList.add('hidden');
                    if (globalDontShowCheckbox) globalDontShowCheckbox.parentElement.classList.add('hidden');
                    
                    // Pastikan tombol informasi di navbar tetap tampil
                    if (navbarEventBtn) navbarEventBtn.classList.remove('hidden');
                    if (mobileNavbarEventBtn) mobileNavbarEventBtn.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error('Failed to fetch active event', err);
            });

        function startAutoHideTimer() {
            if (autoHideDisabled) return;
            isPaused = false;
            timerStartedAt = Date.now();
            autoHideTimer = setTimeout(() => {
                closeEventModal();
            }, remainingTime);
        }

        function pauseAutoHideTimer() {
            if (autoHideDisabled || isPaused || !autoHideTimer) return;
            isPaused = true;
            clearTimeout(autoHideTimer);
            autoHideTimer = null;
            remainingTime -= (Date.now() - timerStartedAt);
            if (remainingTime < 500) remainingTime = 500; // minimum residual time
        }

        function startResumedAutoHideTimer() {
            if (autoHideDisabled || !isPaused) return;
            isPaused = false;
            timerStartedAt = Date.now();
            autoHideTimer = setTimeout(() => {
                closeEventModal();
            }, remainingTime);
        }

        function clearAutoHideTimer() {
            autoHideDisabled = true;
            if (autoHideTimer) {
                clearTimeout(autoHideTimer);
                autoHideTimer = null;
            }
        }

        // Add pause behavior on hover
        if (eventContent) {
            eventContent.addEventListener('mouseenter', pauseAutoHideTimer);
            eventContent.addEventListener('mouseleave', () => {
                if (eventModal.classList.contains('flex') && loadedEvents.length <= 1) {
                    startResumedAutoHideTimer();
                }
            });
        }

        function initSlider() {
            const originalSlides = Array.from(sliderTrack.children);
            const totalSlides = originalSlides.length;
            
            // Set initial pagination text
            paginationText.textContent = `1 / ${totalSlides}`;

            if (totalSlides <= 1) {
                document.getElementById('event-pagination-container').classList.add('hidden');
                if (prevBtn) prevBtn.classList.add('hidden');
                if (nextBtn) nextBtn.classList.add('hidden');
                return;
            }

            document.getElementById('event-pagination-container').classList.remove('hidden');
            if (prevBtn) prevBtn.classList.remove('hidden');
            if (nextBtn) nextBtn.classList.remove('hidden');

            // Clone first and last slide
            const firstClone = originalSlides[0].cloneNode(true);
            const lastClone = originalSlides[totalSlides - 1].cloneNode(true);

            // Append first clone and prepend last clone
            sliderTrack.appendChild(firstClone);
            sliderTrack.insertBefore(lastClone, originalSlides[0]);

            let slideIndex = 1;
            let isTransitioning = false;

            // Positioning without transition
            sliderTrack.style.transition = 'none';
            sliderTrack.style.transform = `translateX(-${slideIndex * 100}%)`;
            // Trigger reflow
            sliderTrack.offsetHeight;

            function updatePagination() {
                let displayIndex = slideIndex;
                if (slideIndex === 0) {
                    displayIndex = totalSlides;
                } else if (slideIndex === totalSlides + 1) {
                    displayIndex = 1;
                }
                paginationText.textContent = `${displayIndex} / ${totalSlides}`;
            }

            function moveToSlide(index) {
                if (isTransitioning) return;
                isTransitioning = true;
                slideIndex = index;
                sliderTrack.style.transition = 'transform 650ms cubic-bezier(0.25, 1, 0.5, 1)';
                sliderTrack.style.transform = `translateX(-${slideIndex * 100}%)`;
                updatePagination();
            }

            prevBtn.onclick = function(e) {
                e.stopPropagation();
                if (isTransitioning) return;
                clearAutoHideTimer();
                moveToSlide(slideIndex - 1);
            };

            nextBtn.onclick = function(e) {
                e.stopPropagation();
                if (isTransitioning) return;
                clearAutoHideTimer();
                moveToSlide(slideIndex + 1);
            };

            sliderTrack.addEventListener('transitionend', (e) => {
                if (e.target !== sliderTrack) return;
                isTransitioning = false;
                if (slideIndex === 0) {
                    sliderTrack.style.transition = 'none';
                    slideIndex = totalSlides;
                    sliderTrack.style.transform = `translateX(-${slideIndex * 100}%)`;
                } else if (slideIndex === totalSlides + 1) {
                    sliderTrack.style.transition = 'none';
                    slideIndex = 1;
                    sliderTrack.style.transform = `translateX(-${slideIndex * 100}%)`;
                }
            });

            // Touch Swipe Support
            let touchStartX = 0;
            let touchEndX = 0;

            sliderTrack.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            sliderTrack.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, { passive: true });

            function handleSwipe() {
                const swipeThreshold = 50; // minimum distance in pixels
                if (touchEndX < touchStartX - swipeThreshold) {
                    // Swipe left -> Next slide
                    if (!isTransitioning) {
                        clearAutoHideTimer();
                        moveToSlide(slideIndex + 1);
                    }
                }
                if (touchEndX > touchStartX + swipeThreshold) {
                    // Swipe right -> Prev slide
                    if (!isTransitioning) {
                        clearAutoHideTimer();
                        moveToSlide(slideIndex - 1);
                    }
                }
            }
        }

        function openEventModal() {
            if (loadedEvents.length === 0) return;

            // Sync checkbox state with localStorage
            if (globalDontShowCheckbox) {
                const todayString = new Date().toDateString();
                try {
                    globalDontShowCheckbox.checked = (localStorage.getItem('event_popup_hide_date') === todayString);
                } catch (e) {}
            }

            eventModal.classList.remove('hidden');
            eventModal.classList.add('flex');
            // Force reflow
            eventModal.offsetHeight;
            eventModal.classList.add('opacity-100');
            eventContent.classList.remove('scale-95', 'opacity-0');
            eventContent.classList.add('scale-100', 'opacity-100');
            document.body.style.overflow = 'hidden';
        }

        function closeEventModal() {
            clearAutoHideTimer();
            if (autoShowTimeout) {
                clearTimeout(autoShowTimeout);
            }
            
            // Check if global don't show checkbox is checked
            if (globalDontShowCheckbox) {
                const todayString = new Date().toDateString();
                try {
                    if (globalDontShowCheckbox.checked) {
                        localStorage.setItem('event_popup_hide_date', todayString);
                    } else {
                        localStorage.removeItem('event_popup_hide_date');
                    }
                } catch (e) {}
            }
            
            eventContent.classList.remove('scale-100', 'opacity-100');
            eventContent.classList.add('scale-95', 'opacity-0');
            eventModal.classList.remove('opacity-100');
            setTimeout(() => {
                eventModal.classList.remove('flex');
                eventModal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        if (globalDontShowCheckbox) {
            globalDontShowCheckbox.addEventListener('change', function() {
                const todayString = new Date().toDateString();
                try {
                    if (this.checked) {
                        localStorage.setItem('event_popup_hide_date', todayString);
                    } else {
                        localStorage.removeItem('event_popup_hide_date');
                    }
                } catch (e) {}
            });
        }

        // Toggle active status for event detail choices & Lihat Selengkapnya description toggle
        if (sliderTrack) {
            sliderTrack.addEventListener('click', function(e) {
                // 1. Description "Lihat Selengkapnya" Toggle
                const toggleBtn = e.target.closest('.desc-toggle-btn');
                if (toggleBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    clearAutoHideTimer();
                    const container = toggleBtn.closest('div');
                    const descBox = container.querySelector('.desc-box');
                    const shortSpan = container.querySelector('.desc-short');
                    const fullSpan = container.querySelector('.desc-full');
                    const isExpanded = fullSpan && !fullSpan.classList.contains('hidden');
                    
                    if (isExpanded) {
                        fullSpan.classList.add('hidden');
                        fullSpan.classList.remove('inline');
                        shortSpan.classList.remove('hidden');
                        shortSpan.classList.add('inline');
                        if (descBox) {
                            descBox.classList.add('max-h-[65px]', 'overflow-hidden');
                            descBox.classList.remove('max-h-[150px]', 'overflow-y-auto', 'custom-scrollbar', 'pr-1');
                        }
                        toggleBtn.querySelector('span').textContent = window.currentLocale === 'en' ? 'Show More' : 'Lihat Selengkapnya';
                        toggleBtn.querySelector('i').className = 'ph ph-caret-down text-xs';
                    } else {
                        shortSpan.classList.add('hidden');
                        shortSpan.classList.remove('inline');
                        fullSpan.classList.remove('hidden');
                        fullSpan.classList.add('inline');
                        if (descBox) {
                            descBox.classList.remove('max-h-[65px]', 'overflow-hidden');
                            descBox.classList.add('max-h-[150px]', 'overflow-y-auto', 'custom-scrollbar', 'pr-1');
                        }
                        toggleBtn.querySelector('span').textContent = window.currentLocale === 'en' ? 'Show Less' : 'Sembunyikan';
                        toggleBtn.querySelector('i').className = 'ph ph-caret-up text-xs';
                    }
                    return;
                }

                // 2. Action buttons dropdown menu toggle
                const trigger = e.target.closest('.lihat-detail-trigger');
                if (!trigger) return;
                
                e.preventDefault();
                clearAutoHideTimer();
                
                const menu = trigger.nextElementSibling;
                if (!menu) return;

                if (menu.classList.contains('hidden')) {
                    // Close other menus
                    document.querySelectorAll('.details-choices-menu').forEach(m => {
                        if (m !== menu) {
                            m.classList.add('hidden', 'opacity-0', 'translate-y-1', 'pointer-events-none');
                            m.classList.remove('flex', 'opacity-100', 'translate-y-0', 'pointer-events-auto');
                        }
                    });

                    menu.classList.remove('hidden', 'pointer-events-none');
                    menu.classList.add('flex');
                    menu.offsetHeight;
                    menu.classList.remove('opacity-0', 'translate-y-1');
                    menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                } else {
                    menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    menu.classList.add('opacity-0', 'translate-y-1', 'pointer-events-none');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                        menu.classList.remove('flex');
                    }, 200);
                }
            });
        }

        // Close choices menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.lihat-detail-trigger') && !e.target.closest('.details-choices-menu')) {
                document.querySelectorAll('.details-choices-menu').forEach(menu => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                        menu.classList.add('opacity-0', 'translate-y-1', 'pointer-events-none');
                        setTimeout(() => {
                            menu.classList.add('hidden');
                            menu.classList.remove('flex');
                        }, 200);
                    }
                });
            }
        });

        if (closeEventBtn) closeEventBtn.addEventListener('click', closeEventModal);
        
        // Close modal on click outside content
        if (eventModal) {
            eventModal.addEventListener('click', function(e) {
                if (e.target === eventModal) {
                    closeEventModal();
                }
            });
        }

        // Helper function for beautiful empty notification popup
        function showEmptyInformationPopup() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    html: `
                        <div class="flex flex-col items-center justify-center pt-6 pb-2">
                            <div class="w-20 h-20 bg-emerald-50 rounded-[22px] flex items-center justify-center mb-5 shadow-sm border border-emerald-100">
                                <i class="ph-fill ph-info text-[42px] text-[#106c38]"></i>
                            </div>
                            <h3 class="text-[22px] font-black text-slate-800 mb-3 tracking-tight">Belum Ada Informasi</h3>
                            <p class="text-[13.5px] text-slate-500 leading-relaxed max-w-[280px] mx-auto">
                                Saat ini belum ada pengumuman, event, atau informasi terbaru dari Perpustakaan USU.
                            </p>
                        </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup',
                    buttonsStyling: false,
                    customClass: {
                        popup: '!rounded-[28px] !shadow-2xl border border-slate-100/50 !pb-5',
                        confirmButton: 'bg-[#106c38] hover:bg-[#0c562c] hover:scale-[1.02] active:scale-95 text-white px-8 py-2.5 rounded-full font-bold text-[13px] transition-all shadow-md shadow-[#106c38]/20 focus:ring-4 focus:ring-emerald-50 focus:outline-none w-full sm:w-auto',
                    },
                    width: '24em',
                    backdrop: `rgba(15, 23, 42, 0.4)`
                });
            } else {
                alert('Saat ini belum ada pengumuman, event, atau informasi terbaru dari Perpustakaan USU.');
            }
        }

        // Navbar trigger handlers
        if (navbarEventBtn) {
            navbarEventBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (loadedEvents.length === 0) {
                    showEmptyInformationPopup();
                    return;
                }
                clearAutoHideTimer(); // User clicked, disable auto-hide
                openEventModal();
            });
        }

        if (mobileNavbarEventBtn) {
            mobileNavbarEventBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (loadedEvents.length === 0) {
                    showEmptyInformationPopup();
                    return;
                }
                
                clearAutoHideTimer(); // User clicked, disable auto-hide
                // Close mobile menu drawer first
                if (typeof window.closeMobileMenu === 'function') {
                    window.closeMobileMenu();
                }
                // Open event modal
                setTimeout(openEventModal, 350);
            });
        }
    });
</script>

@if(!request()->routeIs('home'))
<button id="desktop-back-button" onclick="window.history.back();" 
        class="fixed left-4 lg:left-8 xl:left-12 2xl:left-24 top-28 z-40 hidden md:flex items-center justify-start w-12 hover:w-32 h-12 bg-[#106c38] hover:bg-[#0e5c30] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer select-none group overflow-hidden pl-3.5 border border-transparent"
        title="{{ __('Kembali') }}">
    <div class="flex items-center gap-2.5 whitespace-nowrap">
        <i class="ph ph-arrow-left text-xl font-bold transition-transform group-hover:-translate-x-0.5"></i>
        <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-bold text-xs uppercase tracking-wider">{{ __('Kembali') }}</span>
    </div>
</button>
@endif

