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
                                        <label for="nom_societe" class="block text-sm font-medium text-gray-700">Nom de
                                            société</label>
                                        <input type="text" name="nom_societe" id="nom_societe" required
                                            value="{{ old('nom_societe', $societe->nom_societe ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('nom_societe')" class="mt-2" />
                                    </div>

                                    <!-- Numéro de marché -->
                                    <div>
                                        <label for="numero_marche" class="block text-sm font-medium text-gray-700">Numéro
                                            de marché</label>
                                        <input type="text" name="numero_marche" id="numero_marche" required
                                            value="{{ old('numero_marche', $societe->numero_marche ?? '') }}"
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_marche')" class="mt-2" />
                                    </div>

                                    <!-- Numéro BL -->
                                    <div>
                                        <label for="numero_bl" class="block text-sm font-medium text-gray-700">Numéro
                                            BL</label>
                                        <input type="text" name="numero_bl" id="numero_bl"
                                            value="{{ old('numero_bl', $societe->numero_bl ?? '') }}" required
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <x-input-error :messages="$errors->get('numero_bl')" class="mt-2" />
                                    </div>

                                    {{-- PV and CPS --}}
                                    <div class="flex space-x-8 mt-2">
                                        <div class="pr-3">
                                            <label for="pv" class="block text-sm font-medium text-gray-700">PV</label>
                                            <div class="flex items-center mt-1">
                                                <input type="checkbox" name="pv" id="pv"
                                                    {{ old('pv', $societe->PV) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                                <span
                                                    class="ml-2 pl-3">{{ old('pv', $societe->PV ?? 'aucun PV assigné') }}</span>
                                            </div>
                                            <x-input-error :messages="$errors->get('pv')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label for="cps"
                                                class="block text-sm font-medium text-gray-700">CPS</label>
                                            <div class="flex items-center mt-1">
                                                <input type="checkbox" name="cps" id="cps"
                                                    {{ old('cps', $societe->CPS) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                                <span
                                                    class="ml-2 pl-3">{{ old('cps', $societe->CPS ?? 'aucun CPS assigné') }}</span>
                                            </div>
                                            <x-input-error :messages="$errors->get('cps')" class="mt-2" />
                                        </div>
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
