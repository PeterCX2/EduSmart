<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class AssignmentController extends Controller
{
    public function index(Subject $subject)
    {
        $assignments = $subject->assignments()->paginate(10);
        return response()->json([
            'data' => $assignments
        ]);
    }

    public function store(Subject $subject, Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date|date_format:d-m-Y'
        ]);

        // $validatedRequest['subject_id'] = $subject->id;
        $validatedRequest['subject_id'] = 1;
        // $validatedRequest['created_by'] = Auth::user()->name;
        $validatedRequest['created_by'] = 'User';
        
        $assignment = Assignment::create($validatedRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dibuat',
            'data'=> $assignment
        ]);
    }

    public function update(Request $request, Subject $subject, Assignment $assignment)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date|date_format:d-m-Y'
        ]);

        $assignment->update($validatedRequest);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil diupdate',
            'data'=> $assignment
        ]);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json([
            'status' => 'success',
            'message'=> 'Tugas berhasil dihapus',
            'data' => $subject
        ]);
    }
}
