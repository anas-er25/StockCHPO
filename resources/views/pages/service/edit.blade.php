@extends('layouts.index')
@section('title', 'Modifier un service')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Modifier</h2>
                                <a href="{{ route('services.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Retour à la liste</a>
                            </div>
                            <form action="{{ route('services.update', $service->id) }}" method="POST" class="mt-6">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-4">
                                    {{-- Hopital --}}
                                    <div>
                                        <label for="hopital_id"
                                            class="block text-sm font-medium text-gray-700">Hôpital</label>
                                        <select name="hopital_id" id="hopital_id"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionner un hôpital</option>
                                            @foreach ($hopitals as $hopital)
                                                <option value="{{ $hopital->id }}"
                                                    {{ old('hopital_id', $service->hopital_id) == $hopital->id ? 'selected' : '' }}>
                                                    {{ $hopital->name }}
                                                </option>
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
                                            <option value="departement"
                                                {{ old('type', $service->type) == 'departement' ? 'selected' : '' }}>
                                                Département</option>
                                            <option value="pole"
                                                {{ old('type', $service->type) == 'pole' ? 'selected' : '' }}>Pôle</option>
                                            <option value="service"
                                                {{ old('type', $service->type) == 'service' ? 'selected' : '' }}>Service
                                            </option>
                                            <option value="unite"
                                                {{ old('type', $service->type) == 'unite' ? 'selected' : '' }}>Unité
                                            </option>
                                            <option value="bureau"
                                                {{ old('type', $service->type) == 'bureau' ? 'selected' : '' }}>Bureau
                                            </option>

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
                                                <option value="{{ $service->id }}" {{-- Si le service a un parent_id et que c'est celui-ci, sélectionne-le --}}
                                                    {{ old('parent_id', $service->parent_id) == $service->id ? 'selected' : '' }}>
                                                    {{ $service->nom }} - {{ $service->hopital->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                                    </div>
                                    <div class="ml-2">
                                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" name="nom" id="nom" autocomplete="nom"
                                            value="{{ $service->nom }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                                    </div>
                                </div>
                                <!-- Augmentation de l'espace entre l'input et le bouton -->
                                <div class="mt-8">
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
        {{-- </div> --}}
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
