<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d’inscription.
     */
    public function create(): View
    {
        $isFirstUser = User::count() === 0;
        $roles = Role::all();


        return view('auth.register', [
            'isFirstUser' => $isFirstUser,
            'roles' => $roles,
        ]);
    }

    /**
     * Enregistre un nouvel utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        $isFirstUser = User::count() === 0;

        $rules = [
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:users'],
            'password' => ['required','confirmed', Rules\Password::defaults()],
        ];
    
        // Si c'est le premier user, on exige un role_id valide
        if ($isFirstUser) {
            $rules['role_id'] = ['required','exists:roles,id'];
        }
    
        $data = $request->validate($rules);
    
        // Récupération du rôle
        $roleId = $isFirstUser
            ? $data['role_id']
            : Role::where('name','utilisateur')->first()->id;
    
        // Création de l'utilisateur
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => $roleId,
        ]);
    
        event(new Registered($user));
        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME);
    }
}
