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
            background: #106c38;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .bg-usu-green {
            background-color: #106c38;
        }
        .text-usu-green {
            color: #106c38;
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
            <footer class="bg-[#106c38] text-white/90 py-5 border-t border-white/15 text-center text-xs font-medium mt-auto">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; {{ date('Y') }} Universitas Sumatera Utara | OPAC Admin. All rights reserved.</p>
                    <p class="text-white/70">Universitas Sumatera Utara Library</p>
                </div>
            </footer>
        </div>
    </div>

</body>
</html>
