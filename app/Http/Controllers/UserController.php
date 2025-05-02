<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Role;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class UserController extends Controller
    {
        public function index()
        {
            $users = User::with('role')->get();
            return view('admin.users.index', compact('users', 'roles'));
        }

        public function updateRole(Request $request, User $user)
        {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
            ]);
    
            $user->roles()->sync($request->input("roles.$user->id", []));
            $user->save();
    
            return redirect()->route('admin.users.index')->with('success', 'Rôle mis à jour avec succès');
        }

        public function create()
        {
            $roles = Role::all();
            return view('users.create', compact('roles'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
        }

        public function edit(User $user)
        {
            $roles = Role::all();
            return view('users.edit', compact('user', 'roles'));
        }

        public function update(Request $request, User $user)
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role_id' => 'required|exists:roles,id',
            ]);

            $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

}
