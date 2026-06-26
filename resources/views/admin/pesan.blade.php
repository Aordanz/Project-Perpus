<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kotak Pesan - Portal Admin OPAC USU</title>

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
            background: #064e3b;
            border-bottom: 2px solid #eab308;
        }
        .bg-usu-green {
            background-color: #064e3b;
        }
        .text-usu-green {
            color: #064e3b;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Admin Navigation Bar -->
    <nav class="admin-nav py-4 px-6 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 hover:opacity-95 transition">
                    <img src="{{ asset('logousu.jpeg') }}" alt="Logo USU" class="h-10 w-auto bg-white rounded-full p-0.5 border border-yellow-400">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm tracking-wide uppercase font-sans">PORTAL ADMINISTRASI</span>
                        <span class="text-xs font-semibold text-yellow-350 tracking-wider">Perpustakaan Universitas Sumatera Utara</span>
                    </div>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('admin.index') }}" class="text-white hover:text-yellow-200 transition py-1 text-sm font-semibold">Dashboard</a>
                <a href="{{ route('admin.galeri') }}" class="text-white hover:text-yellow-200 transition py-1 text-sm font-semibold">Galeri</a>
                <a href="{{ route('admin.pesan') }}" class="text-yellow-400 font-bold border-b-2 border-yellow-400 transition py-1 text-sm font-semibold">Pesan</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="font-bold text-xs">{{ Auth::user()->name ?? 'Admin Perpustakaan' }}</span>
                    <span class="text-[10px] text-yellow-400 font-semibold uppercase tracking-wider">Pustakawan</span>
                </div>
                
                <div class="w-px h-8 bg-white/20 hidden sm:block"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600/90 hover:bg-red-700 text-white font-bold text-xs px-4.5 py-2 rounded-xl transition flex items-center gap-1.5 cursor-pointer border-none shadow-sm">
                        <i class="ph ph-sign-out text-base"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Admin Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-8">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-white border border-slate-100 p-6 rounded-3xl shadow-sm">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="ph ph-envelope-open text-usu-green text-3xl"></i>
                    <span>Kotak Pesan Masuk</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Daftar pertanyaan dan keluhan yang dikirimkan pengguna melalui halaman Kontak Kami.</p>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex flex-col gap-6">
            <div class="space-y-4">
                @forelse($messages as $msg)
                    <div class="p-5 border border-slate-200 rounded-2xl hover:border-[#106c38]/30 hover:bg-green-50/20 transition-all flex flex-col sm:flex-row gap-4 sm:items-start group">
                        
                        <!-- Avatar / Icon -->
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 group-hover:bg-green-100 group-hover:text-usu-green transition-colors">
                            <i class="ph ph-user text-2xl"></i>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-grow min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                <h3 class="font-bold text-slate-800 text-base truncate">{{ $msg->name }}</h3>
                                <span class="text-xs text-slate-400 whitespace-nowrap">{{ $msg->created_at->locale('id')->diffForHumans() }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <a href="mailto:{{ $msg->email }}" class="text-xs font-semibold text-usu-green hover:underline flex items-center gap-1">
                                    <i class="ph ph-envelope"></i> {{ $msg->email }}
                                </a>
                            </div>

                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-3">
                                <h4 class="font-bold text-slate-700 text-sm mb-1.5 flex items-center gap-1.5">
                                    Subjek: {{ $msg->subject }}
                                </h4>
                                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                            </div>
                            
                            @if(!empty($msg->attachments) && is_array($msg->attachments) && count($msg->attachments) > 0)
                                <div class="flex flex-wrap gap-3">
                                    @foreach($msg->attachments as $attachment)
                                        <a href="{{ asset('contacts/' . $attachment) }}" target="_blank" class="block rounded-lg overflow-hidden border border-slate-200 hover:border-usu-green transition-colors w-32 h-32 relative group">
                                            <img src="{{ asset('contacts/' . $attachment) }}" alt="Lampiran" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <i class="ph ph-arrows-out text-white text-xl"></i>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center justify-center text-slate-400">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <i class="ph ph-tray text-4xl text-slate-300"></i>
                        </div>
                        <p class="font-bold text-lg text-slate-600">Belum ada pesan masuk</p>
                        <p class="text-sm mt-1">Pesan dari halaman Kontak akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-2">
                {{ $messages->links() }}
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-usu-green text-slate-100 py-6 mt-auto border-t border-yellow-450 flex-shrink-0 text-center text-xs font-medium">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
            <p class="text-yellow-400">Universitas Sumatera Utara Library</p>
        </div>
    </footer>

</body>
</html>
