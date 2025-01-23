@extends('layouts.index')
@section('title', 'Liste des mouvements')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body bg-white shadow-lg rounded-lg p-6">
                            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                                    Liste des mouvements
                                </h2>
                                <div class="w-full md:w-1/3">
                                    <div class="relative">
                                        <input type="text" id="inventory_number" autofocus
                                            placeholder="Rechercher par N° d'inventaire..."
                                            class="w-full md:w-96 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 pl-12 py-2 transition-all duration-300 ease-in-out focus:outline-none hover:ring-1 hover:ring-gray-400">
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-x-auto mt-8 bg-white rounded-lg" id="results">
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <svg class="w-5 h-5 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">Entrez un N° d'inventaire pour voir l'historique
                                        des mouvements</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('jslink')
    <script>
        document.getElementById('inventory_number').addEventListener('input', function() {
            const inventoryNumber = this.value;
            if (inventoryNumber.length > 0) {
                fetch(`/material?inventory_number=${inventoryNumber}`)
                    .then(response => response.json())
                    .then(data => {
                        const resultsDiv = document.getElementById('results');
                        if (data.material) {
                            let html =
                                `<h2 class="text-xl font-semibold mb-4">Histoire du mouvement du matériel : ${data.material.num_inventaire}</h2>`;
                            if (data.history.length > 0) {
                                html +=
                                    `<div class="flex flex-wrap gap-4 p-4">`;
                                data.history.forEach((record) => {
                                    html += `
                                            <div class="bg-gray-100 rounded-md shadow-md p-4 flex-1 min-w-[calc(33.333%-1rem)] md:min-w-[calc(33.333%-1rem)] lg:min-w-[calc(20%-1rem)]"> <!-- Ajustement de la largeur en fonction de l'écran -->
                                                <div class="flex items-center mb-3">
                                                    <div class="z-10 flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full shrink-0 mr-4">
                                                        <span class="text-white text-sm font-semibold">
                                                            ${data.history.indexOf(record) + 1}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-900">${record.from_service?.nom || 'N/A'} → ${record.to_service?.nom || 'N/A'}</h3>
                                                        <time class="text-sm text-gray-500">${new Date(record.moved_at).toLocaleDateString()}</time>
                                                    </div>
                                                </div>
                                            </div>`;
                                });
                                html += `</div>`;
                            } else {
                                html += `<p>Aucun historique de mouvement disponible.</p>`;
                            }
                            resultsDiv.innerHTML = html;
                        } else {
                            resultsDiv.innerHTML =
                                `<p>Aucun matériel trouvé pour le N° d'inventaire fourni.</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des données matérielles:', error);
                        resultsDiv.innerHTML = `<p>Erreur lors du chargement des données matérielles.</p>`;
                    });
            } else {
                document.getElementById('results').innerHTML = '';
            }
        });
    </script>
@endsection
