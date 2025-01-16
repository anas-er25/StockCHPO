 @can('manage-users')
@extends('layouts.index')
@section('title', 'Ajouter un utilisateur')

@section('content')

    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold mb-5">Ajouter un utilisateur</h2>
                                <a href="{{ route('profile.userlist') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des utilisateurs</a>
                            </div>
                            <!-- Formulaire de renvoi de l'email de vérification -->
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form action="{{ route('profile.store') }}" method="POST" class="mt-6">
                                @csrf
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">


                                    <!-- Nom et Prenom edit-->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nom et
                                            Prénom</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            required autocomplete="name"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>


                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            required autocomplete="username"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- role -->
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                        <select name="role" id="role" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="admin"
                                                {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                            <option value="subadmin"
                                                {{ old('role') == 'subadmin' ? 'selected' : '' }}>Sous
                                                Admin
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                    </div>
                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">État</label>
                                        <select name="status" id="status" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="1"
                                                {{ old('status') == '1' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0"
                                                {{ old('status') == '0' ? 'selected' : '' }}>
                                                Inactif
                                            </option>

                                        </select>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    </div>
                                    <!-- Champ pour le mot de passe -->
                                    <div class="space-y-2">
                                        <label for="password"
                                            class="text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
                                        <input id="password" name="password" type="password"
                                            class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ old('password') }}" required autocomplete="new-password" />
                                        <x-input-error class="text-sm text-red-500" :messages="$errors->get('password')" />
                                    </div>
                                    <!-- Champ pour Confirme le mot de passe -->
                                    <div class="space-y-2">
                                        <label for="password_confirmation"
                                            class="text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ old('password_confirmation') }}" required
                                            autocomplete="password_confirmation" />
                                        <x-input-error class="text-sm text-red-500" :messages="$errors->get('password_confirmation')" />
                                    </div>
                                    <!-- Bouton pour générer un mot de passe -->
                                    <div class="mt-2">
                                        <button type="button" id="generatePassword"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">
                                            {{ __('Générer un mot de passe') }}
                                        </button>
                                        <button type="button" id="copyPassword"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200 ml-2">
                                            {{ __('Copier') }}
                                        </button>
                                    </div>


                                </div>

                                <!-- Bouton de soumission -->
                                <div class="mt-8">
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />

        </div>
        {{-- </div> --}}
    </main>
@endsection

@section('jslink')
    <script>
        document.getElementById('generatePassword').addEventListener('click', function() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            document.getElementById('password').value = password;
            document.getElementById('password_confirmation').value = password;
        });

        document.getElementById('copyPassword').addEventListener('click', function() {
            const password = document.getElementById('password').value;
            navigator.clipboard.writeText(password).then(function() {
                alert('Mot de passe copié !');
            });
        });
    </script>
@endsection
@endcan
