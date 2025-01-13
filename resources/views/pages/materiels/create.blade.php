@extends('layouts.index')
@section('title', 'Créer un service')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Créer un matériel</h2>
                                <a href="{{ route('materiels.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des matériels</a>
                            </div>
                            <form action="{{ route('materiels.store') }}" method="POST" class="mt-6">
                                @csrf
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                                    <!-- Numéro d'inventaire -->
                                    <div>
                                        <label for="num_inventaire" class="block text-sm font-medium text-gray-700">Numéro
                                            d'inventaire</label>
                                        <input type="text" name="num_inventaire" id="num_inventaire"
                                            value="{{ old('num_inventaire') }}" required autofocus
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('num_inventaire')" class="mt-2" />
                                    </div>
                                    <!-- Date d'inscription -->
                                    <div>
                                        <label for="date_inscription" class="block text-sm font-medium text-gray-700">Date
                                            d'inscription</label>
                                        <input type="date" name="date_inscription" id="date_inscription"
                                            value="{{ old('date_inscription') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('date_inscription')" class="mt-2" />
                                    </div>
                                    <!-- Désignation -->
                                    <div>
                                        <label for="designation"
                                            class="block text-sm font-medium text-gray-700">Désignation</label>
                                        <input type="text" name="designation" id="designation"
                                            value="{{ old('designation') }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                                    </div>

                                    <!-- Quantité -->
                                    <div>
                                        <label for="qte"
                                            class="block text-sm font-medium text-gray-700">Quantité</label>
                                        <input type="number" name="qte" id="qte" value="{{ old('qte') }}"
                                            required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('qte')" class="mt-2" />
                                    </div>
                                    <!-- Marque -->
                                    <div>
                                        <label for="marque" class="block text-sm font-medium text-gray-700">Marque</label>
                                        <input type="text" name="marque" id="marque" value="{{ old('marque') }}"
                                            required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('marque')" class="mt-2" />
                                    </div>

                                    <!-- Modèle -->
                                    <div>
                                        <label for="modele" class="block text-sm font-medium text-gray-700">Modèle</label>
                                        <input type="text" name="modele" id="modele" value="{{ old('modele') }}"
                                            required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('modele')" class="mt-2" />
                                    </div>
                                    <!-- Type -->
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <select name="type" id="type" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="hospitalier"
                                                {{ old('type') == 'hospitalier' ? 'selected' : '' }}>
                                                Hospitalier</option>
                                            <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau
                                            </option>
                                            <option value="biomédical" {{ old('type') == 'biomédical' ? 'selected' : '' }}>
                                                Biomédical</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                    </div>

                                    <!-- Origin -->
                                    <div>
                                        <label for="origin" class="block text-sm font-medium text-gray-700">Origin</label>
                                        <select name="origin" id="origin" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="achat" {{ old('origin') == 'achat' ? 'selected' : '' }}>Achat
                                            </option>
                                            <option value="don" {{ old('origin') == 'don' ? 'selected' : '' }}>Don
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('origin')" class="mt-2" />
                                    </div>

                                    <!-- Service -->
                                    <div>
                                        <label for="service_id"
                                            class="block text-sm font-medium text-gray-700">Service</label>
                                        <select name="service_id" id="service_id"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                                    </div>
                                    <!-- Date d'affectation -->
                                    <div>
                                        <label for="date_affectation" class="block text-sm font-medium text-gray-700">Date
                                            d'affectation</label>
                                        <input type="date" name="date_affectation" id="date_affectation"
                                            value="{{ old('date_affectation') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('date_affectation')" class="mt-2" />
                                    </div>

                                    <!-- Numéro de série -->
                                    <div>
                                        <label for="num_serie" class="block text-sm font-medium text-gray-700">Numéro de
                                            série</label>
                                        <input type="text" name="num_serie" id="num_serie"
                                            value="{{ old('num_serie') }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('num_serie')" class="mt-2" />
                                    </div>



                                    <!-- Numéro de marché -->
                                    <div>
                                        <label for="numero_marche" class="block text-sm font-medium text-gray-700">Numéro
                                            de
                                            marché</label>
                                        <input type="text" name="numero_marche" id="numero_marche" required
                                            value="{{ old('numero_marche') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_marche')" class="mt-2" />
                                    </div>

                                    <!-- Numéro BL -->
                                    <div>
                                        <label for="numero_bl" class="block text-sm font-medium text-gray-700">Numéro
                                            BL</label>
                                        <input type="text" name="numero_bl" id="numero_bl"
                                            value="{{ old('numero_bl') }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_bl')" class="mt-2" />
                                    </div>

                                    <!-- Nom de société -->
                                    <div>
                                        <label for="nom_societe" class="block text-sm font-medium text-gray-700">Nom de
                                            société</label>
                                        <input type="text" name="nom_societe" id="nom_societe"
                                            value="{{ old('nom_societe') }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('nom_societe')" class="mt-2" />
                                    </div>

                                    <!-- État -->
                                    <div>
                                        <label for="etat" class="block text-sm font-medium text-gray-700">État</label>
                                        <select name="etat" id="etat" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="réceptionné"
                                                {{ old('etat') == 'réceptionné' ? 'selected' : '' }}>
                                                Réceptionné</option>
                                            <option value="affecté" {{ old('etat') == 'affecté' ? 'selected' : '' }}>
                                                Affecté
                                            </option>
                                            <option value="en mouvement"
                                                {{ old('etat') == 'en mouvement' ? 'selected' : '' }}>En mouvement</option>
                                            <option value="réformé" {{ old('etat') == 'réformé' ? 'selected' : '' }}>
                                                Réformé
                                            </option>
                                            <option value="colis fermé"
                                                {{ old('etat') == 'colis fermé' ? 'selected' : '' }}>
                                                colis fermé
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('etat')" class="mt-2" />
                                    </div>
                                    <!-- Observation -->
                                    <div>
                                        <label for="observation"
                                            class="block text-sm font-medium text-gray-700">Observation</label>
                                        <textarea name="observation" id="observation" rows="3"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observation') }}</textarea>
                                        <x-input-error :messages="$errors->get('observation')" class="mt-2" />
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
            @include('components.footer')

        </div>
        {{-- </div> --}}
    </main>


@endsection
@section('jslink')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const numInventaireInput = document.getElementById("num_inventaire");
            const currentYear = new Date().getFullYear();
            const lastTwoDigitsOfYear = currentYear.toString().slice(-
                2); // Obtenir les 2 derniers chiffres de l'année

            // Lorsque l'utilisateur saisit un numéro d'inventaire
            numInventaireInput.addEventListener("input", function() {
                const numInputValue = numInventaireInput.value;
                if (numInputValue && !numInputValue.includes('/')) {
                    // Ajouter les deux derniers chiffres de l'année à la fin
                    numInventaireInput.value = `${numInputValue}/${lastTwoDigitsOfYear}`;
                }
            });
        });
    </script>
@endsection
