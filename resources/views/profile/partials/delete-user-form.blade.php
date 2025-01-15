<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Supprimer le compte') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        {{ __('Supprimer le compte') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6 p-6">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-semibold text-gray-900">
                {{ __('Etes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
            </p>

            <div class="mt-6 space-y-2">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" class="block w-full p-3 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500" placeholder="{{ __('Mot de passe') }}" />
                <x-input-error class="text-sm text-red-500" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300">
                    {{ __('Annuler') }}
                </button>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    {{ __('Supprimer le compte') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
