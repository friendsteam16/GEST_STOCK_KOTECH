<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->paginate(15);
        $roles = Role::all();
        return view('admin.role.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPermission()
    {
        return view('admin.role.create-permission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);
    
        $name = Str::slug($request->name, '_'); // nettoie le nom : "Gérer les ventes" -> "gerer_les_ventes"
        Permission::create(['name' => $name]);
    
        return redirect()->route('admin.roles.index')->with('success', 'Permission ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles.' . $user->id => 'required|array',
            'roles.' . $user->id . '.*' => 'exists:roles,id',
        ]);
    
        $roleId = $request->input('roles.' . $user->id)[0]; // un seul rôle
        $user->role_id = $roleId;
        $user->save();
    
        return redirect()->route('admin.roles.index')->with('success', "Rôle mis à jour pour {$user->name}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function editPermissions(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.role.permissions', compact('role', 'permissions'));
    }
    
    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        // Récupère les ID des permissions cochées
        $permissionIds = $request->input('permissions', []);

        // Synchronise les permissions avec le rôle
        $role->permissions()->sync($permissionIds);
        
        return redirect()->route('admin.role.editPermissions', $role)
                         ->with('success', 'Permissions mises à jour avec succès.');
    }

}
