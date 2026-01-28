<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return response()->json([
            "status" => "success",
            "message" => "Data Role berhasil diambil",
            "data" => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role berhasil dibuat',
            'data' => $role->load('permissions')
        ]);
    }

    public function show(Role $role)
    {
        return response()->json([
            "status" => "success",
            "message" => "Detail Role berhasil diambil",
            "data" => $role->load('permissions')
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role berhasil diupdate',
            'data' => $role->load('permissions')
        ]);
    }

    public function destroy(Role $role)
    {
        if($role->name == 'super-admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat menghapus role default'
            ]);
        }

        // $originalName = $role->name;

        // $count = Role::withTrashed()
        //     ->where('name', 'like', $originalName . '-deleted-%')
        //     ->count();

        // $role->name = $originalName . '-deleted-' . ($count + 1);

        // $role->save();
        $role->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Role berhasil dihapus',
            'data' => $role
        ]);
    }
}