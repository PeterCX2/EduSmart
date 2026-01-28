<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Controllers\AuthController::class, 'login']);
Route::post('/logout', [Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [Controllers\UserController::class, 'index'])->middleware('permission:view users');
    Route::get('/user/show/{id}', [Controllers\UserController::class, 'show'])->middleware('permission:view users');
    Route::post('/user/store', [Controllers\UserController::class, 'store'])->middleware('permission:create users');
    Route::put('/user/update/{id}', [Controllers\UserController::class, 'update'])->middleware('permission:edit users');
    Route::delete('/user/delete/{id}', [Controllers\UserController::class, 'delete'])->middleware('permission:delete users');

    Route::get('/school', [Controllers\SchoolController::class, 'index'])->middleware('permission:view schools');
    Route::get('/school/show/{school}', [Controllers\SchoolController::class, 'show'])->middleware('permission:view schools');
    Route::post('/school/store', [Controllers\SchoolController::class, 'store'])->middleware('permission:create schools');
    Route::put('/school/update/{school}', [Controllers\SchoolController::class, 'update'])->middleware('permission:edit schools');
    Route::delete('/school/delete/{school}', [Controllers\SchoolController::class, 'destroy'])->middleware('permission:delete schools');

    Route::get('/school/{school}/subject', [Controllers\SubjectController::class, 'index'])->middleware('permission:view subjects');
    Route::get('/school/{school}/subject/show/{subject}', [Controllers\SubjectController::class, 'show'])->middleware('permission:view subjects');
    Route::post('/school/{school}/subject/store', [Controllers\SubjectController::class, 'store'])->middleware('permission:create subjects');
    Route::put('/school/{school}/subject/update/{subject}', [Controllers\SubjectController::class, 'update'])->middleware('permission:edit subjects');
    Route::delete('/school/{school}/subject/delete/{subject}', [Controllers\SubjectController::class, 'destroy'])->middleware('permission:delete subjects');

    Route::get('/school/{school}/subject/{subject}/assignment', [Controllers\AssignmentController::class, 'index'])->middleware('permission:view assignments');
    Route::get('/school/{school}/subject/{subject}/assignment/show/{assignment}', [Controllers\AssignmentController::class, 'show'])->middleware('permission:view assignments');
    Route::post('/school/{school}/subject/{subject}/assignment/store', [Controllers\AssignmentController::class, 'store'])->middleware('permission:create assignments');
    Route::put('/school/{school}/subject/{subject}/assignment/update/{assignment}', [Controllers\AssignmentController::class, 'update'])->middleware('permission:edit assignments');
    Route::delete('/school/{school}/subject/{subject}/assignment/delete/{assignment}', [Controllers\AssignmentController::class, 'destroy'])->middleware('permission:delete assignments');
    
    Route::get('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions', [Controllers\SubmissionController::class, 'index'])->middleware('permission:view submissions');
    Route::post('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/store', [Controllers\SubmissionController::class, 'store'])->middleware('permission:create submissions');
    Route::put('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/grade',[Controllers\SubmissionController::class, 'grade'])->middleware('permission:grade submissions');
    Route::delete('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/delete',[Controllers\SubmissionController::class, 'destroy'])->middleware('permission:delete submissions');

    Route::get('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/feedbacks', [Controllers\SubmissionFeedbackController::class, 'index'])->middleware('permission:view submission_feedback');
    Route::post('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/feedbacks/store',[Controllers\SubmissionFeedbackController::class, 'store'])->middleware('permission:create submission_feedback');
    Route::delete('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/submission-feedbacks/{submissionFeedback}/delete',[Controllers\SubmissionFeedbackController::class, 'destroy'])->middleware('permission:delete submission_feedback');

    Route::get('/role', [Controllers\RoleController::class, 'index'])->middleware('permission:view roles');
    Route::get('/role/show/{role}', [Controllers\RoleController::class, 'show'])->middleware('permission:view roles');
    Route::post('/role/store', [Controllers\RoleController::class, 'store'])->middleware('permission:create roles');
    Route::put('/role/update/{role}', [Controllers\RoleController::class, 'update'])->middleware('permission:edit roles');
    Route::delete('/role/delete/{role}', [Controllers\RoleController::class, 'destroy'])->middleware('permission:delete roles');
});