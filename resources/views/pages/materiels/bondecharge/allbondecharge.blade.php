@extends('layouts.index')
@section('title', 'Liste des bons de décharge')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste des bons de décharge</h2>
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('bondecharge.exportAllPDF') }}" title="Télécharger Tous PDFs"
                                        class="btn bg-red-500 text-white hover:bg-red-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Tous PDFs<i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('bondecharge.bondecharge') }}"
                                        class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                        Ajouter un bon de décharge
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
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° d'inventaire
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° de série
                                            </th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Motif</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Cédant</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Cessionnaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Fait le</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bonDecharges as $bondecharge)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 text-center">
                                                    {{ $bondecharge->material_id ? $bondecharge->materiel->num_inventaire : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $bondecharge->qte }}</td>
                                                <td class="px-6 py-4 text-center">{{ $bondecharge->num_serie }}</td>
                                                <td class="px-6 py-4 text-center motif" title="{{ $bondecharge->motif }}">
                                                    {{ Str::limit($bondecharge->motif, 28) }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    {{ $bondecharge->cedant_id ? $bondecharge->cedant->nom : '' }}
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $bondecharge->cessionnaire }}</td>
                                                <td class="px-6 py-4 text-center motif"
                                                    title="{{ $bondecharge->updated_at }}">
                                                    {{ $bondecharge->updated_at->format('d/m/Y') }}
                                                </td>

                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <!-- Icône de modification -->
                                                    <a href="{{ route('bondecharge.bondechargeedit', $bondecharge->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </a>

                                                    <!-- Formulaire de suppression -->
                                                    <form
                                                        action="{{ route('bondecharge.bondechargedestroy', $bondecharge->id) }}"
                                                        method="POST" class="inline"
                                                        id="delete-form-{{ $bondecharge->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="cursor-pointer mr-4"
                                                            onclick="confirmDelete({{ $bondecharge->id }})">
                                                            <i
                                                                class="fa-solid fa-trash text-red-500 hover:text-red-700"></i>
                                                        </div>
                                                    </form>

                                                    <!-- Icône de téléchargement PDF -->
                                                    <a href="{{ route('bondecharge.bondechargePDF', $bondecharge->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i
                                                            class="fa-solid fa-download text-blue-600 hover:text-blue-700"></i>
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
