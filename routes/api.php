<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Controllers\AuthController::class, 'login']);
Route::post('/logout', [Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [Controllers\UserController::class, 'index']);
    Route::post('/user/store', [Controllers\UserController::class, 'store']);
    Route::put('/user/update/{id}', [Controllers\UserController::class, 'update']);
    Route::delete('/user/delete/{id}', [Controllers\UserController::class, 'delete']);

    Route::get('/school', [Controllers\SchoolController::class, 'index']);
    Route::post('/school/store', [Controllers\SchoolController::class, 'store']);
    Route::put('/school/update/{school}', [Controllers\SchoolController::class, 'update']);
    Route::delete('/school/delete/{school}', [Controllers\SchoolController::class, 'destroy']);

    Route::get('/school/{school}/subject', [Controllers\SubjectController::class, 'index']);
    Route::post('/school/{school}/subject/store', [Controllers\SubjectController::class, 'store']);
    Route::put('/school/{school}/subject/update/{subject}', [Controllers\SubjectController::class, 'update']);
    Route::delete('/school/{school}/subject/delete/{subject}', [Controllers\SubjectController::class, 'destroy']);

    Route::get('/school/{school}/subject/{subject}/assignment', [Controllers\AssignmentController::class, 'index']);
    Route::post('/school/{school}/subject/{subject}/assignment/store', action: [Controllers\AssignmentController::class, 'store']);
    Route::put('/school/{school}/subject/{subject}/assignment/update/{assignment}', [Controllers\AssignmentController::class, 'update']);
    Route::delete('/school/{school}/subject/{subject}/assignment/delete/{assignment}', [Controllers\AssignmentController::class, 'destroy']);
    
    Route::get('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions', [Controllers\SubmissionController::class, 'index']);
    Route::post('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/store', [Controllers\SubmissionController::class, 'store']);
    Route::put('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/grade',[Controllers\SubmissionController::class, 'grade']);
    Route::delete('/schools/{school}/subjects/{subject}/assignments/{assignment}/submissions/{submission}/delete',[Controllers\SubmissionController::class, 'destroy']);
});