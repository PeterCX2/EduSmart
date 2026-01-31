<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        $users = User::with('roles', 'permissions')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'users' => $users
        ]);
    }
    
    public function show($id){
        $user = User::with(['roles', 'schools'])->find($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'User retrieved successfully',
            'data' => $user   
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $roles = $request->roles;
        $user->assignRole($roles);

        $user->load('roles');

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'created_user' => $user
        ]);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
            'school_ids' => 'nullable|array', // ✅ ubah ke plural
            'school_ids.*' => 'exists:schools,id'
        ]);

        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => bcrypt($validated['password']),
            ]);
        }

        // Sync roles
        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        // ✅ Sync multiple schools
        if (isset($validated['school_ids'])) {
            $user->schools()->sync($validated['school_ids']);
        }

        $user->load('roles', 'schools');

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'updated_user' => $user
        ]);
    }

    public function delete($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
            'deleted_user' => $user
        ]);
    }
}
