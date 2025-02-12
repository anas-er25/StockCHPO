<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestion de stock') }}</title>
    <link rel="shortcut icon" href="{{ asset('/assets/images/logos/favicon.png') }}" type="image/x-icon">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-blue-200">
        @include('layouts.navigation')


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
     <script>
        // Disable right click
        document.addEventListener('contextmenu', e => e.preventDefault());

        document.addEventListener('DOMContentLoaded', () => {
            // Disable right click with better performance
            document.addEventListener('contextmenu', e => e.preventDefault(), {
                passive: true
            });

            // Optimize keyboard event listener
            document.addEventListener('keydown', e => {
                if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                    (e.ctrlKey && e.key === 'u') ||
                    (e.ctrlKey && e.key === 'U') ||
                    (e.key === 'F12')) {
                    e.preventDefault();
                }
            }, {
                passive: false
            });

            // More efficient DevTools detection
            let devToolsCheck = () => {
                const threshold = 160;
                const widthThreshold = window.outerWidth - window.innerWidth > threshold;
                const heightThreshold = window.outerHeight - window.innerHeight > threshold;
                if (widthThreshold || heightThreshold) {
                    window.location.reload();
                }
            };
            setInterval(devToolsCheck, 1000);
        });
    </script>
</body>

</html>
