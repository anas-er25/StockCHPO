@extends('layouts.index')
@section('title', 'Créer un service')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Créer</h2>
                                <a href="{{ route('services.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Retour à la liste</a>
                            </div>
                            <form action="{{ route('services.store') }}" method="POST" class="mt-6">
                                @csrf
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-4 space-beetwen-2">
                                    {{-- Hopital --}}
                                    <div>
                                        <label for="hopital_id"
                                            class="block text-sm font-medium text-gray-700">Hôpital</label>
                                        <select name="hopital_id" id="hopital_id"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un hôpital</option>
                                            @foreach ($hopitals as $hopital)
                                                <option value="{{ $hopital->id }}">{{ $hopital->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('hopital_id')" class="mt-2" />
                                    </div>
                                    {{-- Type --}}
                                    <div class="ml-2">
                                        <label for="type" class="block text-sm font-medium text-gray-700">Selectionnez
                                            un Type</label>
                                        <select name="type" id="type" onchange="updateParentServices()"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un type</option>
                                            <option value="departement">Département</option>
                                            <option value="pole">Pôle</option>
                                            <option value="service">Service</option>
                                            <option value="unite">Unité</option>
                                            <option value="bureau">Bureau</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                    </div>
                                    {{-- Parent Service --}}
                                    <div>
                                        <label for="parent_id" class="block text-sm font-medium text-gray-700">Service
                                            Parent</label>
                                        <select name="parent_id" id="parent_id"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un service parent</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->nom }} -
                                                    {{ $service->hopital->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                                    </div>

                                    <div class="ml-2">
                                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" name="nom" id="nom" autocomplete="nom"
                                            value="{{ old('nom') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                                    </div>

                                </div>

                                <!-- Augmentation de l'espace entre l'input et le bouton -->
                                <div class="mt-8"> <!-- Augmenté de mt-6 à mt-8 pour plus d'espace -->
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </main>
@endsection

@section('jslink')
    <script>
        function updateParentServices() {
            console.log('updateParentServices called'); // Debugging
            const type = document.getElementById('type').value;
            const hopitalId = document.getElementById('hopital_id').value; // Récupère l'hôpital sélectionné
            const parentSelect = document.getElementById('parent_id');

            // Effacer les options actuelles
            parentSelect.innerHTML = '<option value="">Sélectionner un service parent</option>';

            if (type && hopitalId) {
                console.log(`Fetching parent services for type: ${type} and hopital_id: ${hopitalId}`); // Debugging
                fetch(`/services/parent-services?type=${type}&hopital_id=${hopitalId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received:', data); // Debugging
                        data.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = `${service.nom} - ${service.hopital.name}`;
                            parentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching parent services:', error)); // Debugging
            }
        }
    </script>
@endsection
