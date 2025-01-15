<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Mettre à jour le mot de passe') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="current_password" class="text-sm font-medium text-gray-700">{{ __('Mot de passe actuel') }}</label>
            <input id="current_password" name="current_password" type="password" class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="space-y-2">
            <label for="password" class="text-sm font-medium text-gray-700">{{ __('Nouveau mot de passe') }}</label>
            <input id="password" name="password" type="password" class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-medium text-gray-700">{{ __('Confirmez le mot de passe') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600">{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
