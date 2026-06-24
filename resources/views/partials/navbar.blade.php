<!-- Navigation -->
<nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Links -->
            <div class="flex items-center gap-4 lg:gap-6 flex-shrink-0">
                <!-- OPAC Brand Block -->
                <a href="{{ route('home') }}" class="flex flex-col text-white group whitespace-nowrap">
                    <span class="font-extrabold text-xl sm:text-2xl lg:text-3xl leading-none tracking-[0.15em] group-hover:text-green-200 transition">O P A C</span>
                    <span class="text-[7.5px] sm:text-[8px] lg:text-[9px] font-bold text-green-100/90 leading-none tracking-wide uppercase mt-0.5 whitespace-nowrap">ONLINE PUBLIC ACCESS CATALOG</span>
                </a>

                <!-- Divider -->
                <div class="h-8 w-px bg-white/20 hidden md:block"></div>

                <!-- USU Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('logousu.jpeg') }}" alt="USU Logo" class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-white p-0.5 object-cover shadow-sm">
                    <div class="flex flex-col hidden sm:flex">
                        <span class="font-bold text-white leading-none text-xs sm:text-sm group-hover:text-green-200 transition">{{ __('Universitas') }}</span>
                        <span class="font-bold text-white leading-none text-xs sm:text-sm group-hover:text-green-200 transition">{{ __('Sumatera Utara') }}</span>
                    </div>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <div class="hidden lg:flex space-x-3 xl:space-x-6 items-center justify-center flex-grow mx-2 xl:mx-4 lg:text-xs xl:text-sm">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Beranda') }}</a>
                <a href="{{ route('koleksi.terbaru') }}" class="{{ request()->routeIs('koleksi.terbaru') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Koleksi Terbaru') }}</a>
                <a href="{{ route('index-judul') }}" class="{{ request()->routeIs('index-judul') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Index Judul') }}</a>
                <div class="relative group">
                    <button class="text-green-100 font-medium hover:text-white transition flex items-center gap-1 pb-1 whitespace-nowrap">
                        {{ __('Tautan Lain') }} <i class="ph ph-caret-down"></i>
                    </button>
                </div>
                <a href="#" class="text-green-100 font-medium hover:text-white transition pb-1 whitespace-nowrap">{{ __('Cek Pinjaman') }}</a>
                <a href="{{ route('bantuan') }}" class="{{ request()->routeIs('bantuan') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Bantuan') }}</a>
                <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} pb-1 whitespace-nowrap">{{ __('Kontak Kami') }}</a>
            </div>
            
            <!-- Right Side -->
            <div class="hidden md:flex space-x-4 xl:space-x-5 items-center flex-shrink-0 lg:text-xs xl:text-sm">
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
        </div>
    </div>
</nav>
