@extends('layouts.index')
@section('title', 'Modifier une société')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Modifier une société</h2>
                                <a href="{{ route('societies.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des sociétés</a>
                            </div>
                            <form action="{{ route('societies.update', $societe->id) }}" method="POST" class="mt-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    {{-- Société --}}
                                    <div>
                                        <label for="nom_societe" class="block text-sm font-medium text-gray-700">Nom de société</label>
                                        <input type="text" name="nom_societe" id="nom_societe" required
                                            value="{{ old('nom_societe', $societe->nom_societe ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('nom_societe')" class="mt-2" />
                                    </div>

                                    <!-- Siège social -->
                                    <div>
                                        <label for="siege_social" class="block text-sm font-medium text-gray-700">Siège social</label>
                                        <input type="text" name="siege_social" id="siege_social" required
                                            value="{{ old('siege_social', $societe->siege_social ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('siege_social')" class="mt-2" />
                                    </div>

                                    <!-- Téléphone -->
                                    <div>
                                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input type="tel" name="telephone" id="telephone" required
                                            value="{{ old('telephone', $societe->telephone ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Bouton de soumission -->
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
