<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function userlist(): View
    {
        $users = User::all();
        return view('profile.userlist', [
            'users' => $users
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $user = $request->user()->save();
        // dd($user);
        // if ($user) {
        //     // Créer le log
        //     Log::create([
        //         'action' => 'update',
        //         'table_name' => 'users',
        //         'record_id' => $user->id,
        //         'performed_by' => Auth::user()->id,
        //         'performed_at' => now()
        //     ]);
        // }

        return Redirect::route('profile.edit')->with('status', 'profil mis à jour');
    }


    public function edituser($id): View
    {
        $user = User::find($id);
        return view('profile.edituser', [
            'user' => $user
        ]);
    }

    public function updateuser(Request $request, $id): RedirectResponse
    {
        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;
        if ($user->save()) {
            // Créer le log
            Log::create([
                'action' => 'update',
                'table_name' => 'users',
                'record_id' => $user->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return Redirect::route('profile.userlist')->with('status', 'Utilisateur mis à jour');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Add a new user with default 'subadmin' role.
     */
    public function adduser()
    {
        return view('profile.adduser');
    }
    public function store(Request $request): RedirectResponse
    {
        // Validation des données d'entrée
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'status' => 'required|string'
        ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            // Créer le log
            Log::create([
                'action' => 'create',
                'table_name' => 'users',
                'record_id' => $user->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return Redirect::route('profile.userlist')->with('status', 'Utilisateur créé avec le rôle de subadmin');
    }

    // delete user
    public function destroyuser($id): RedirectResponse
    {
        $user = User::find($id);


        if ($user->delete()) {
            // Créer le log
            Log::create([
                'action' => 'delete',
                'table_name' => 'users',
                'record_id' => $user->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return Redirect::route('profile.userlist')->with('status', 'Utilisateur supprimé');
    }

    // update user status
    public function status($id): RedirectResponse
    {
        $user = User::find($id);

        // Vérifier si l'utilisateur tente de modifier son propre profil
        if ($user->id == Auth::user()->id) {
            return redirect()->route('profile.userlist')->with('error', 'Vous ne pouvez pas modifier votre propre statut.');
        }

        // Si le statut de l'utilisateur est actif (1), on le change à inactif (0), sinon on le rend actif (1)
        if ($user->status == '1') {
            $user->status = '0';
        } else {
            $user->status = '1';
        }

        // Sauvegarder les changements dans la base de données
        if ($user->save()) {
            // Créer le log
            Log::create([
                'action' => 'update',
                'table_name' => 'users',
                'record_id' => $user->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        // Rediriger vers la liste des utilisateurs avec un message de confirmation
        return redirect()->route('profile.userlist')->with('status', 'Statut utilisateur mis à jour');
    }
}
