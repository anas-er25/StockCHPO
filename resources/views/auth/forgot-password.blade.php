<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="{{ asset('/assets/images/logos/favicon.png') }}" type="image/x-icon">
    <title>Réinitialiser le mot de passe</title>
</head>

<body class="font-sans antialiased">
    <div class="font-sans antialiased">
        <div class="bg-gray-100 flex items-center justify-center min-h-screen">
            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full px-6 lg:px-8 max-w-full sm:max-w-md md:max-w-lg lg:max-w-7xl">

                    <main class="mt-6">
                        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                            <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
                                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                                    {{-- <img class="mx-auto h-10 w-auto"
                                        src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                                        alt="Votre entreprise"> --}}
                                    <x-logo />

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
                    <footer class="py-16 text-center text-sm text-gray-700">
                        Gestion de stock v0.0.1
                    </footer>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
