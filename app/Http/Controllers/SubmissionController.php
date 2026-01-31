<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\School;
use App\Models\Subject;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index(School $school, Subject $subject, Assignment $assignment) 
    {
        $submissions = $assignment->submissions()
            // ->where('user_id', Auth::id())
            ->with(['user', 'feedback'])
            ->latest('submitted_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $submissions
        ]);
    }

    public function mySubmissions(School $school, Subject $subject, Assignment $assignment)
    {
        $submissions = $assignment->submissions()
            ->where('user_id', Auth::id())
            ->latest('submitted_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $submissions
        ]);
    }

    public function store(Request $request, School $school, Subject $subject, Assignment $assignment) {
        abort_if($assignment->subject_id !== $subject->id, 404);

        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'file',
        ]);

        $files = [];

        foreach ($request->file('files') as $file) {
            $path = $file->storeAs('submissions', $file->getFilename() . '.' . $file->getClientOriginalExtension(), 'public');

            $files[] = [
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ];
        }

        $submission = Submission::create([
            'assignment_id' => $assignment->id,
            'user_id' => Auth::id(),
            'files' => $files,
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Submission berhasil dikirim',
            'data' => $submission
        ], 201);
    }

    public function grade( Request $request, School $school, Subject $subject, Assignment $assignment, Submission $submission) {
        abort_if($submission->assignment_id !== $assignment->id, 404);

        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:255'
        ]);

        $submission->update([
            'grade' => $validated['grade'],
            'status' => 'graded',
        ]);

        if (!empty($validated['feedback'])) {
            SubmissionFeedback::updateOrCreate(
                ['submission_id' => $submission->id],
                ['feedback' => $validated['feedback']]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Submission berhasil dinilai',
            'data' => $submission
        ]);
    }

    public function destroy(Request $request, School $school, Subject $subject, Assignment $assignment, Submission $submission)
    {
        $submission->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Submission berhasil dihapus'
        ]);
    }
}
