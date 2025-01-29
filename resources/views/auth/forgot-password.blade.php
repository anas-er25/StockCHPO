<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="{{ asset('/assets/images/logos/favicon.png') }}" type="image/x-icon">
    <title>Bureau de matériel - CHPO</title>
</head>

<body class="font-sans antialiased">
    <div class="font-sans antialiased">
        <!-- Ajout de l'image de fond -->
        <div class="flex items-center justify-center min-h-screen" style="background-image: url('{{ asset('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80') }}'); background-size: cover; background-position: center;">
            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full px-6 lg:px-8 max-w-full sm:max-w-md md:max-w-lg lg:max-w-7xl">

                    <main class="mt-6">
                        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                            <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
                                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                                    <x-logoauth />

                                    <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">
                                        Réinitialiser le mot de passe
                                    </h2>
                                </div>

                                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                                    <x-auth-session-status class="mb-4" :status="session('status')" />
                                    <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        <div class="w-[300px]">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-900">Adresse
                                                e-mail</label>
                                            <div class="mt-2">
                                                <input type="email" name="email" id="email"
                                                    value="{{ old('email') }}" required autofocus
                                                    autocomplete="username"
                                                    class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-indigo-600 sm:text-sm">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>
                                        </div>

                                        <div>
                                            <button type="submit"
                                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Envoyer par mail
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
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
