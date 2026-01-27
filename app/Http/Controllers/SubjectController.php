<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(School $school)
    {
        $subjects = $school->subjects;

        return response()->json([
            "status" => "success",
            "message" => "Data Subject berhasil diambil dari {$school->name}",
            "data" => $subjects
        ]);
    }

    public function store(School $school, Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validatedRequest['school_id'] = $school->id;

        $subject = Subject::create($validatedRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Subject berhasil dibuat',
            'data' => $subject
        ]);
    }

     public function update(School $school, Subject $subject, Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update($validatedRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Subject berhasil diubah',
            'data' => $subject
        ]);
    }

    public function destroy(School $school, Subject $subject)
    {
        $subject->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subject berhasil dihapus',
            'data' => $subject
        ]);
    }
}