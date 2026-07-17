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
                    {{ __('Event & Lomba') }}
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
                    <i class="ph ph-megaphone text-lg"></i> {{ __('Event & Lomba') }}
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
        // Close menu function exported for event popup
        window.closeMobileMenu = closeMenu;

        if (menuBtn) menuBtn.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        if (menuBackdrop) menuBackdrop.addEventListener('click', closeMenu);
    });
</script>

<!-- Event Popup Modal -->
<div id="event-popup-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/45 backdrop-blur-[2px] p-4 transition-all duration-300">
    <div class="bg-white border border-slate-200 rounded-xl shadow-2xl relative overflow-hidden w-full max-w-4xl h-[92vh] md:h-[520px] transform scale-95 opacity-0 transition-all duration-300 ease-out" id="event-popup-content">
        <!-- Close Button (Fixed) -->
        <button id="close-event-popup" class="absolute top-4 right-4 z-50 text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 rounded-full p-2 flex items-center justify-center transition cursor-pointer shadow-sm border border-slate-200/50">
            <i class="ph ph-x text-lg font-bold"></i>
        </button>

        <!-- Slider Track Container -->
        <div class="w-full h-full relative overflow-hidden">
            <!-- Slides Track -->
            <div id="event-slider-track" class="flex h-full w-full transition-transform duration-500 ease-out">
                <!-- Slides will be inserted dynamically -->
            </div>

            <!-- Navigation Buttons (hidden if <= 1 slide) -->
            <button id="prev-event-btn" class="absolute left-4 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white text-slate-700 p-2.5 rounded-full shadow-lg border border-slate-200/50 hover:scale-110 transition flex items-center justify-center cursor-pointer">
                <i class="ph ph-caret-left text-xl font-black"></i>
            </button>
            <button id="next-event-btn" class="absolute right-4 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white text-slate-700 p-2.5 rounded-full shadow-lg border border-slate-200/50 hover:scale-110 transition flex items-center justify-center cursor-pointer">
                <i class="ph ph-caret-right text-xl font-black"></i>
            </button>

            <!-- Indicators Dots -->
            <div id="event-slider-indicators" class="absolute bottom-4 left-1/2 -translate-x-1/2 z-40 flex gap-2">
                <!-- Dots will be inserted dynamically -->
            </div>
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
        const indicatorsContainer = document.getElementById('event-slider-indicators');
        
        const navbarEventBtn = document.getElementById('navbar-event-btn');
        const mobileNavbarEventBtn = document.getElementById('mobile-navbar-event-btn');

        let loadedEvents = [];
        let currentSlideIndex = 0;

        // Date range formatter
        function formatDateRange(startStr, endStr) {
            if (!startStr && !endStr) return '';
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const locale = document.documentElement.lang === 'en' ? 'en-US' : 'id-ID';
            
            let result = '';
            if (startStr) {
                const startD = new Date(startStr);
                result += startD.toLocaleDateString(locale, options);
            }
            if (endStr) {
                const endD = new Date(endStr);
                if (startStr) {
                    result += ' - ' + endD.toLocaleDateString(locale, options);
                } else {
                    result += endD.toLocaleDateString(locale, options);
                }
            }
            return result;
        }

        // Fetch active events
        fetch('/api/events/active')
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data && res.data.length > 0) {
                    loadedEvents = res.data;
                    
                    // Render slides
                    let slidesHtml = '';
                    let indicatorsHtml = '';

                    loadedEvents.forEach((event, index) => {
                        // Calculate status
                        let statusText = '{{ __('Pengumuman Terbaru') }}';
                        let statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
                        let statusIcon = '<i class="ph ph-sparkle"></i>';
                        
                        const now = new Date();
                        if (event.start_date || event.end_date) {
                            const startD = event.start_date ? new Date(event.start_date) : null;
                            const endD = event.end_date ? new Date(event.end_date) : null;

                            if (startD && startD > now) {
                                statusText = '{{ __('Akan Datang') }}';
                                statusClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                statusIcon = '<i class="ph ph-calendar-plus"></i>';
                            } else if (endD && endD < now) {
                                statusText = '{{ __('Telah Berakhir') }}';
                                statusClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                statusIcon = '<i class="ph ph-calendar-x"></i>';
                            } else {
                                statusText = '{{ __('Pendaftaran Dibuka') }}';
                                statusClass = 'bg-green-50 text-[#106c38] border-green-100';
                                statusIcon = '<i class="ph ph-circle-wavy-check animate-pulse"></i>';
                            }
                        }

                        const dateRangeText = formatDateRange(event.start_date, event.end_date);
                        
                        // Action link button
                        const registerBtnHtml = event.link_url ? `
                            <a href="${event.link_url}" target="_blank" class="flex-1 text-center py-3 bg-[#106c38] hover:bg-[#0c532b] text-white rounded-lg font-bold text-xs transition shadow-md hover:shadow-lg flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="ph ph-paper-plane-tilt text-sm"></i> {{ __('Daftar Sekarang') }}
                            </a>
                        ` : '';

                        // Contact button
                        const contactHref = event.contact_info.includes('@') ? `mailto:${event.contact_info}` : (event.contact_info.match(/[0-9]/g) ? `https://wa.me/${event.contact_info.replace(/[^0-9]/g, '')}` : '#');
                        const contactBtnHtml = event.contact_info ? `
                            <a href="${contactHref}" target="_blank" class="flex-1 text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs transition border border-slate-200 flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="ph ph-chat-circle text-sm text-[#106c38]"></i> {{ __('Hubungi Penyelenggara') }}
                            </a>
                        ` : '';

                        slidesHtml += `
                            <div class="w-full shrink-0 flex flex-col md:flex-row h-full overflow-hidden select-none">
                                <!-- Left Banner Image -->
                                <div class="w-full md:w-[45%] h-36 sm:h-48 md:h-full relative overflow-hidden shrink-0 bg-slate-900 flex items-center justify-center">
                                    <img src="${event.image_url}" alt="${event.title}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                                </div>

                                <!-- Right Details -->
                                <div class="w-full md:w-[55%] p-5 md:p-8 flex flex-col justify-between h-full overflow-y-auto bg-white">
                                    <div>
                                        <!-- Dynamic Badge -->
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 border ${statusClass}">
                                            ${statusIcon} <span>${statusText}</span>
                                        </div>

                                        <!-- Title -->
                                        <h2 class="text-sm md:text-base lg:text-lg font-black text-slate-800 tracking-tight leading-tight mb-2.5">
                                            ${event.title}
                                        </h2>

                                        <!-- Info Grid (Dates, Time, Location, Penyelenggara) -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[10px] sm:text-[11px] text-slate-600 mb-3 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                            <!-- Period -->
                                            ${dateRangeText ? `
                                            <div class="flex items-start gap-1.5">
                                                <i class="ph ph-calendar-blank text-base text-[#106c38] shrink-0 mt-0.5"></i>
                                                <div>
                                                    <span class="block font-bold text-slate-700">{{ __('Periode') }}</span>
                                                    <span class="text-slate-500">${dateRangeText}</span>
                                                </div>
                                            </div>
                                            ` : ''}

                                            <!-- Jam -->
                                            ${event.time ? `
                                            <div class="flex items-start gap-1.5">
                                                <i class="ph ph-clock text-base text-[#106c38] shrink-0 mt-0.5"></i>
                                                <div>
                                                    <span class="block font-bold text-slate-700">{{ __('Waktu Acara') }}</span>
                                                    <span class="text-slate-500">${event.time}</span>
                                                </div>
                                            </div>
                                            ` : ''}

                                            <!-- Lokasi -->
                                            ${event.location ? `
                                            <div class="flex items-start gap-1.5">
                                                <i class="ph ph-map-pin text-base text-[#106c38] shrink-0 mt-0.5"></i>
                                                <div>
                                                    <span class="block font-bold text-slate-700">{{ __('Lokasi') }}</span>
                                                    <span class="text-slate-500">${event.location}</span>
                                                </div>
                                            </div>
                                            ` : ''}

                                            <!-- Penyelenggara -->
                                            ${event.organizer ? `
                                            <div class="flex items-start gap-1.5">
                                                <i class="ph ph-users text-base text-[#106c38] shrink-0 mt-0.5"></i>
                                                <div>
                                                    <span class="block font-bold text-slate-700">{{ __('Penyelenggara') }}</span>
                                                    <span class="text-slate-500">${event.organizer}</span>
                                                </div>
                                            </div>
                                            ` : ''}
                                        </div>

                                        <!-- Contact Person -->
                                        ${event.contact_name ? `
                                        <div class="text-[10px] sm:text-[11px] text-slate-500 bg-slate-50 border border-slate-100 p-2.5 rounded-lg mb-3 flex items-center gap-2">
                                            <i class="ph ph-user-circle text-lg text-[#106c38]"></i>
                                            <div>
                                                <span class="block font-bold text-slate-700">${event.contact_name}</span>
                                                <span class="text-slate-500">${event.contact_info}</span>
                                            </div>
                                        </div>
                                        ` : ''}

                                        <!-- Short Description -->
                                        <div class="text-xs text-slate-600 leading-relaxed max-h-[70px] md:max-h-[100px] overflow-y-auto pr-1.5 scrollbar-thin mb-3">
                                            ${event.description}
                                        </div>
                                    </div>

                                    <!-- Action Buttons & Checkbox -->
                                    <div>
                                        <div class="flex items-center gap-2 select-none mb-3">
                                            <input type="checkbox" id="dont-show-today-checkbox-${index}" class="dont-show-today-checkbox w-4 h-4 text-[#106c38] border-slate-300 rounded focus:ring-[#106c38] cursor-pointer">
                                            <label for="dont-show-today-checkbox-${index}" class="text-[10px] text-slate-500 font-semibold cursor-pointer hover:text-slate-700 transition">
                                                {{ __('Jangan tampilkan lagi hari ini') }}
                                            </label>
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-2 border-t border-slate-100 pt-3">
                                            ${registerBtnHtml}
                                            ${contactBtnHtml}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        indicatorsHtml += `
                            <button data-slide-to="${index}" class="w-2 h-2 rounded-full transition-all duration-300 ${index === 0 ? 'bg-[#106c38] w-4' : 'bg-slate-300'}" aria-label="Slide ${index + 1}"></button>
                        `;
                    });

                    sliderTrack.innerHTML = slidesHtml;
                    indicatorsContainer.innerHTML = indicatorsHtml;

                    // Initialize slider
                    initSlider();

                    // Check if popup should be shown automatically (localStorage check for "Don't show again today")
                    // Note: User requested it to show "setiap web dibuka" - which means on every load EXCEPT if they checked dont-show-today!
                    const todayString = new Date().toDateString();
                    const hideDate = localStorage.getItem('event_popup_hide_date');
                    
                    if (hideDate !== todayString) {
                        setTimeout(openEventModal, 1000); // Slight delay for premium feel
                    }
                } else {
                    // Hide navbar triggers if no events
                    if (navbarEventBtn) navbarEventBtn.classList.add('hidden');
                    if (mobileNavbarEventBtn) mobileNavbarEventBtn.classList.add('hidden');
                }
            })
            .catch(err => {
                console.error('Failed to fetch active event', err);
            });

        function initSlider() {
            const totalSlides = loadedEvents.length;
            if (totalSlides <= 1) {
                prevBtn.classList.add('hidden');
                nextBtn.classList.add('hidden');
                indicatorsContainer.classList.add('hidden');
                return;
            }

            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            indicatorsContainer.classList.remove('hidden');

            function updateSlider() {
                sliderTrack.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
                
                // Update indicator dots
                const dots = indicatorsContainer.querySelectorAll('button');
                dots.forEach((dot, idx) => {
                    if (idx === currentSlideIndex) {
                        dot.classList.add('bg-[#106c38]', 'w-4');
                        dot.classList.remove('bg-slate-300');
                    } else {
                        dot.classList.remove('bg-[#106c38]', 'w-4');
                        dot.classList.add('bg-slate-300');
                    }
                });
            }

            prevBtn.onclick = function() {
                currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
                updateSlider();
            };

            nextBtn.onclick = function() {
                currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
                updateSlider();
            };

            indicatorsContainer.onclick = function(e) {
                const dot = e.target.closest('button');
                if (dot) {
                    currentSlideIndex = parseInt(dot.getAttribute('data-slide-to'));
                    updateSlider();
                }
            };
        }

        function openEventModal() {
            if (loadedEvents.length === 0) return;
            eventModal.classList.remove('hidden');
            eventModal.classList.add('flex');
            // Force reflow for transition
            eventModal.offsetHeight;
            eventModal.classList.add('opacity-100');
            eventContent.classList.remove('scale-95', 'opacity-0');
            eventContent.classList.add('scale-100', 'opacity-100');
            document.body.style.overflow = 'hidden';
        }

        function closeEventModal() {
            // Check if any check-box on any slide is checked
            const checkedBox = document.querySelector('.dont-show-today-checkbox:checked');
            if (checkedBox) {
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
                openEventModal();
            });
        }

        if (mobileNavbarEventBtn) {
            mobileNavbarEventBtn.addEventListener('click', function(e) {
                e.preventDefault();
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

