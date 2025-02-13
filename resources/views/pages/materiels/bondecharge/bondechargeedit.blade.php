<!-- filepath: /c:/Users/Kival/Documents/Stages/Sidi Hssain Bennaceur/gestionstock/resources/views/pages/materiels/bondecharge.blade.php -->
@extends('layouts.index')

@section('title', 'Bon de Décharge')
@section('csslink')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bondecharge.bondechargeupdate', $bondecharge->id) }}" method="POST" class="mt-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                        <div>
                            <label for="material_id" class="block text-sm font-medium text-gray-700">N°
                                d'inventaire:</label>
                            <input type="text" name="material" id="material"
                                value="{{ old('material_id', $bondecharge->material_id ? $bondecharge->materiel->num_inventaire : 'N/A') }}"
                                readonly
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <x-input-error :messages="$errors->get('material_id')" class="mt-2" />
                        </div>
                        <input type="text" name="material_id" id="material_id"
                            value="{{ old('material_id', $bondecharge->material_id) }}" class="hidden">

                        <div id="material-info">
                            <div>
                                <label for="qte" class="block text-sm font-medium text-gray-700">Quantité:</label>
                                <input type="number" name="qte" id="qte"
                                    value="{{ old('qte', $bondecharge->qte) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <x-input-error :messages="$errors->get('qte')" class="mt-2" />
                            </div>
                            <div>
                                <label for="num_serie" class="block text-sm font-medium text-gray-700">N° de série:</label>
                                <input type="text" name="num_serie" id="num_serie"
                                    value="{{ old('num_serie', $bondecharge->num_serie) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <x-input-error :messages="$errors->get('num_serie')" class="mt-2" />
                            </div>
                            <div>
                                <label for="cedant" class="block text-sm font-medium text-gray-700">Cédant:</label>
                                <input type="text" name="cedant" id="cedant" readonly
                                    value="{{ old('cedant', $bondecharge->cedant_id ? $bondecharge->cedant->nom : '') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <x-input-error :messages="$errors->get('cedant')" class="mt-2" />
                            </div>
                            <!-- Champ caché pour envoyer l'ID du service -->
                            <input type="hidden" name="cedant_id" id="cedant_id"
                                value="{{ old('cedant_id', $bondecharge->cedant_id) }}">
                            <div>
                                <label for="cessionnaire"
                                    class="block text-sm font-medium text-gray-700">Cessionnaire:</label>
                                <input type="text" name="cessionnaire" id="cessionnaire"
                                    value="{{ old('cessionnaire', $bondecharge->cessionnaire) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <x-input-error :messages="$errors->get('cessionnaire')" class="mt-2" />
                            </div>
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                                <select name="type" id="type"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="provisoire"
                                        {{ old('type', $bondecharge->type) == 'provisoire' ? 'selected' : '' }}>
                                        Provisoire</option>
                                    <option value="definitive"
                                        {{ old('type', $bondecharge->type) == 'definitive' ? 'selected' : '' }}>
                                        Définitive</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                            <div>
                                <label for="motif" class="block text-sm font-medium text-gray-700">Motif de
                                    décharge:</label>
                                <textarea name="motif" id="motif" rows="3"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('motif', $bondecharge->motif) }}</textarea>
                                <x-input-error :messages="$errors->get('motif')" class="mt-2" />
                            </div>
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
            <x-footer />
        </div>
    </main>

@endsection

@section('jslink')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#material_id').select2({
                placeholder: "Sélectionner un N° d'inventaire",
                allowClear: true
            });
        });
    </script>
@endsection
