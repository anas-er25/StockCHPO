@extends('layouts.index')
@section('title', 'Liste des Matériels')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste des matériel</h2>
                                <a href="{{ route('materiels.create') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                    Ajouter un matériel
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                        viewBox="0 0 50 50">
                                        <path fill="white"
                                            d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                        </path>
                                    </svg>
                                </a>
                            </div>

                            <div class="relative overflow-x-auto mt-8">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-base px-6 py-3">Numéro d'inventaire</th>
                                            <th scope="col" class="text-base px-6 py-3">Date d'inscription</th>
                                            <th scope="col" class="text-base px-6 py-3">Désignation</th>
                                            <th scope="col" class="text-base px-6 py-3">Quantité</th>
                                            <th scope="col" class="text-base px-6 py-3">Marque</th>
                                            <th scope="col" class="text-base px-6 py-3">Modèle</th>
                                            <th scope="col" class="text-base px-6 py-3">Service</th>
                                            <th scope="col" class="text-base px-6 py-3">Date d'affectation</th>
                                            <th scope="col" class="text-base px-6 py-3">Numéro de série</th>
                                            <th scope="col" class="text-base px-6 py-3">Type</th>
                                            <th scope="col" class="text-base px-6 py-3">Origine</th>
                                            <th scope="col" class="text-base px-6 py-3">Observation</th>
                                            <th scope="col" class="text-base px-6 py-3">État</th>
                                            <th scope="col" class="text-base px-6 py-3">Numéro BL</th>
                                            <th scope="col" class="text-base px-6 py-3">Numéro Marché</th>
                                            <th scope="col" class="text-base px-6 py-3">Nom société</th>
                                            <th scope="col" class="text-base px-6 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materiels as $material)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4">{{ $material->num_inventaire }}</td>
                                                <td class="px-6 py-4">{{ $material->date_inscription }}</td>
                                                <td class="px-6 py-4">{{ $material->designation }}</td>
                                                <td class="px-6 py-4">{{ $material->qte }}</td>
                                                <td class="px-6 py-4">{{ $material->marque }}</td>
                                                <td class="px-6 py-4">{{ $material->modele }}</td>
                                                <td class="px-6 py-4">
                                                    {{ $material->service ? $material->service->nom : 'N/A' }}
                                                    <!-- Assuming 'service' is a relationship -->
                                                </td>
                                                <td class="px-6 py-4">{{ $material->date_affectation }}</td>
                                                <td class="px-6 py-4">{{ $material->num_serie }}</td>
                                                <td class="px-6 py-4">{{ $material->type }}</td>
                                                <td class="px-6 py-4">{{ $material->origin }}</td>

                                                <td class="px-6 py-4 observation" title="{{ $material->observation }}">
                                                    {{ Str::limit($material->observation, 28) }}
                                                </td>
                                                <td class="px-6 py-4">{{ $material->etat }}</td>
                                                <td class="px-6 py-4">{{ $material->numero_bl }}</td>
                                                <td class="px-6 py-4">{{ $material->numero_marche }}</td>
                                                <td class="px-6 py-4">{{ $material->nom_societe }}</td>
                                                <td class="px-6 py-4 flex items-center">
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
            @include('pages.components.footer')

        </div>
        {{-- </div> --}}
    </main>
@endsection

@section('jslink')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        // Fonction de confirmation avant la suppression avec SweetAlert2
        function confirmDelete(materialId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-red-700 text-white hover:bg-red-800', // Couleur du bouton de confirmation
                    cancelButton: 'bg-blue-300 text-white hover:bg-blue-600' // Couleur du bouton d'annulation
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Soumettre le formulaire de suppression si confirmé
                    document.getElementById('delete-form-' + materialId).submit();
                }
            });
        }
    </script>
@endsection
