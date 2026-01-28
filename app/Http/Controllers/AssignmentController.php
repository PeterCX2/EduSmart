<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function index(School $school, Subject $subject)
    {
        $assignments = $subject->assignments()->paginate(10);
        return response()->json([
            'data' => $assignments
        ]);
    }

    public function store(School $school, Subject $subject, Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date'
        ]);

        $validatedRequest['subject_id'] = $subject->id;
        $validatedRequest['created_by'] = Auth::user()->name;
        
        $assignment = Assignment::create($validatedRequest);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dibuat',
            'data'=> $assignment
        ]);
    }

    public function update(Request $request, School $school, Subject $subject, Assignment $assignment)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date'
        ]);

        $assignment->update($validatedRequest);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil diupdate',
            'data'=> $assignment
        ]);
    }

    public function destroy(School $school, Subject $subject, Assignment $assignment)
    {
        $assignment->delete();

        return response()->json([
            'status' => 'success',
            'message'=> 'Tugas berhasil dihapus',
            'data' => $assignment
        ]);
    }
}
