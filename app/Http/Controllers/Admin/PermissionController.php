<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.permissions.edit', compact('role', 'permissions'));
    }
    
    public function update(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions ?? []);
        return redirect()->route('admin.roles.index')->with('success', 'Permissions mises à jour.');
    }
    
}
