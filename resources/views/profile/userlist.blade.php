 @can('manage-users')
     @extends('layouts.index')
     @section('title', 'Liste des utilisateurs')

 @section('content')

     <main class="h-full overflow-y-auto max-w-full pt-4">
         {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
         <div class="p-5">
             <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                 <div class="col-span-2">
                     <div class="card">
                         <div class="card-body">
                             <div class="flex justify-between items-center">
                                 <h2 class="text-xl font-semibold">Liste des utilisateurs</h2>
                                 <a href="{{ route('profile.adduser') }}"
                                     class="btn bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2 px-4 py-2 rounded-md">
                                     Ajouter un utilisateur
                                     <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                         viewBox="0 0 50 50">
                                         <path fill="white"
                                             d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                         </path>
                                     </svg>
                                 </a>
                             </div>

                             <div class="relative overflow-x-auto mt-8">
                                 <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                                     <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                         <tr>
                                             <th scope="col" class="text-sm px-6 py-3 text-center">Nom et Prénom</th>
                                             <th scope="col" class="text-sm px-6 py-3 text-center">Email</th>
                                             <th scope="col" class="text-sm px-6 py-3 text-center">Rôle</th>
                                             <th scope="col" class="text-sm px-6 py-3 text-center">Date d'inscription
                                             </th>
                                             <th scope="col" class="text-sm px-6 py-3 text-center">Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @forelse ($users as $profile)
                                             <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                                 <td class="px-6 py-4 text-center">{{ $profile->name }}</td>
                                                 <td class="px-6 py-4 text-center">{{ $profile->email }}</td>
                                                 <td class="px-6 py-4 text-center">{{ $profile->role }}</td>
                                                 <td class="px-6 py-4 text-center">
                                                     {{ $profile->created_at->format('d/m/Y') }}
                                                 </td>

                                                 <td class="px-6 py-4 flex items-center justify-center">
                                                     <!-- Icône de modification -->
                                                     <a href="{{ route('profile.edituser', $profile->id) }}"
                                                         class="cursor-pointer mr-4">
                                                         <i class="fa-solid fa-pen text-blue-600 hover:text-blue-700"></i>
                                                     </a>

                                                     <!-- Formulaire de suppression -->
                                                     <form action="{{ route('profile.destroyuser', $profile->id) }}"
                                                         method="POST" class="inline" id="delete-form-{{ $profile->id }}">
                                                         @csrf
                                                         @method('DELETE')
                                                         <div class="cursor-pointer mr-4"
                                                             onclick="confirmDelete({{ $profile->id }})">
                                                             <i
                                                                 class="fa-solid fa-trash text-red-500 hover:text-red-700"></i>
                                                         </div>
                                                     </form>

                                                     <!-- Icône de active ou desactive -->
                                                     <form action="{{ route('profile.status', $profile->id) }}"
                                                         method="POST">
                                                         @csrf
                                                         @if ($profile->id != auth()->user()->id)
                                                             <!-- Vérifier si ce n'est pas le propre profil de l'utilisateur -->
                                                             <button class="cursor-pointer mr-4">
                                                                 @if ($profile->status == '1')
                                                                     <i class="fa fa-lock text-red-500" title="Active"></i>
                                                                 @elseif($profile->status == '0')
                                                                     <i class="fa fa-unlock text-teal-500"
                                                                         title="Inactif"></i>
                                                                 @endif
                                                             </button>
                                                         @else
                                                             <!-- Si c'est le propre profil de l'utilisateur, ne pas afficher le bouton ou désactiver le bouton -->
                                                             <button type="button" class="cursor-pointer mr-4" disabled>
                                                                 <i class="fa fa-lock text-gray-500"
                                                                     title="Vous ne pouvez pas désactiver votre propre statut"></i>
                                                             </button>
                                                         @endif
                                                     </form>

                                                 </td>

                                             </tr>

                                         @empty
                                             <tr>
                                                 <td colspan="14" class="text-center py-4">Aucun utilisateur trouvé</td>
                                             </tr>
                                         @endforelse
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
         // Fonction de confirmation avant la suppression avec SweetAlert2
         function confirmDelete(userId) {
             Swal.fire({
                 title: 'Êtes-vous sûr?',
                 text: "Cette action est irréversible!",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonText: 'Oui, supprimer!',
                 cancelButtonText: 'Annuler',
                 reverseButtons: true,
                 customClass: {
                     confirmButton: 'bg-red-700 text-white hover:bg-red-800',
                     cancelButton: 'bg-blue-300 text-white hover:bg-blue-600'
                 }
             }).then((result) => {
                 if (result.isConfirmed) {
                     // Soumettre le formulaire de suppression si confirmé
                     document.getElementById('delete-form-' + userId).submit();
                 }
             });
         }
     </script>
 @endsection
@endcan
