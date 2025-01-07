@extends('layouts.index')
@section('title', 'Modifier un service')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="container full-container py-5 flex flex-col gap-6">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Créer un service</h2>
                                <a href="{{ route('services.index') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des services</a>
                            </div>
                            <form action="{{ route('services.update', $service->id) }}" method="POST" class="mt-6">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" name="nom" id="nom" autocomplete="nom"
                                            value="{{$service->nom}}"
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
        </div>
    </main>
@endsection
@section('jslink')

@endsection
