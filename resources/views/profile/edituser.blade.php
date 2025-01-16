 @can('manage-users')
     @extends('layouts.index')
     @section('title', 'Modifier un utilisateur')

 @section('content')
     <main class="h-full overflow-y-auto max-w-full pt-4">
         {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
         <div class="p-5">
             <div class="grid grid-cols-1 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                 <div class="col-span-2">
                     <div class="card">
                         <div class="card-body">
                             <div class="flex justify-between items-center">
                                 <h2 class="text-xl font-semibold mb-5">Modifier un utilisateur</h2>
                                 <a href="{{ route('profile.userlist') }}"
                                     class="btn bg-blue-600 text-white hover:bg-blue-700">Liste des utilisateurs</a>
                             </div>

                             <form action="{{ route('profile.updateuser', $user->id) }}" method="POST" class="mt-6">
                                 @csrf
                                 @method('PUT')
                                 <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">


                                     <!-- Nom et Prenom edit-->
                                     <div>
                                         <label for="name" class="block text-sm font-medium text-gray-700">Nom et
                                             Prénom</label>
                                         <input type="text" name="name" id="name"
                                             value="{{ old('name', $user->name) }}" required
                                             class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                         <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                     </div>


                                     <!-- Email -->
                                     <div>
                                         <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                         <input type="email" name="email" id="email"
                                             value="{{ old('email', $user->email) }}" required
                                             class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                         <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                     </div>

                                     <!-- role -->
                                     <div>
                                         <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                         <select name="role" id="role" required
                                             class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                             <option value="admin"
                                                 {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                 Admin</option>
                                             <option value="subadmin"
                                                 {{ old('role', $user->role) == 'subadmin' ? 'selected' : '' }}>Sous
                                                 Admin
                                             </option>
                                         </select>
                                         <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                     </div>
                                     <!-- Status -->
                                     <div>
                                         <label for="status" class="block text-sm font-medium text-gray-700">État</label>
                                         <select name="status" id="status" required
                                             class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                             <option value="1"
                                                 {{ old('status', $user->status) == '1' ? 'selected' : '' }}>
                                                 Active</option>
                                             <option value="0"
                                                 {{ old('status', $user->status) == '0' ? 'selected' : '' }}>
                                                 Inactif
                                             </option>

                                         </select>
                                         <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
@endcan
