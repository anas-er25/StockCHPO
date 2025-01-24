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
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <!-- Informations de la Société -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-xl font-semibold">
                                        Informations de la Société
                                    </div>
                                </div>

                                <div class="card-body">
                                    <p><strong>Nom de la Société:</strong> {{ $societe->nom_societe }}</p>
                                    <p><strong>Siège Social:</strong> {{ $societe->siege_social ?? 'N/A' }}</p>
                                    <p><strong>Téléphone:</strong> {{ $societe->telephone ?? 'N/A' }}</p>
                                    <p><strong>Nombre d'Articles:</strong>
                                        {{ $count =\DB::table('societe_materials')->where('societe_id', $societe->id)->count() ?:0 }}
                                    </p>
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
                                                    <span class="view-mode">{{ $societeMaterial->observation ?: 'Non spécifié' }}</span>
                                                    <div class="edit-mode hiddenbtn">
                                                        <select name="observation" class="observation-select w-full rounded-md">
                                                            <option value="">Sous réserve de:</option>
                                                            <option value="conformité technique" {{ $societeMaterial->observation == 'conformité technique' ? 'selected' : '' }}>
                                                                Sous réserve de Conformité technique</option>
                                                            <option value="installation et mise en marche" {{ $societeMaterial->observation == 'installation et mise en marche' ? 'selected' : '' }}>
                                                                Sous réserve d'Installation et mise en marche</option>
                                                            <option value="formation" {{ $societeMaterial->observation == 'formation' ? 'selected' : '' }}>
                                                                Sous réserve de Formation</option>
                                                            <option value="autres" {{ $societeMaterial->observation == 'autres' ? 'selected' : '' }}>
                                                                Sous réserve d'Autres</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <button class="edit-btn cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </button>
                                                    <button class="save-btn hiddenbtn cursor-pointer mr-4">
                                                        <i class="fa-solid fa-save text-green-600 hover:text-green-700"></i>
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
                            row.querySelector('.pv-cell .view-mode').textContent = pv ? 'Oui' : 'Non';
                            row.querySelector('.cps-cell .view-mode').textContent = cps ? 'Oui' : 'Non';
                            row.querySelector('.observation-cell .view-mode').textContent = observation || 'Non spécifié';

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
