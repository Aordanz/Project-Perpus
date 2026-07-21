<!-- Admin Sidebar Navigation -->
<div class="md:hidden bg-[#106c38] text-white px-4 py-3.5 flex items-center justify-between border-b border-white/10 sticky top-0 z-[60] shadow-md">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="{{ asset('logousu.webp') }}" class="h-8 w-8 object-contain" alt="Logo USU">
        <span class="font-extrabold text-xs tracking-wider font-sans uppercase">PORTAL ADMIN</span>
    </a>
    <button type="button" id="admin-sidebar-toggle" class="text-white hover:text-green-200 focus:outline-none cursor-pointer bg-transparent border-none">
        <i class="ph ph-list text-2xl" id="admin-sidebar-icon"></i>
    </button>
</div>

<aside id="admin-sidebar-nav" class="hidden md:flex flex-col w-full md:w-64 bg-[#106c38] text-white flex-shrink-0 border-r border-white/10 h-screen sticky top-0 transition-all duration-300 z-50 overflow-y-auto">
    <!-- Brand Branding -->
    <div class="p-6 border-b border-white/10 flex items-center gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-95 transition">
            <img src="{{ asset('logousu.webp') }}" alt="Logo USU" class="h-10 w-auto object-contain">
            <div class="flex flex-col">
                <span class="font-black text-xs tracking-wide uppercase font-sans">PORTAL ADMIN</span>
                <span class="text-[9px] font-semibold text-green-200/90 tracking-wider">Perpustakaan USU</span>
            </div>
        </a>
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
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('admin-sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar-nav');
        const icon = document.getElementById('admin-sidebar-icon');
        
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('flex');
                if (sidebar.classList.contains('hidden')) {
                    icon.className = 'ph ph-list text-2xl';
                } else {
                    icon.className = 'ph ph-x text-2xl';
                }
            });
        }
    });
</script>
