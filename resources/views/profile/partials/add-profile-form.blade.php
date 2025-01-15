<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Ajouter un profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ajoutez un nouveau utilisateur avec le rôle de subadmin") }}
        </p>
    </header>

    <!-- Formulaire de renvoi de l'email de vérification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulaire de mise à jour du profil -->
    <form method="post" action="{{ route('profile.store') }}" class="space-y-6">
        @csrf

        <!-- Champ pour le nom -->
        <div class="space-y-2">
            <label for="name" class="text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
            <input id="name" name="name" type="text"
                class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ old('name') }}" required autocomplete="name" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->get('name')" />
        </div>

        <!-- Champ pour l'email -->
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <input id="email" name="email" type="email"
                class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->get('email')" />
        </div>
        <!-- Champ pour le mot de passe -->
        <div class="space-y-2">
            <label for="password" class="text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
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
                value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation" />
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


        <!-- Bouton de soumission -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Sauvegarder') }}
            </button>

            <!-- Message de confirmation après la mise à jour du profil -->
            @if (session('status') === 'profil mis à jour')
                <p class="text-sm text-gray-600">{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
