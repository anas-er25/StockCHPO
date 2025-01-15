<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Informations sur le profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de profil et l'adresse e-mail de votre compte.") }}
        </p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <label for="name" class="text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
            <input id="name" name="name" type="text"
                class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ old('name', $user->name) }}" required autocomplete="name" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <input id="email" name="email" type="email"
                class="block w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="text-sm text-red-500" :messages="$errors->get('email')" />
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-4">
                <p class="text-sm text-gray-800">
                    {{ __('Votre adresse email n\'est pas vérifiée.') }}
                    <button form="send-verification" class="underline text-sm text-indigo-600 hover:text-indigo-900">
                        {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'profil mis à jour')
                <p class="text-sm text-gray-600">{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
