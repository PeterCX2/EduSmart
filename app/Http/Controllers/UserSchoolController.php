<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserSchoolController extends Controller
{
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'school_ids' => 'nullable|array',
            'school_ids.*' => 'exists:schools,id',
        ]);

        // Gunakan array langsung (boleh kosong untuk menghapus semua)
        $schoolIds = $validated['school_ids'] ?? [];

        $user->schools()->sync($schoolIds);

        return response()->json([
            'status'  => 'success',
            'message' => count($schoolIds) 
                ? 'Schools assigned successfully' 
                : 'All schools removed successfully',
            'user'    => $user->load(['roles', 'schools']),
        ]);
    }
}