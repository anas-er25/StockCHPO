@extends('layouts.index')

@section('title', 'Avis de mouvement')
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

                <form action="{{ route('avismvt.avismvtupdate', $avismvt->id) }}" method="POST" class="mt-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                        <div>
                            <label for="material_id" class="block text-sm font-medium text-gray-700">Numéro
                                d'inventaire:</label>
                            <input type="text" name="material" id="material"
                                value="{{ old('material_id', $avismvt->material_id ? $avismvt->materiel->num_inventaire : 'N/A') }}"
                                readonly
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <x-input-error :messages="$errors->get('material_id')" class="mt-2" />
                        </div>
                        <input type="text" name="material_id" id="material_id"
                            value="{{ old('material_id', $avismvt->material_id) }}" class="hidden">

                        <div id="material-info">
                            <div>
                                <label for="qte" class="block text-sm font-medium text-gray-700">Quantité:</label>
                                <input type="number" name="qte" id="qte" value="{{ old('qte', $avismvt->qte) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <x-input-error :messages="$errors->get('qte')" class="mt-2" />
                            </div>

                            <div>
                                <label for="cedant_id" class="block text-sm font-medium text-gray-700">Cédant:</label>
                                <select name="cedant_id" id="cedant_id"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    aria-label="Sélectionner le Cédant">
                                    <option value="">Sélectionner un Cédant</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('cedant_id', $avismvt->cedant_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('cedant_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="cessionnaire"
                                    class="block text-sm font-medium text-gray-700">Cessionnaire:</label>
                                <select name="cessionnaire_id" id="cessionnaire_id"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    aria-label="Sélectionner le Cessionnaire">
                                    <option value="">Sélectionner un Cessionnaire</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('cessionnaire_id', $avismvt->cessionnaire_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('cessionnaire_id')" class="mt-2" />
                            </div>


                            <div>
                                <label for="motif" class="block text-sm font-medium text-gray-700">Motif de
                                    décharge:</label>
                                <textarea name="motif" id="motif" rows="3"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('motif', $avismvt->motif) }}</textarea>
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
                placeholder: "Sélectionner un Numéro d'inventaire",
                allowClear: true
            });
        });
    </script>
@endsection
