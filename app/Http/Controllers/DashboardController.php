<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('assignments')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to the Dashboard',
            'subjects' => $subjects
        ]);
    }
}
