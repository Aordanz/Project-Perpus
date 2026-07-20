<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>@yield('title', 'Information Center') - Portal Admin USU</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800;950&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .text-usu-green { color: #106c38; }
        .bg-usu-green { background-color: #106c38; }
        .btn-gold {
            background-color: #106c38;
            color: white;
            font-weight: 700;
        }
        .btn-gold:hover { background-color: #0b4d27; }
        .custom-card { transition: all 0.3s ease; }
        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased min-h-screen bg-slate-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        @include('partials.admin_sidebar')

        <div class="flex-grow flex flex-col min-w-0 h-screen overflow-y-auto">
            <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-6">
                
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                        <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                        <i class="ph ph-warning-circle text-2xl flex-shrink-0"></i>
                        <div class="leading-normal">
                            <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                            <ul class="list-disc pl-5 mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
