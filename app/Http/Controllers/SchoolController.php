<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $school = School::all();

        return response()->json([
            "status" => "success",
            "message" => "Data School berhasil diambil",
            "data" => $school
        ]);
    }

    public function show(School $school)
    {
        return response()->json([
            "status" => "success",
            "message" => "Detail sekolah berhasil diambil",
            "data" => $school
        ]);
    }

    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school = School::create($validatedRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Sekolah berhasil dibuat',
            'data'=> $school
        ]);
    }

    public function update(Request $request, School $school)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school->update($validatedRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Sekolah berhasil diubah',
            'data'=> $school
        ]);
    }

    public function destroy(School $school)
    {
        $school->delete();

        return response()->json([
            'status' => 'success',
            'message'=> 'Sekolah berhasil dihapus',
            'data' => $school
        ]);
    }
}
