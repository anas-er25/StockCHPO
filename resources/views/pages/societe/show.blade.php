@extends('layouts.index')
@section('title', 'Liste de sociétés')

@section('csslink')
    <style>
        .hiddenbtn {
            display: none;
        }

        input[type="checkbox"] {
            width: 1.2rem;
            height: 1.2rem;
        }
    </style>
@endsection
@section('content')
    {{-- @dd($societe) --}}
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
                        <div class="card-body p-8">
                            <!-- Titre de la section -->
                            <div class="mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Informations de la Société
                                </h2>
                            </div>

                            <!-- Informations de la Société -->
                            <div class="flex flex-wrap gap-6">
                                <!-- Nom de la Société -->
                                <div class="flex items-center bg-gray-50 p-4 rounded-lg flex-1 min-w-[250px]">
                                    <svg class="w-8 h-8 text-gray-500 mr-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Nom de la Société</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $societe->nom_societe }}</p>
                                    </div>
                                </div>

                                <!-- Siège Social -->
                                <div class="flex items-center bg-gray-50 p-4 rounded-lg flex-1 min-w-[250px]">
                                    <svg class="w-8 h-8 text-gray-500 mr-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Siège Social</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $societe->siege_social ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Téléphone -->
                                <div class="flex items-center bg-gray-50 p-4 rounded-lg flex-1 min-w-[250px]">
                                    <svg class="w-8 h-8 text-gray-500 mr-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Téléphone</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $societe->telephone ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Nombre d'Articles -->
                                <div class="flex items-center bg-gray-50 p-4 rounded-lg flex-1 min-w-[250px]">
                                    <svg class="w-8 h-8 text-gray-500 mr-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Nombre d'Articles</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ $count = \DB::table('societe_materials')->where('societe_id', $societe->id)->count() ?: 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Liste des Matériels -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <div class="text-xl font-semibold">
                                    Liste des Matériels
                                </div>
                            </div>
                            <div class="relative overflow-x-auto mt-8">
                                <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° Inventaire</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Désignation</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Quantité</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Type</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Origine</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Marque</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Modèle</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">N° Série</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">PV</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">CPS</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Sous Reserve</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $groupedMaterials = $societe->materials->groupBy(function ($item) {
                                                return $item->designation .
                                                    '_' .
                                                    $item->type .
                                                    '_' .
                                                    $item->origin .
                                                    '_' .
                                                    $item->modele .
                                                    '_' .
                                                    $item->num_serie;
                                            });
                                        @endphp

                                        @foreach ($groupedMaterials as $group)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200"
                                                data-group-key="{{ $group->first()->num_inventaire }}_{{ $group->first()->origin }}_{{ $group->first()->modele }}_{{ $group->first()->num_serie }}"
                                                data-material-id="{{ $group->first()->id }}">
                                                <td class="px-6 py-4 text-center"
                                                    title="{{ $group->pluck('num_inventaire')->join(', ') }}">
                                                    {{ $group->first()->num_inventaire }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->designation }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->sum('qte') }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->type }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->origin }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->marque }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->modele }}</td>
                                                <td class="px-6 py-4 text-center">{{ $group->first()->num_serie }}</td>
                                                @php
                                                    $societeMaterial = $societe->societeMaterials
                                                        ->where('material_id', $group->first()->id)
                                                        ->first();
                                                @endphp
                                                <td class="px-6 py-4 text-center pv-cell">
                                                    <span
                                                        class="view-mode">{{ $societeMaterial->PV ? 'Oui' : 'Non' }}</span>
                                                    <div class="edit-mode hiddenbtn">
                                                        <input type="checkbox" class="pv-checkbox"
                                                            {{ $societeMaterial->PV ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center cps-cell">
                                                    <span
                                                        class="view-mode">{{ $societeMaterial->CPS ? 'Oui' : 'Non' }}</span>
                                                    <div class="edit-mode hiddenbtn">
                                                        <input type="checkbox" class="cps-checkbox"
                                                            {{ $societeMaterial->CPS ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center observation-cell">
                                                    <span
                                                        class="view-mode">{{ $societeMaterial->observation ?: 'Non spécifié' }}</span>
                                                    <div class="edit-mode hiddenbtn">
                                                        <select name="observation"
                                                            class="observation-select w-full rounded-md">
                                                            <option value="">Sous réserve de:</option>
                                                            <option value="conformité technique"
                                                                {{ $societeMaterial->observation == 'conformité technique' ? 'selected' : '' }}>
                                                                Sous réserve de Conformité technique</option>
                                                            <option value="installation et mise en marche"
                                                                {{ $societeMaterial->observation == 'installation et mise en marche' ? 'selected' : '' }}>
                                                                Sous réserve d'Installation et mise en marche</option>
                                                            <option value="formation"
                                                                {{ $societeMaterial->observation == 'formation' ? 'selected' : '' }}>
                                                                Sous réserve de Formation</option>
                                                            <option value="autres"
                                                                {{ $societeMaterial->observation == 'autres' ? 'selected' : '' }}>
                                                                Sous réserve d'Autres</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <button class="edit-btn cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </button>
                                                    <button class="save-btn hiddenbtn cursor-pointer mr-4">
                                                        <i
                                                            class="fa-solid fa-save text-green-600 hover:text-green-700"></i>
                                                    </button>
                                                    <button class="cancel-btn hiddenbtn cursor-pointer">
                                                        <i class="fa-solid fa-times text-red-600 hover:text-red-700"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    toggleEditMode(row, true);

                });
            });

            document.querySelectorAll('.save-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const row = this.closest('tr');
                    const materialId = row.dataset.materialId;
                    const allInventoryNumbers = row.querySelector('td').getAttribute('title')
                        .split(', ');
                    const societyId = {{ $societe->id }};
                    const pv = row.querySelector('.pv-checkbox').checked;
                    const cps = row.querySelector('.cps-checkbox').checked;
                    const observation = row.querySelector('.observation-select').value;

                    try {
                        const response = await fetch(
                            `/society/${societyId}/material/${materialId}/update-pv-cps`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    inventory_numbers: allInventoryNumbers,
                                    pv,
                                    cps,
                                    observation
                                })
                            });

                        if (response.ok) {
                            const data = await response.json();
                            row.querySelector('.pv-cell .view-mode').textContent = pv ? 'Oui' :
                                'Non';
                            row.querySelector('.cps-cell .view-mode').textContent = cps ?
                                'Oui' : 'Non';
                            row.querySelector('.observation-cell .view-mode').textContent =
                                observation || 'Non spécifié';

                            toggleEditMode(row, false);

                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: data.message,
                                timer: 1500
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue'
                        });
                    }
                });
            });

            document.querySelectorAll('.cancel-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    toggleEditMode(row, false);
                });
            });

            function toggleEditMode(row, isEdit) {
                row.querySelectorAll('.view-mode').forEach(el => el.classList.toggle('hiddenbtn', isEdit));
                row.querySelectorAll('.edit-mode').forEach(el => el.classList.toggle('hiddenbtn', !isEdit));
                row.querySelector('.edit-btn').classList.toggle('hiddenbtn', isEdit);
                row.querySelector('.save-btn').classList.toggle('hiddenbtn', !isEdit);
                row.querySelector('.cancel-btn').classList.toggle('hiddenbtn', !isEdit);
            }
        });
    </script>
@endsection
