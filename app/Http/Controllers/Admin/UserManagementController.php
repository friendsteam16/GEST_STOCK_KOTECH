<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller; 
    use App\Models\User;
    use App\Models\Role;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class UserManagementController extends Controller
    {
        public function index()
        {
            $utilisateurs = User::with('role')->get();
            return view('admin.users.index', compact('utilisateurs'));
        }

        public function create()
        {
            $roles = Role::all();
            return view('admin.utilisateurs.create', compact('roles'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'role_id'  => 'required|exists:roles,id',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $request->role_id,
            ]);

            return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
        }

        public function update(Request $request, User $user)
        {
            $request->validate([
                'roles'   => ['array'],
                'roles.*' => ['exists:roles,id'],
            ]);
    
            $user->roles()->sync($request->roles);
            return redirect()->route('admin.roles.index')
                             ->with('success', "Rôles mis à jour pour {$user->name}");
        }

        // Méthodes update, edit, destroy si nécessaire
    }
