@extends('layouts.index')
@section('title', 'Liste des mouvements')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste des mouvements: Réceptionné et Colis fermé</h2>
                                <div class="flex items-center gap-4">

                                    <a href="{{ route('material.historyview') }}"
                                        class="btn bg-gray-600 text-white hover:bg-gray-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Historique <i class="fa-solid fa-eye"></i>
                                    </a>

                                </div>
                            </div>

                            <div class="relative overflow-x-auto mt-8">
                                <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° d'inventaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'inscription</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">État</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($Movements['entries'] as $entry)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center">{{ $entry->num_inventaire }}</td>
                                                <td class="px-6 py-4 text-center">{{ $entry->date_inscription }}</td>
                                                <td class="px-6 py-4 text-center">{{ $entry->designation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $entry->qte }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $entry->service ? $entry->service->nom : 'N/A' }}
                                                    <!-- Assuming 'service' is a relationship -->
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $entry->date_affectation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $entry->etat }}</td>
                                                <td class="px-6 py-4 flex items-center justify-center">

                                                    <!-- Icône de vue -->
                                                    <a href="{{ route('materiels.show', $entry->id) }}"
                                                        class="cursor-pointer">
                                                        <i class="fa-solid fa-eye text-blue-600 hover:text-blue-700"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center py-4">Aucun mouvement trouvé</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste des mouvements: Affecté, En mouvement et Réformé
                                </h2>
                            </div>

                            <div class="relative overflow-x-auto mt-8">
                                <table id="table2" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N d'inventaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'inscription</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">État</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($Movements['outputs'] as $output)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center">{{ $output->num_inventaire }}</td>
                                                <td class="px-6 py-4 text-center">{{ $output->date_inscription }}</td>
                                                <td class="px-6 py-4 text-center">{{ $output->designation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $output->qte }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $output->service ? $output->service->nom : 'N/A' }}
                                                    <!-- Assuming 'service' is a relationship -->
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $output->date_affectation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $output->etat }}</td>
                                                <td class="px-6 py-4 flex items-center justify-center">

                                                    <!-- Icône de vue -->
                                                    <a href="{{ route('materiels.show', $output->id) }}"
                                                        class="cursor-pointer">
                                                        <i class="fa-solid fa-eye text-blue-600 hover:text-blue-700"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center py-4">Aucun mouvement trouvé</td>
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
