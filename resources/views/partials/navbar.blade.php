<!-- Navigation -->
<nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo & Links -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('logousu.jpeg') }}" alt="USU Logo" class="h-10 w-10 rounded-full bg-white p-0.5 object-cover">
                    <div class="flex flex-col hidden sm:flex">
                        <span class="font-bold text-white leading-none text-sm">{{ __('Universitas') }}</span>
                        <span class="font-bold text-white leading-none text-sm">{{ __('Sumatera Utara') }}</span>
                    </div>
                </a>
                <div class="hidden lg:flex space-x-6 items-center">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} text-sm pb-1">{{ __('Beranda') }}</a>
                    <a href="{{ route('koleksi.terbaru') }}" class="{{ request()->routeIs('koleksi.terbaru') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} text-sm pb-1">{{ __('Koleksi Terbaru') }}</a>
                    <a href="{{ route('index-judul') }}" class="{{ request()->routeIs('index-judul') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} text-sm pb-1">{{ __('Index Judul') }}</a>
                    <div class="relative group">
                        <button class="text-green-100 font-medium text-sm hover:text-white transition flex items-center gap-1 pb-1">
                            {{ __('Tautan Lain') }} <i class="ph ph-caret-down"></i>
                        </button>
                    </div>
                    <a href="#" class="text-green-100 font-medium text-sm hover:text-white transition pb-1">{{ __('Cek Pinjaman') }}</a>
                </div>
            </div>
            
            <!-- Right Side -->
            <div class="hidden md:flex space-x-5 items-center">
                <a href="{{ route('bantuan') }}" class="{{ request()->routeIs('bantuan') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} text-sm pb-1">{{ __('Bantuan') }}</a>
                <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'text-white font-bold border-b-2 border-white' : 'text-green-100 font-medium hover:text-white transition' }} text-sm pb-1">{{ __('Kontak Kami') }}</a>
                
                <!-- Language Dropdown -->
                <div class="relative group cursor-pointer">
                    <div class="text-green-100 font-medium text-sm hover:text-white transition flex items-center gap-1 pb-1">
                        <i class="ph ph-translate text-lg"></i> {{ __('Bahasa') }} <i class="ph ph-caret-down"></i>
                    </div>
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden border border-slate-100">
                        <a href="{{ url('/lang/id') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition {{ session('locale') === 'id' || !session('locale') ? 'font-bold bg-green-50 text-[#106c38]' : '' }}">Indonesia</a>
                        <a href="{{ url('/lang/en') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-green-50 hover:text-[#106c38] transition {{ session('locale') === 'en' ? 'font-bold bg-green-50 text-[#106c38]' : '' }}">English</a>
                    </div>
                </div>

                <a href="#" class="bg-white text-[#106c38] px-5 py-2 rounded-full font-bold text-sm shadow hover:bg-green-50 transition-all">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </div>
</nav>
