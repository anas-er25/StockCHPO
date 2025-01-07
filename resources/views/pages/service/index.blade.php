@extends('layouts.index')
@section('title', 'Services')

@section('content')
    <main class="h-full overflow-y-auto max-w-full pt-4">
        <div class="container full-container py-5 flex flex-col gap-6">
            <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold">Liste des services</h2>
                                <a href="{{ route('services.create') }}"
                                    class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                    Ajouter un service
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                        viewBox="0 0 50 50">
                                        <path fill="white"
                                            d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                        </path>
                                    </svg>
                                </a>
                            </div>

                            <div class="relative overflow-x-auto mt-8">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="text-base px-6 py-3">
                                                Nom du service
                                            </th>
                                            <th scope="col" class="text-base px-6 py-3">
                                                Date de création
                                            </th>
                                            <th scope="col" class="text-base px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <td scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $service->nom }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $service->created_at }}
                                                </td>
                                                <td class="px-6 py-4 flex items-center">
                                                    <a href="{{ route('services.edit', $service->id) }}"
                                                        class="cursor-pointer mr-4">
                                                        <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                    </a>

                                                    <!-- Formulaire de suppression -->
                                                    <form action="{{ route('services.destroy', $service->id) }}"
                                                        method="POST" class="inline" id="delete-form-{{ $service->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="cursor-pointer" onclick="confirmDelete({{ $service->id }})">
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
        </div>
    </main>
@endsection

@section('jslink')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        // Fonction de confirmation avant la suppression avec SweetAlert2
        function confirmDelete(serviceId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'bg-red-700 text-white hover:bg-red-800',  // Couleur du bouton de confirmation
                    cancelButton: 'bg-blue-300 text-white hover:bg-blue-600'  // Couleur du bouton d'annulation
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Soumettre le formulaire de suppression si confirmé
                    document.getElementById('delete-form-' + serviceId).submit();
                }
            });
        }
    </script>
@endsection
