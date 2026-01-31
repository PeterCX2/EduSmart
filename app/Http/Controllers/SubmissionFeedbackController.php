<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Subject;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\SubmissionFeedback;


class SubmissionFeedbackController extends Controller
{
    public function index(School $school, Subject $subject, Assignment $assignment, Submission $submission){
        $feedbacks = $submission->feedback()->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $feedbacks
        ]);
    }

    
    public function store(Request $request, School $school, Subject $subject, Assignment $assignment, Submission $submission){
        $validated = $request->validate([
            'feedback' => 'required|string|max:255'
        ]);

        $feedback = SubmissionFeedback::create([
            'submission_id' => $submission->id,
            'feedback' => $validated['feedback']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback berhasil ditambahkan',
            'data' => $feedback
        ], 201);
    }

    public function destroy(School $school, Subject $subject, Assignment $assignment, Submission $submission, SubmissionFeedback $submissionFeedback){
        $submissionFeedback->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback berhasil dihapus'
        ]);
    }
}
