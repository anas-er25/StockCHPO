{{-- @can('view', 'admin-permission') --}}
@extends('layouts.index')
@section('title', 'Se connecter')
@section('csslink')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('content')
<body class="font-sans antialiased">
    <div class="font-sans antialiased">
        <div class="bg-gray-100 flex items-center justify-center min-h-screen">
            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full px-6 lg:px-8 max-w-full sm:max-w-md md:max-w-lg lg:max-w-7xl">

    <main class="mt-6">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto"
                        src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Votre entreprise">
                    <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">
                        Connectez-vous à votre compte
                    </h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-900">Adresse
                                e-mail</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username"
                                    class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-indigo-600 sm:text-sm">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-900">Mot de
                                passe</label>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" required
                                    autocomplete="current-password"
                                    class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-indigo-600 sm:text-sm">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Se connecter
                            </button>
                        </div>
                    </form>

                    <p class="mt-10 text-center text-sm text-gray-500">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-500">Mot de passe
                                oublié ?</a>
                        @endif
                    </p>
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

@endsection
{{-- @endcan --}}
