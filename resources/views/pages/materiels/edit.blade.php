@extends('layouts.index')
@section('title', 'Modifier un materiel')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Modifier un materiel</h2>
                                <a href="{{ route('materiels.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des materiels</a>
                            </div>
                            <form action="{{ route('materiels.update', $material->id) }}" method="POST" class="mt-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                                    {{-- <!-- N° d'inventaire --> --}}
                                    <div>
                                        <label for="num_inventaire" class="block text-sm font-medium text-gray-700">N°
                                            d'inventaire</label>
                                        <input type="text" name="num_inventaire" id="num_inventaire"
                                            value="{{ old('num_inventaire', $material->num_inventaire) }}" required
                                            autofocus
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            readonly>
                                        <x-input-error :messages="$errors->get('num_inventaire')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Date d'inscription --> --}}
                                    <div>
                                        <label for="date_inscription" class="block text-sm font-medium text-gray-700">Date
                                            d'inscription</label>
                                        <input type="date" name="date_inscription" id="date_inscription"
                                            value="{{ old('date_inscription', $material->date_inscription) }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('date_inscription')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Désignation --> --}}
                                    <div>
                                        <label for="designation"
                                            class="block text-sm font-medium text-gray-700">Désignation</label>
                                        <input type="text" name="designation" id="designation"
                                            value="{{ old('designation', $material->designation) }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Quantité --> --}}
                                    <div>
                                        <label for="qte"
                                            class="block text-sm font-medium text-gray-700">Quantité</label>
                                        <input type="number" name="qte" id="qte"
                                            value="{{ old('qte', $material->qte) }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('qte')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Marque --> --}}
                                    <div>
                                        <label for="marque" class="block text-sm font-medium text-gray-700">Marque</label>
                                        <input type="text" name="marque" id="marque"
                                            value="{{ old('marque', $material->marque) }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('marque')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Modèle --> --}}
                                    <div>
                                        <label for="modele" class="block text-sm font-medium text-gray-700">Modèle</label>
                                        <input type="text" name="modele" id="modele"
                                            value="{{ old('modele', $material->modele) }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('modele')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Type --> --}}
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <select name="type" id="type" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="hospitalier"
                                                {{ old('type', $material->type) == 'hospitalier' ? 'selected' : '' }}>
                                                Hospitalier</option>
                                            <option value="bureau"
                                                {{ old('type', $material->type) == 'bureau' ? 'selected' : '' }}>Bureau
                                            </option>
                                            <option value="biomédical"
                                                {{ old('type', $material->type) == 'biomédical' ? 'selected' : '' }}>
                                                Biomédical</option>
                                            <option value="dispositif medicaux"
                                                {{ old('type', $material->type) == 'dispositif medicaux' ? 'selected' : '' }}>
                                                Dispositif medicaux</option>
                                            <option value="autres"
                                                {{ old('type', $material->type) == 'autres' ? 'selected' : '' }}>
                                                Autres</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Origin --> --}}
                                    <div>
                                        <label for="origin"
                                            class="block text-sm font-medium text-gray-700">Origine</label>
                                        <select name="origin" id="origin" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="bon de commande"
                                                {{ old('origin', $material->origin) == 'bon de commande' ? 'selected' : '' }}>
                                                Bon de commande</option>
                                            <option value="marché négociés"
                                                {{ old('origin', $material->origin) == 'marché négociés' ? 'selected' : '' }}>
                                                Marché négociés</option>
                                            <option value="convention"
                                                {{ old('origin', $material->origin) == 'convention' ? 'selected' : '' }}>
                                                Convention</option>
                                            <option value="marché"
                                                {{ old('origin', $material->origin) == 'marché' ? 'selected' : '' }}>Marché
                                            </option>
                                            <option value="dons"
                                                {{ old('origin', $material->origin) == 'dons' ? 'selected' : '' }}>Dons
                                            </option>
                                            <option value="autres"
                                                {{ old('origin', $material->origin) == 'autres' ? 'selected' : '' }}>Autres
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('origin')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Service --> --}}
                                    <div>
                                        <label for="service_id"
                                            class="block text-sm font-medium text-gray-700">Service</label>
                                        <select name="service_id" id="service_id"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ old('service_id', $material->service_id) == $service->id ? 'selected' : '' }}>
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
                                            value="{{ old('date_affectation', $material->date_affectation) }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('date_affectation')" class="mt-2" />
                                    </div>

                                    {{-- <!-- N°  de N° de série --> --}}
                                    <div>
                                        <label for="num_serie" class="block text-sm font-medium text-gray-700">N° de
                                            série</label>
                                        <input type="text" name="num_serie" id="num_serie"
                                            value="{{ old('num_serie', $material->num_serie) }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('num_serie')" class="mt-2" />
                                    </div>

                                    {{-- Société --}}
                                    <div class="col-span-1">
                                        <label for="societe_id"
                                            class="block text-sm font-medium text-gray-700">Société</label>
                                        <div class="flex items-center gap-2">
                                            <div id="societe_id_container" class="flex-1">
                                                <select name="societe_id" id="societe_id"
                                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    <option value="">Sélectionner une société</option>
                                                    @foreach ($societes as $societe)
                                                        <option value="{{ $societe->id }}"
                                                            {{ old('societe_id', $material->societe_id) == $societe->id ? 'selected' : '' }}>
                                                            {{ $societe->nom_societe }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="nouvelle_societe_container" class="flex-1 hidden">
                                                <input type="text" name="nouvelle_societe" id="nouvelle_societe"
                                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    placeholder="Nouvelle société">
                                            </div>
                                            <button type="button" onclick="toggleSocieteFields()"
                                                class="mt-1 p-2 bg-blue-600 text-white rounded-md hover:bg-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <x-input-error :messages="$errors->get('societe_id')" class="mt-2" />
                                        <x-input-error :messages="$errors->get('nouvelle_societe')" class="mt-2" />
                                    </div>

                                    {{-- <!-- N°  de marché --> --}}
                                    <div>
                                        <label for="numero_marche" class="block text-sm font-medium text-gray-700">N°
                                            de marché</label>
                                        <input type="text" name="numero_marche" id="numero_marche" required
                                            value="{{ old('numero_marche', $material->societeMaterials->first()->numero_marche ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_marche')" class="mt-2" />
                                    </div>

                                    {{-- <!-- N°  de BL --> --}}
                                    <div>
                                        <label for="numero_bl" class="block text-sm font-medium text-gray-700">N°
                                            BL</label>
                                        <input type="text" name="numero_bl" id="numero_bl"
                                            value="{{ old('numero_bl', $material->societeMaterials->first()->numero_bl ?? '') }}"
                                            required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_bl')" class="mt-2" />
                                    </div>
                                    {{-- État --}}
                                    <div>
                                        <label for="etat" class="block text-sm font-medium text-gray-700">État</label>
                                        <select name="etat" id="etat" required
                                            onchange="toggleReceptionOptions()"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="réceptionné"
                                                {{ old('etat', $material->etat) == 'réceptionné' ? 'selected' : '' }}>
                                                Réceptionné</option>
                                            <option value="affecté"
                                                {{ old('etat', $material->etat) == 'affecté' ? 'selected' : '' }}>
                                                Affecté
                                            </option>
                                            <option value="en mouvement"
                                                {{ old('etat', $material->etat) == 'en mouvement' ? 'selected' : '' }}>
                                                En mouvement</option>
                                            <option value="réformé"
                                                {{ old('etat', $material->etat) == 'réformé' ? 'selected' : '' }}>
                                                Réformé
                                            </option>
                                        </select>
                                        <div id="receptionOptions" class="mt-2 space-y-2" style="display: none;">
                                            <div class="flex items-center mt-2">
                                                <input type="radio" name="etat" id="provisoire" value="provisoire"
                                                    {{ old('etat', $material->etat) == 'provisoire' ? 'checked' : '' }}
                                                    class="pl-3">
                                                <label for="provisoire" class="pl-3">Provisoire</label>
                                            </div>
                                            <div class="flex items-center ml-2 mt-2 ">
                                                <input type="radio" name="etat" id="définitive" value="définitive"
                                                    {{ old('etat', $material->etat) == 'définitive' ? 'checked' : '' }}
                                                    class="pl-3">
                                                <label for="définitive" class="pl-3">Définitive</label>
                                            </div>
                                            <div class="flex items-center ml-2 mt-2 ">
                                                <input type="radio" name="etat" id="colis fermé"
                                                    value="colis fermé"
                                                    {{ old('etat', $material->etat) == 'colis fermé' ? 'checked' : '' }}
                                                    class="pl-3">
                                                <label for="colis fermé" class="pl-3">Colis fermé</label>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('etat')" class="mt-2" />
                                    </div>

                                    {{-- <!-- Observation --> --}}
                                    <div>
                                        <label for="observation"
                                            class="block text-sm font-medium text-gray-700">Observation</label>
                                        <textarea name="observation" id="observation" rows="3"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observation', $material->observation) }}</textarea>
                                        <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                                    </div>

                                </div>

                                {{-- <!-- Bouton de soumission --> --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date_inscription');
            const numInventaireInput = document.getElementById('num_inventaire');

            dateInput.addEventListener('input', function() {
                const year = new Date(dateInput.value).getFullYear();
                const lastTwoDigits = year.toString().slice(-2);
                const numEntered = document.getElementById('qte')
                    .value; // Assuming quantity is the base for the number
                numInventaireInput.value = numEntered + '/' + lastTwoDigits;
            });
        });

        function toggleSocieteFields() {
            const selectField = document.getElementById('societe_id_container');
            const inputField = document.getElementById('nouvelle_societe_container');

            if (selectField.classList.contains('hidden')) {
                selectField.classList.remove('hidden');
                inputField.classList.add('hidden');
            } else {
                selectField.classList.add('hidden');
                inputField.classList.remove('hidden');
            }
        }


        // Toggle reception options
        function toggleReceptionOptions() {
            const etatSelect = document.getElementById('etat');
            const receptionOptions = document.getElementById('receptionOptions');
            receptionOptions.style.display = etatSelect.value === 'réceptionné' ? 'block' : 'none';
        }
        // Run on page load
        document.addEventListener('DOMContentLoaded', toggleReceptionOptions);
    </script>
@endsection
