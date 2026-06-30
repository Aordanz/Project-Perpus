<!-- Navigation -->
<nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Links -->
            <div class="flex items-center gap-4 lg:gap-6 flex-shrink-0">
                <!-- USU Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 sm:gap-2 group">
                    <img src="{{ asset('logousu.jpeg') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-white p-0.5 object-cover shadow-sm">
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
                <div class="relative group">
                    <button class="text-green-100 font-medium hover:text-white transition flex items-center gap-1 pb-1 whitespace-nowrap cursor-pointer">
                        {{ __('Tautan Lain') }} <i class="ph ph-caret-down"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden border border-slate-100">
                        <a href="https://www.usu.ac.id/" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">Universitas Sumatera Utara</a>
                        <a href="https://library.usu.ac.id/id" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">Perpustakaan</a>
                        <a href="https://repositori.usu.ac.id/" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">USU-IR</a>
                        <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">Scientific eJournals</a>
                        <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="block px-5 py-3.5 text-sm text-slate-600 hover:bg-green-50 hover:text-[#106c38] transition">Scientific eBooks</a>
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

                <!-- Auth Buttons -->
                @auth
                    <div class="flex items-center gap-3">
                        @if(auth()->user()->role === 'pustakawan')
                            <a href="{{ route('admin.index') }}" class="text-green-100 font-bold hover:text-white transition flex items-center gap-1.5">
                                <i class="ph ph-layout-bold text-lg"></i> {{ __('Dashboard') }}
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-700/10 hover:bg-red-700/20 text-red-200 hover:text-white font-bold px-3 py-1.5 rounded-lg border border-red-700/30 transition-all text-xs cursor-pointer flex items-center gap-1">
                                <i class="ph ph-sign-out-bold text-base"></i> {{ __('Keluar') }}
                            </button>
                        </form>
                    </div>
                @endauth
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
                <button id="mobile-menu-close" class="w-9 h-9 rounded-lg flex items-center justify-center text-white hover:bg-white/10 transition cursor-pointer">
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

                <div class="border-t border-white/10 my-2"></div>
                <span class="px-5 py-2 text-[10px] font-bold uppercase tracking-widest text-green-300/60">{{ __('Tautan Lain') }}</span>
                <a href="https://www.usu.ac.id/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-globe text-base"></i> Universitas Sumatera Utara
                </a>
                <a href="https://library.usu.ac.id/id" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-buildings text-base"></i> Perpustakaan
                </a>
                <a href="https://repositori.usu.ac.id/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-database text-base"></i> USU-IR
                </a>
                <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-article text-base"></i> Scientific eJournals
                </a>
                <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-xs font-medium text-green-100 hover:text-white hover:bg-white/5 transition">
                    <i class="ph ph-book text-base"></i> Scientific eBooks
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

                @auth
                    <div class="border-t border-white/10 my-2"></div>
                    @if(auth()->user()->role === 'pustakawan')
                        <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-white hover:bg-white/5 transition">
                            <i class="ph ph-layout-bold text-lg"></i> {{ __('Dashboard') }}
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="px-5 py-2">
                        @csrf
                        <button type="submit" class="w-full bg-red-700/20 hover:bg-red-700/30 text-red-200 font-bold py-2.5 rounded-lg border border-red-700/30 transition text-xs cursor-pointer flex items-center justify-center gap-1.5">
                            <i class="ph ph-sign-out-bold text-base"></i> {{ __('Keluar') }}
                        </button>
                    </form>
                @endauth

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
                        &copy; 2026 Perpustakaan USU
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

        if (menuBtn) menuBtn.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        if (menuBackdrop) menuBackdrop.addEventListener('click', closeMenu);
    });
</script>

@if(!request()->routeIs('home'))
<button id="desktop-back-button" onclick="window.history.back();" 
        class="fixed left-4 lg:left-8 xl:left-12 2xl:left-24 top-28 z-40 hidden md:flex items-center justify-start w-12 hover:w-32 h-12 bg-[#106c38] hover:bg-[#0e5c30] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer select-none group overflow-hidden pl-3.5 border border-transparent"
        title="Back">
    <div class="flex items-center gap-2.5 whitespace-nowrap">
        <i class="ph ph-arrow-left text-xl font-bold transition-transform group-hover:-translate-x-0.5"></i>
        <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 font-bold text-xs uppercase tracking-wider">Back</span>
    </div>
</button>
@endif

