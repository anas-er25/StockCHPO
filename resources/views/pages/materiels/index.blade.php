@extends('layouts.index')
@section('title', 'Liste de Matériels')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste de matériels</h2>
                                <div class="flex items-center gap-4">
                                    <button onclick="exportToExcel()" title="Télécharger Excel"
                                        class="btn bg-green-500 text-white hover:bg-green-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Exporter
                                        <i class="fa-solid fa-file-export"></i>
                                    </button>

                                    <form action="{{ route('materiels.importExcel') }}" method="POST"
                                        enctype="multipart/form-data" class="flex items-center gap-2">
                                        @csrf
                                        <div>
                                            <input type="file" name="file" id="file" class="hidden" required
                                                accept=".xlsx">
                                        </div>
                                        <button type="button"
                                            class="btn bg-green-700 text-white hover:bg-green-700 flex items-center gap-2 px-4 py-2 rounded-md"
                                            onclick="triggerFileInput()">
                                            Importer
                                            <i class="fa-solid fa-file-import"></i>
                                        </button>
                                        <button type="submit" id="submit-btn" class="hidden"></button>
                                    </form>

                                    <a href="{{ route('materiels.create') }}"
                                        class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Ajouter un matériel
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20"
                                            height="20" viewBox="0 0 50 50">
                                            <path fill="white"
                                                d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>

                            </div>

                            <div class="relative overflow-x-auto mt-8">
                                <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-blue-600 uppercase bg-gray-100">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° d'inventaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'inscription
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° de série</th>

                                            <th scope="col" class="text-sm px-6 py-3 text-center">Marque</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Modèle</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Affectation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Date d'affectation
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Observation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Nom de société</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° du marché</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° de BL</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Type</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Origine</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">État</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($materiels as $material)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->num_inventaire }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->date_inscription }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->designation }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">{{ $material->qte }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->num_serie }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->marque }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->modele }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->service ? $material->service->nom : 'N/A' }}
                                                    <!-- Assuming 'service' is a relationship -->
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->date_affectation }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black observation"
                                                    title="{{ $material->observation }}">
                                                    {{ Str::limit($material->observation, 28) }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->societe ? $material->societe->nom_societe : 'N/A' }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->societeMaterials->first() ? $material->societeMaterials->first()->numero_marche : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->societeMaterials->first() ? $material->societeMaterials->first()->numero_bl : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->type }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->origin }}</td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $material->etat }}</td>
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

@section('jslink')
    <script>
        function exportToExcel() {
            // Show loading indicator
            Swal.fire({
                title: 'Export en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const baseUrl = window.location.origin;
            fetch(`${baseUrl}/export-excel`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data || data.length === 0) {
                        throw new Error('Aucune donnée disponible');
                    }

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.json_to_sheet(data);
                    ws['!cols'] = Object.keys(data[0]).map(() => ({
                        wch: 20
                    }));

                    XLSX.utils.book_append_sheet(wb, ws, "Materiels");
                    XLSX.writeFile(wb, `materiels_${new Date().toLocaleDateString('fr-FR').replace(/\//g, '-')}.xlsx`);

                    // Close loading indicator on success
                    Swal.close();
                })
                .catch(error => {
                    console.error('Export error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur d\'exportation',
                        text: error.message || 'Une erreur est survenue lors de l\'exportation.',
                        confirmButtonColor: '#3085d6'
                    });
                });
        }

        function triggerFileInput() {
            // Déclenche l'input file caché
            document.getElementById('file').click();
        }

        // Détecter la sélection du fichier
        document.getElementById('file').addEventListener('change', function() {
            // Soumettre automatiquement le formulaire une fois qu'un fichier est choisi
            if (this.files.length > 0) {
                document.getElementById('submit-btn').click();
            }
        });
    </script>
@endsection
