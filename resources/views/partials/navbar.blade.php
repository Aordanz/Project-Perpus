<!-- Navigation -->
<nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Links -->
            <div class="flex items-center gap-4 lg:gap-6 flex-shrink-0">
                <!-- USU Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 sm:gap-2 group">
                    <img src="{{ asset('logousu.webp') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 object-contain">
                    <div class="flex flex-col">
                        <span class="font-bold text-white leading-none text-[10px] sm:text-sm group-hover:text-green-200 transition">{{ __('Perpustakaan ') }}</span>
                        <span class="font-bold text-white leading-none text-[10px] sm:text-sm group-hover:text-green-200 transition">{{ __('Universitas Sumatera Utara') }}</span>
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
                    {{ __('Event') }}
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
            <button id="mobile-menu-btn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10 transition cursor-pointer" aria-label="Menu">
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
                <span class="text-white font-bold text-sm tracking-wide">Menu</span>
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
                    <i class="ph ph-megaphone text-lg"></i> {{ __('Event') }}
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
<div id="event-popup-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/45 backdrop-blur-[2px] p-4 transition-all duration-300">
    <div class="bg-white border border-slate-200 rounded-[20px] shadow-2xl relative overflow-hidden w-full max-w-4xl h-[92vh] md:h-[550px] transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col" id="event-popup-content">
        <!-- Close Button (Fixed) -->
        <button id="close-event-popup" class="absolute top-4 right-4 z-50 text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 rounded-full p-2 flex items-center justify-center transition cursor-pointer shadow-md border border-slate-200/50 hover:scale-105">
            <i class="ph ph-x text-lg font-bold"></i>
        </button>

        <!-- Slider Track Container (Main Content Area) -->
        <div class="w-full flex-grow relative overflow-hidden">
            <!-- Slides Track -->
            <div id="event-slider-track" class="flex h-full w-full">
                <!-- Slides will be inserted dynamically -->
            </div>
        </div>

        <!-- Global Modal Footer -->
        <div class="flex justify-between items-center px-6 py-3.5 border-t border-slate-100 bg-white relative overflow-hidden select-none shrink-0 rounded-b-[20px]">
            <!-- Checkbox: Jangan Tampilkan Lagi -->
            <div class="flex items-center gap-2 z-20">
                <input type="checkbox" id="global-dont-show-checkbox" class="w-4 h-4 text-[#106c38] border-slate-300 rounded focus:ring-[#106c38] cursor-pointer">
                <label for="global-dont-show-checkbox" class="text-[11px] md:text-xs text-slate-500 font-semibold cursor-pointer hover:text-slate-700 transition">
                    {{ __('Jangan tampilkan lagi hari ini') }}
                </label>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="event-pagination-container" class="flex items-center gap-2.5 z-20 mr-12 md:mr-32">
                <button id="prev-event-btn" class="w-7 h-7 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center hover:scale-105 transition cursor-pointer">
                    <i class="ph ph-caret-left text-sm font-bold"></i>
                </button>
                <span id="event-pagination-text" class="text-xs font-black text-slate-500 tracking-wider">1 / 3</span>
                <button id="next-event-btn" class="w-7 h-7 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center hover:scale-105 transition cursor-pointer">
                    <i class="ph ph-caret-right text-sm font-bold"></i>
                </button>
            </div>

            <!-- Campus Building Illustration Overlay -->
            <img src="{{ asset('perpustakaan_depan.webp') }}" alt="USU Library Building" class="absolute right-0 bottom-0 h-14 w-auto opacity-15 md:opacity-20 pointer-events-none select-none z-10 translate-y-1 object-contain grayscale mix-blend-multiply">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventModal = document.getElementById('event-popup-modal');
        const eventContent = document.getElementById('event-popup-content');
        const closeEventBtn = document.getElementById('close-event-popup');
        const sliderTrack = document.getElementById('event-slider-track');
        const prevBtn = document.getElementById('prev-event-btn');
        const nextBtn = document.getElementById('next-event-btn');
        const paginationText = document.getElementById('event-pagination-text');
        const globalDontShowCheckbox = document.getElementById('global-dont-show-checkbox');
        
        const navbarEventBtn = document.getElementById('navbar-event-btn');
        const mobileNavbarEventBtn = document.getElementById('mobile-navbar-event-btn');

        window.logoUsuUrl = "{{ asset('logousu.webp') }}";
        window.assetRoot = "{{ asset('') }}";

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

                    loadedEvents.forEach((event, index) => {
                        // Calculate status
                        let badgeText = 'PENDAFTARAN DIBUKA';
                        let badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                        let badgeIcon = '<i class="ph ph-circle-wavy-check text-sm animate-pulse"></i>';
                        
                        const now = new Date();
                        if (event.start_date || event.end_date) {
                            const startD = event.start_date ? new Date(event.start_date) : null;
                            const endD = event.end_date ? new Date(event.end_date) : null;

                            if (startD && startD > now) {
                                badgeText = 'AKAN DATANG';
                                badgeClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                badgeIcon = '<i class="ph ph-calendar-plus text-sm"></i>';
                            } else if (endD && endD < now) {
                                badgeText = 'TELAH BERAKHIR';
                                badgeClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                badgeIcon = '<i class="ph ph-calendar-x text-sm"></i>';
                            }
                        }
                        
                        // Features HTML
                        let featuresHtml = '';
                        const featureIcons = [
                            'ph-book-open-text',
                            'ph-briefcase',
                            'ph-certificate',
                            'ph-gift'
                        ];
                        if (event.left_features && Array.isArray(event.left_features)) {
                            featuresHtml = event.left_features.map((feature, idx) => {
                                const iconClass = featureIcons[idx] || 'ph-check-circle';
                                return `
                                    <div class="flex flex-col items-center text-center gap-1 select-none">
                                        <div class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-[#fbbf24] transition duration-200">
                                            <i class="ph ${iconClass} text-lg"></i>
                                        </div>
                                        <span class="text-[9px] font-bold text-white/90 leading-tight">${feature}</span>
                                    </div>
                                `;
                            }).join('');
                        }

                        // Title highlight: Mendeley, LKTIN, AI
                        let displayLeftTitle = event.left_title || event.title;
                        displayLeftTitle = displayLeftTitle.replace(/(WORKSHOP|MENDELEY|LKTIN|AI)/gi, function(match) {
                            if (match.toUpperCase() === 'MENDELEY' || match.toUpperCase() === 'LKTIN' || match.toUpperCase() === 'AI') {
                                return `<span class="text-[#fbbf24] font-black">${match}</span>`;
                            }
                            return match;
                        });

                        slidesHtml += `
                            <div class="w-full shrink-0 flex flex-col md:flex-row h-full overflow-hidden select-none">
                                <!-- Left Flyer Pane -->
                                <div class="w-full md:w-[46%] h-48 md:h-full relative overflow-hidden bg-[#0c3c22] flex flex-col justify-between p-5 md:p-6 text-white shrink-0">
                                    <div class="absolute inset-0 bg-[url('${window.assetRoot}perpustakaan_depan.webp')] bg-cover bg-center opacity-10 pointer-events-none mix-blend-overlay"></div>
                                    <div class="absolute inset-0 bg-gradient-to-tr from-[#062414]/90 via-[#0a351d]/90 to-[#0e4827]/80 pointer-events-none"></div>

                                    <!-- Top Logo -->
                                    <div class="relative z-20 flex items-center gap-2">
                                        <img src="${window.logoUsuUrl}" alt="USU Logo" class="h-8 w-8 object-contain">
                                        <div class="flex flex-col leading-none">
                                            <span class="font-black text-[9px] uppercase tracking-wide text-white">Perpustakaan</span>
                                            <span class="font-medium text-[8px] text-green-200">Universitas Sumatera Utara</span>
                                        </div>
                                    </div>

                                    <!-- Center Elements -->
                                    <div class="relative z-20 my-auto flex flex-col gap-2 md:gap-3 py-1">
                                        <div class="inline-flex self-start items-center gap-1 bg-[#d97706] text-white text-[8px] font-extrabold tracking-widest px-2.5 py-0.5 rounded-full uppercase">
                                            <i class="ph ph-megaphone text-[9px]"></i> <span>${event.left_badge || 'EVENT PERPUSTAKAAN'}</span>
                                        </div>
                                        
                                        <h1 class="text-sm md:text-xl font-black tracking-tight leading-tight uppercase font-sans text-white">
                                            ${displayLeftTitle}
                                        </h1>
                                        
                                        <p class="text-[9px] md:text-[10px] text-green-100/80 leading-relaxed font-medium line-clamp-2 md:line-clamp-none">
                                            ${event.left_subtitle || event.description}
                                        </p>

                                        <!-- Image with Quota Sticker -->
                                        <div class="relative w-full max-w-[200px] mx-auto md:max-w-none mt-2 select-none group">
                                            <img src="${event.image_url}" alt="Banner" class="w-full h-24 md:h-32 object-cover rounded-lg shadow-md border border-white/10 group-hover:scale-102 transition duration-300">
                                            ${event.quota_tag ? `
                                            <div class="absolute -top-3 -right-3 md:-top-4 md:-right-4 bg-[#facc15] text-[#0c3c22] font-black rounded-full w-14 h-14 md:w-16 md:h-16 flex flex-col items-center justify-center text-center p-1.5 text-[7px] leading-tight rotate-12 shadow-lg border border-dashed border-[#0c3c22]/30 select-none animate-pulse">
                                                ${event.quota_tag}
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>

                                    <!-- Bottom Features -->
                                    <div class="relative z-20 border-t border-white/15 pt-3 mt-auto grid grid-cols-4 gap-1">
                                        ${featuresHtml}
                                    </div>

                                    <!-- Wave Divider Gold Accent (Only visible on MD+) -->
                                    <div class="absolute top-0 right-0 h-full w-10 translate-x-1/2 pointer-events-none hidden md:block z-30">
                                        <svg class="h-full w-full" viewBox="0 0 40 500" preserveAspectRatio="none">
                                            <path d="M 0,0 Q 25,150 5,280 T 15,500 L 40,500 L 40,0 Z" fill="#ffffff" />
                                            <path d="M 0,0 Q 25,150 5,280 T 15,500" fill="none" stroke="#facc15" stroke-width="2" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Right Details Pane -->
                                <div class="w-full md:w-[54%] p-5 md:p-8 flex flex-col justify-between h-full bg-white relative overflow-y-auto shrink-0 select-none">
                                    <div>
                                        <!-- Status Badge -->
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border ${badgeClass}">
                                            ${badgeIcon} <span>${badgeText}</span>
                                        </div>

                                        <!-- Title -->
                                        <h2 class="text-sm md:text-base lg:text-[17px] font-black text-slate-800 tracking-tight leading-snug mb-2 font-sans">
                                            ${event.title}
                                        </h2>

                                        <!-- Description -->
                                        <p class="text-[11px] text-slate-500 leading-relaxed mb-3 line-clamp-3">
                                            ${event.description}
                                        </p>

                                        <!-- Details Grid -->
                                        <div class="grid grid-cols-2 border border-slate-100 rounded-xl overflow-hidden mb-3 bg-slate-50/50">
                                            <div class="p-2 flex items-start gap-1.5 border-r border-b border-slate-100">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-calendar-blank text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Tanggal</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate">${event.date_text || '22 Juni 2026'}</span>
                                                </div>
                                            </div>
                                            <div class="p-2 flex items-start gap-1.5 border-b border-slate-100">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-clock text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Waktu</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate">${event.time}</span>
                                                </div>
                                            </div>
                                            <div class="p-2 flex items-start gap-1.5 border-r border-b border-slate-100">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-map-pin text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Lokasi</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate" title="${event.location}">${event.location}</span>
                                                </div>
                                            </div>
                                            <div class="p-2 flex items-start gap-1.5 border-b border-slate-100">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-users text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Penyelenggara</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate" title="${event.organizer}">${event.organizer}</span>
                                                </div>
                                            </div>
                                            <div class="p-2 flex items-start gap-1.5 border-r border-slate-100">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-user-circle text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Peserta</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate">${event.participants || 'Mahasiswa'}</span>
                                                </div>
                                            </div>
                                            <div class="p-2 flex items-start gap-1.5">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-[#106c38] flex items-center justify-center shrink-0">
                                                    <i class="ph ph-star text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wide leading-none mb-1">Fasilitas</span>
                                                    <span class="text-[10px] font-bold text-slate-700 leading-tight block truncate" title="${event.facilities}">${event.facilities}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hubungi Kami -->
                                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-2.5 mb-3 flex flex-col gap-1.5">
                                            <span class="block text-[8px] font-black text-slate-400 uppercase tracking-wider">HUBUNGI KAMI</span>
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                ${event.contact_whatsapp ? `
                                                <a href="https://wa.me/${event.contact_whatsapp.replace(/[^0-9]/g, '')}" target="_blank" class="flex items-center gap-1.5 hover:opacity-80 transition min-w-0 flex-1">
                                                    <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                                        <i class="ph ph-whatsapp-logo text-xs font-bold"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <span class="text-[9px] font-bold text-slate-700 block truncate leading-none mb-0.5">${event.contact_whatsapp}</span>
                                                        <span class="text-[7.5px] text-slate-400 block truncate leading-none">${event.contact_whatsapp_name || 'Admin'}</span>
                                                    </div>
                                                </a>
                                                ` : ''}
                                                ${event.contact_email ? `
                                                <a href="mailto:${event.contact_email}" class="flex items-center gap-1.5 hover:opacity-80 transition min-w-0 flex-1">
                                                    <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 shrink-0">
                                                        <i class="ph ph-envelope-simple text-xs font-bold"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <span class="text-[9px] font-bold text-slate-700 block truncate leading-none mb-0.5">${event.contact_email}</span>
                                                        <span class="text-[7.5px] text-slate-400 block truncate leading-none">${event.contact_email_name || 'Email'}</span>
                                                    </div>
                                                </a>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="relative w-full border-t border-slate-100 pt-2.5 select-none">
                                        <!-- Lihat Detail Button (Full Width) -->
                                        <button class="lihat-detail-trigger w-full py-2.5 bg-[#106c38] hover:bg-[#0c532b] text-white rounded-xl font-bold text-[11px] transition shadow-md hover:shadow-lg flex items-center justify-center gap-1.5 cursor-pointer">
                                            Lihat Detail <i class="ph ph-caret-up text-xs"></i>
                                        </button>
                                        
                                        <!-- Choice Popover (Above Button) -->
                                        <div class="details-choices-menu absolute bottom-[105%] left-0 right-0 bg-white border border-slate-200 rounded-xl shadow-xl p-1.5 hidden flex-col gap-1 z-[80] transition-all duration-200 transform translate-y-1 opacity-0 pointer-events-none">
                                            ${(event.action_buttons && Array.isArray(event.action_buttons) && event.action_buttons.length > 0) 
                                                ? event.action_buttons.map(btn => `
                                                    <a href="${btn.url}" target="${btn.new_tab ? '_blank' : '_self'}" class="flex items-center gap-2 px-3 py-2 text-[10.5px] font-bold text-slate-700 hover:bg-emerald-50 hover:text-[#106c38] rounded-lg transition">
                                                        <i class="ph ph-link text-sm text-[#106c38]"></i> ${btn.name}
                                                    </a>
                                                `).join('')
                                                : `
                                                    <a href="${event.instagram_url || 'https://www.instagram.com/usu.library/'}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-[10.5px] font-bold text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition">
                                                        <i class="ph ph-instagram-logo text-sm text-rose-500"></i> Postingan Instagram
                                                    </a>
                                                    <a href="${event.library_url || 'https://library.usu.ac.id/id'}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-[10.5px] font-bold text-slate-700 hover:bg-emerald-50 hover:text-[#106c38] rounded-lg transition">
                                                        <i class="ph ph-globe text-sm text-[#106c38]"></i> Link Library USU
                                                    </a>
                                                `
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    sliderTrack.innerHTML = slidesHtml;

                    // Initialize slider
                    initSlider();

                    // Auto-show delay: 1.5 seconds
                    autoShowTimeout = setTimeout(() => {
                        openEventModal();
                        // Auto-hide timing: 8 seconds
                        startAutoHideTimer();
                    }, 1500);
                } else {
                    // Hide navbar triggers if no events
                    if (navbarEventBtn) navbarEventBtn.classList.add('hidden');
                    if (mobileNavbarEventBtn) mobileNavbarEventBtn.classList.add('hidden');
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
                if (eventModal.classList.contains('flex')) {
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
                return;
            }

            document.getElementById('event-pagination-container').classList.remove('hidden');

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

            prevBtn.onclick = function() {
                if (isTransitioning) return;
                clearAutoHideTimer();
                moveToSlide(slideIndex - 1);
            };

            nextBtn.onclick = function() {
                if (isTransitioning) return;
                clearAutoHideTimer();
                moveToSlide(slideIndex + 1);
            };

            sliderTrack.addEventListener('transitionend', () => {
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
        }

        function openEventModal() {
            if (loadedEvents.length === 0) return;
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
            if (globalDontShowCheckbox && globalDontShowCheckbox.checked) {
                const todayString = new Date().toDateString();
                localStorage.setItem('event_popup_hide_date', todayString);
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

        // Toggle active status for event detail choices
        if (sliderTrack) {
            sliderTrack.addEventListener('click', function(e) {
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

        // Navbar trigger handlers
        if (navbarEventBtn) {
            navbarEventBtn.addEventListener('click', function(e) {
                e.preventDefault();
                clearAutoHideTimer(); // User clicked, disable auto-hide
                openEventModal();
            });
        }

        if (mobileNavbarEventBtn) {
            mobileNavbarEventBtn.addEventListener('click', function(e) {
                e.preventDefault();
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

