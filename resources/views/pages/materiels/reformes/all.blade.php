@extends('layouts.index')
@section('title', 'Liste du matériel réformé')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste du matériel réformé</h2>
                                <div class="flex items-center gap-4">
                                    <form action="{{ route('reforme.exportSelectedPDF') }}" method="POST" id="export-form">
                                        @csrf
                                        <button type="submit"
                                            class="btn bg-green-500 text-white hover:bg-green-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                            Exporter PDF <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('reforme.reformePDF') }}" title="Télécharger Canevas PDF"
                                        class="btn bg-red-500 text-white hover:bg-red-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Canevas<i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('reforme.addreforme') }}"
                                        class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Ajouter un matériel réformé
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
                                            <th scope="col" class="text-sm px-6 py-3 text-center">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° d'inventaire
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Motif</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Fait le</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reformelist as $reforme)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center">
                                                    <input type="checkbox" name="selected_ids[]" value="{{ $reforme->id }}"
                                                        class="select-item">
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">
                                                    {{ $reforme->material_id ? $reforme->materiel->num_inventaire : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-center font-bold text-black">{{ $reforme->qte }}
                                                </td>

                                                <td class="px-6 py-4 motif text-center font-bold text-black"
                                                    title="{{ $reforme->motif }}">
                                                    {{ Str::limit($reforme->motif, 28) }}
                                                </td>
                                                <td class="px-6 py-4 motif text-center font-bold text-black"
                                                    title="{{ $reforme->designation }}">
                                                    {{ Str::limit($reforme->designation, 28) }}
                                                </td>
                                                <td class="px-6 py-4 motif text-center font-bold text-black"
                                                    title="{{ $reforme->updated_at }}">
                                                    {{ $reforme->updated_at->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <!-- Icône de modification -->
                                                    <a href="{{ route('reforme.reformeedit', $reforme->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </a>

                                                    <!-- Formulaire de suppression -->
                                                    <form action="{{ route('reforme.reformedestroy', $reforme->id) }}"
                                                        method="POST" class="inline" id="delete-form-{{ $reforme->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="cursor-pointer mr-4"
                                                            onclick="confirmDelete({{ $reforme->id }})">
                                                            <i
                                                                class="fa-solid fa-trash text-red-500 hover:text-red-700"></i>
                                                        </div>
                                                    </form>

                                                    {{-- <!-- Icône de téléchargement PDF -->
                                                    <a href="{{ route('reforme.reformePDF', $reforme->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i
                                                            class="fa-solid fa-download text-blue-600 hover:text-blue-700"></i>
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center py-4">Aucun matériel réformé trouvé
                                                </td>
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
        // Sélectionner/désélectionner toutes les cases à cocher
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });


        document.getElementById('export-form').addEventListener('submit', function(event) {
            const selectedIds = Array.from(document.querySelectorAll('.select-item:checked')).map(checkbox =>
                checkbox.value);
            if (selectedIds.length === 0) {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Aucun matériel sélectionné',
                    text: 'Veuillez sélectionner au moins un matériel à exporter.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
            } else {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_ids';
                input.value = JSON.stringify(selectedIds);
                this.appendChild(input);
            }
        });
    </script>
@endsection
