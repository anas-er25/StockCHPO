@extends('layouts.index')
@section('title', 'Liste de Matériels en stock')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <h2 class="text-xl font-semibold">Liste de matériels en stock</h2>
                                </div>

                                <div class="flex items-center gap-4">
                                    {{-- Total in circle --}}
                                    <div
                                        class="flex items-center justify-center bg-blue-600 rounded-full h-8 w-8 text-white">
                                        {{ $materiels->count() }}
                                    </div>

                                    <form action="{{ route('materiels.stock') }}" method="GET"
                                        class="flex items-center space-x-4">
                                        <div class="flex-1 max-w-xs">
                                            <input type="text" name="search" id="search"
                                                placeholder="Rechercher par nom"
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                value="{{ request('search') }}">
                                        </div>
                                        <div class="ml-2 flex-1 max-w-xs">
                                            <select name="etat" id="etat"
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                onchange="this.form.submit()">
                                                <option value="">Tous les états</option>
                                                <option value="réformé" {{ $selectedEtat == 'réformé' ? 'selected' : '' }}>
                                                    Réformé</option>
                                                <option value="réceptionné"
                                                    {{ $selectedEtat == 'réceptionné' ? 'selected' : '' }}>Réceptionné
                                                </option>
                                                <option value="affecté" {{ $selectedEtat == 'affecté' ? 'selected' : '' }}>
                                                    Affecté</option>
                                                <option value="en mouvement"
                                                    {{ $selectedEtat == 'en mouvement' ? 'selected' : '' }}>En mouvement
                                                </option>
                                                <option value="colis fermé"
                                                    {{ $selectedEtat == 'colis fermé' ? 'selected' : '' }}>Colis fermé
                                                </option>
                                            </select>
                                        </div>
                                        <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded-md">
                                            <i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- Statistiques -->
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-4 mb-8 ">
                                <!-- Total en stock -->
                                <div class="p-4 bg-blue-600 rounded-lg hover:shadow-lg transition duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-blue-700">Total en stock</h3>
                                            <p class="text-2xl font-bold text-blue-800">
                                                {{ $materialstotal }}
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                </div>
                                <!-- Entrées (matériels réceptionnés) -->
                                <div class="p-4 bg-teal-500 rounded-lg hover:shadow-lg transition duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-blue-700">Entrées</h3>
                                            <p class="text-2xl font-bold text-blue-800">
                                                {{ $entries }}
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-4 bg-red-500 rounded-lg hover:shadow-lg transition duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-blue-700">Sorties</h3>
                                            <p class="text-2xl font-bold text-blue-800">
                                                {{ $sorties }}
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="relative overflow-x-auto mt-8">
                                <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° d'inventaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'inscription
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Marque</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Modèle</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'affectation
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° de série</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Observation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° de BL</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Nom de société</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° du marché</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Type</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Origine</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">État</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materiels as $material)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center">{{ $material->num_inventaire }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->date_inscription }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->designation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->qte }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->marque }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->modele }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $material->service ? $material->service->nom : 'N/A' }}
                                                    <!-- Assuming 'service' is a relationship -->
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $material->date_affectation }}
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $material->num_serie }}</td>
                                                <td class="px-6 py-4 text-center observation"
                                                    title="{{ $material->observation }}">
                                                    {{ Str::limit($material->observation, 28) }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $material->societe ? $material->societe->numero_bl : 'N/A' }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $material->societe ? $material->societe->nom_societe : 'N/A' }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $material->societe ? $material->societe->numero_marche : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $material->type }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->origin }}</td>
                                                <td class="px-6 py-4 text-center">{{ $material->etat }}</td>
                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <!-- Icône de modification -->
                                                    <a href="{{ route('materiels.edit', $material->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </a>

                                                    <!-- Formulaire de suppression -->
                                                    <form action="{{ route('materiels.destroy', $material->id) }}"
                                                        method="POST" class="inline" id="delete-form-{{ $material->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="cursor-pointer mr-4"
                                                            onclick="confirmDelete({{ $material->id }})">
                                                            <i
                                                                class="fa-solid fa-trash text-red-500 hover:text-red-700"></i>
                                                        </div>
                                                    </form>

                                                    <!-- Icône de téléchargement PDF -->
                                                    <a href="{{ route('materiels.export_pdf', $material->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i
                                                            class="fa-solid fa-download text-blue-600 hover:text-blue-700"></i>
                                                    </a>

                                                    <!-- Icône de vue -->
                                                    <a href="{{ route('materiels.show', $material->id) }}"
                                                        class="cursor-pointer">
                                                        <i class="fa-solid fa-eye text-blue-600 hover:text-blue-700"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center py-4">Aucun matériel trouvé</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
        {{-- </div> --}}
    </main>
@endsection
