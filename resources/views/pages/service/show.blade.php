@extends('layouts.index')
@section('title', 'Liste de sous services')

@section('content')
    {{-- @dd($societe) --}}
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="p-5">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <!-- Liste des Matériels -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <div class="text-xl font-semibold">
                                    Liste des sous services
                                </div>
                            </div>
                            <div class="relative overflow-x-auto mt-8">
                                <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Service</th>
                                            <th scope="col" class="text-sm px-6 py-3 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SousServices as $service)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">

                                                <td class="px-6 py-4 text-center pv-cell">
                                                    {{ $service->nom }}
                                                </td>
                                                <td class="px-6 py-4 flex items-center justify-center">
                                                    <!-- Formulaire de suppression -->
                                                    <form action="{{ route('services.destroy', $service->id) }}"
                                                        method="POST" class="inline" id="delete-form-{{ $service->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="cursor-pointer"
                                                            onclick="confirmDelete({{ $service->id }})">
                                                            <i
                                                                class="fa-solid fa-trash text-red-500 hover:text-red-700"></i>
                                                        </div>
                                                    </form>
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
