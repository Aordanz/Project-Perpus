<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="text-slate-800 antialiased min-h-screen bg-slate-50 flex flex-col">
    @include('partials.admin_sidebar')

    <div class="w-full flex-grow flex flex-col min-w-0">
        <main class="flex-grow p-4 sm:p-6 lg:p-8 flex flex-col gap-6">
            
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-2xl flex gap-3 text-sm font-medium shadow-sm">
                    <i class="ph ph-check-circle text-2xl flex-shrink-0"></i>
                    <div class="leading-normal">{{ session('success') }}</div>
                </div>
            @endif

            @if (isset($errors) && $errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const errorKeys = {!! json_encode($errors->keys()) !!};
                        const errorMessages = {!! json_encode($errors->messages()) !!};
                        
                        let firstErrorElement = null;
                        
                        errorKeys.forEach(key => {
                            let input = document.querySelector(`[name="${key}"]`);
                            if (!input && key.includes('.')) {
                                const parts = key.split('.');
                                if (parts.length === 2) {
                                    input = document.querySelector(`[name="${parts[0]}[${parts[1]}]"]`);
                                } else if (parts.length === 3) {
                                    input = document.querySelector(`[name="${parts[0]}[${parts[1]}][${parts[2]}]"]`);
                                }
                            }
                            
                            if (input) {
                                if (!firstErrorElement) firstErrorElement = input;
                                input.classList.add('border-red-500', '!border-red-500', 'focus:ring-red-500', 'bg-red-50');
                                
                                // Check if an error message already exists
                                let next = input.nextElementSibling;
                                let hasErrorNode = false;
                                while(next) {
                                    if(next.tagName === 'P' && next.classList.contains('text-red-500')) {
                                        hasErrorNode = true;
                                        break;
                                    }
                                    next = next.nextElementSibling;
                                }
                                
                                if (!hasErrorNode) {
                                    const errorText = document.createElement('p');
                                    errorText.className = 'text-[10px] text-red-500 mt-1 font-bold flex items-center gap-1';
                                    errorText.innerHTML = `<i class="ph-fill ph-warning-circle"></i> ${errorMessages[key][0]}`;
                                    input.parentNode.insertBefore(errorText, input.nextSibling);
                                }
                            }
                        });
                        
                        if (firstErrorElement) {
                            firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            setTimeout(() => firstErrorElement.focus(), 300);
                        }
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
