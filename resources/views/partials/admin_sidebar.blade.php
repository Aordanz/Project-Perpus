<!-- Top Bar Navigation (Visible on PC and Mobile) -->
<div class="bg-[#106c38] text-white px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between border-b border-white/10 sticky top-0 z-40 shadow-md w-full">
    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-95 transition">
        <img src="{{ asset('logousu.webp') }}" class="h-9 w-9 object-contain" alt="Logo USU">
        <div class="flex flex-col">
            <span class="font-extrabold text-xs sm:text-sm tracking-wider font-sans uppercase">PORTAL ADMIN</span>
            <span class="text-[9px] font-semibold text-green-200/90 tracking-wider">Perpustakaan USU</span>
        </div>
    </a>
    <button type="button" id="admin-sidebar-toggle" class="flex items-center justify-center w-10 h-10 rounded-xl text-white bg-white/15 hover:bg-white/25 active:scale-95 transition cursor-pointer shrink-0 border-none" aria-label="Menu">
        <i class="ph ph-list text-2xl" id="admin-sidebar-icon"></i>
    </button>
</div>

<!-- Pop-Up Drawer Panel (Slide-in from Right, active on PC and Mobile) -->
<div id="admin-mobile-panel" class="fixed inset-0 z-[60] pointer-events-none">
    <!-- Backdrop Overlay -->
    <div id="admin-mobile-backdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
    
    <!-- Drawer Menu (Positioned top-0 right-0) -->
    <div id="admin-mobile-drawer" class="absolute top-0 right-0 h-full w-[280px] sm:w-[320px] bg-[#106c38] text-white transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl overflow-y-auto flex flex-col">
        <!-- Header with Close Button -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
            <span class="text-white font-bold text-sm tracking-wide">PORTAL ADMIN</span>
            <button type="button" id="admin-mobile-close" aria-label="Tutup Menu" class="w-9 h-9 rounded-lg flex items-center justify-center text-white hover:bg-white/10 transition cursor-pointer border-none bg-transparent">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>

        <!-- Active Profile Info -->
        <div class="p-4 mx-4 my-4 bg-white/5 rounded-2xl border border-white/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#064e3b] flex items-center justify-center font-bold text-white border border-white/15 shadow-inner flex-shrink-0">
                {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'Admin Perpustakaan', 0, 1)) }}
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-bold text-xs truncate" title="{{ Auth::check() ? Auth::user()->name : 'Admin' }}">{{ Auth::check() ? Auth::user()->name : 'Admin Perpustakaan' }}</span>
                <span class="text-[9px] text-green-200 font-bold uppercase tracking-wider mt-0.5">Pustakawan</span>
            </div>
        </div>

        <!-- Nav Menu -->
        <nav class="flex-grow px-4 space-y-1.5">
            <a href="{{ route('admin.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.index') ? 'bg-[#064e3b] text-white border-l-4 border-white shadow-inner' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                <i class="ph ph-layout text-lg"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.tambah-cover') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.tambah-cover') || request()->routeIs('admin.books.edit') ? 'bg-[#064e3b] text-white border-l-4 border-white shadow-inner' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                <i class="ph ph-image text-lg"></i>
                <span>Tambah Cover</span>
            </a>

            <a href="{{ route('admin.information-center.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.information-center.*') ? 'bg-[#064e3b] text-white border-l-4 border-white shadow-inner' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                <i class="ph ph-megaphone text-lg"></i>
                <span>Information Center</span>
            </a>
        </nav>

        <!-- Footer Action -->
        <div class="p-4 pb-8 border-t border-white/10 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-3 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer border-none shadow-sm">
                    <i class="ph ph-sign-out text-base"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('admin-sidebar-toggle');
        const closeBtn = document.getElementById('admin-mobile-close');
        const panel = document.getElementById('admin-mobile-panel');
        const backdrop = document.getElementById('admin-mobile-backdrop');
        const drawer = document.getElementById('admin-mobile-drawer');
        
        function openDrawer() {
            if (!panel || !backdrop || !drawer) return;
            panel.classList.remove('pointer-events-none');
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            drawer.classList.remove('translate-x-full');
            drawer.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            if (!panel || !backdrop || !drawer) return;
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            drawer.classList.remove('translate-x-0');
            drawer.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => {
                panel.classList.add('pointer-events-none');
            }, 300);
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (backdrop) backdrop.addEventListener('click', closeDrawer);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && drawer && drawer.classList.contains('translate-x-0')) {
                closeDrawer();
            }
        });
    });
</script>
