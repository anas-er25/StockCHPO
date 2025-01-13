@extends('layouts.index')
@section('title', 'Détails du matériel')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Détails du matériel</h2>
                                <a href="{{ route('materiels.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Retour à la liste</a>
                            </div>

                            <div class="mt-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                                    <!-- Numéro d'inventaire -->
                                    <div>
                                        <label for="num_inventaire" class="block text-sm font-medium text-gray-700">Numéro
                                            d'inventaire</label>
                                        <input type="text" id="num_inventaire" value="{{ $material->num_inventaire }}"
                                            readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Date d'inscription -->
                                    <div>
                                        <label for="date_inscription" class="block text-sm font-medium text-gray-700">Date
                                            d'inscription</label>
                                        <input type="date" id="date_inscription"
                                            value="{{ $material->date_inscription }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Désignation -->
                                    <div>
                                        <label for="designation"
                                            class="block text-sm font-medium text-gray-700">Désignation</label>
                                        <input type="text" id="designation" value="{{ $material->designation }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Quantité -->
                                    <div>
                                        <label for="qte"
                                            class="block text-sm font-medium text-gray-700">Quantité</label>
                                        <input type="number" id="qte" value="{{ $material->qte }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Marque -->
                                    <div>
                                        <label for="marque" class="block text-sm font-medium text-gray-700">Marque</label>
                                        <input type="text" id="marque" value="{{ $material->marque }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Modèle -->
                                    <div>
                                        <label for="modele" class="block text-sm font-medium text-gray-700">Modèle</label>
                                        <input type="text" id="modele" value="{{ $material->modele }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Type -->
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <input type="text" id="type" value="{{ ucfirst($material->type) }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Origin -->
                                    <div>
                                        <label for="origin"
                                            class="block text-sm font-medium text-gray-700">Origine</label>
                                        <input type="text" id="origin" value="{{ ucfirst($material->origin) }}"
                                            readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Service -->
                                    <div>
                                        <label for="service_id"
                                            class="block text-sm font-medium text-gray-700">Service</label>
                                        <input type="text" id="service_id"
                                            value="{{ $material->service->nom ?? 'Non attribué' }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Date d'affectation -->
                                    <div>
                                        <label for="date_affectation" class="block text-sm font-medium text-gray-700">Date
                                            d'affectation</label>
                                        <input type="date" id="date_affectation"
                                            value="{{ $material->date_affectation }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Numéro de série -->
                                    <div>
                                        <label for="num_serie" class="block text-sm font-medium text-gray-700">Numéro de
                                            série</label>
                                        <input type="text" id="num_serie" value="{{ $material->num_serie }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Numéro de marché -->
                                    <div>
                                        <label for="numero_marche" class="block text-sm font-medium text-gray-700">Numéro de
                                            marché</label>
                                        <input type="text" id="numero_marche" value="{{ $material->numero_marche }}"
                                            readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Numéro BL -->
                                    <div>
                                        <label for="numero_bl" class="block text-sm font-medium text-gray-700">Numéro
                                            BL</label>
                                        <input type="text" id="numero_bl" value="{{ $material->numero_bl }}" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Nom de société -->
                                    <div>
                                        <label for="nom_societe" class="block text-sm font-medium text-gray-700">Nom de
                                            société</label>
                                        <input type="text" id="nom_societe" value="{{ $material->nom_societe }}"
                                            readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- État -->
                                    <div>
                                        <label for="etat" class="block text-sm font-medium text-gray-700">État</label>
                                        <input type="text" id="etat" value="{{ ucfirst($material->etat) }}"
                                            readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <!-- Observation -->
                                    <div>
                                        <label for="observation"
                                            class="block text-sm font-medium text-gray-700">Observation</label>
                                        <textarea id="observation" rows="3" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $material->observation }}</textarea>
                                    </div>

                                </div>

                                <!-- Bouton de retour -->
                                <div class="mt-8">
                                    <a href="{{ route('materiels.index') }}"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Retour à la liste
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('components.footer')

        </div>
    </main>
@endsection
