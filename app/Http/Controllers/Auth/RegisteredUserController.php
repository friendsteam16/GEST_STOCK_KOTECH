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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $isFirstUser = User::count() === 0;

        // Récupération du rôle
        $roleId = $isFirstUser
            ? $request->input('role_id')
            : Role::where('name', 'utilisateur')->first()->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);

    }
}
