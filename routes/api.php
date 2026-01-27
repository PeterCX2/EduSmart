<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', [Controllers\UserController::class, 'index']);
Route::post('/user/store', [Controllers\UserController::class, 'store']);
Route::put('/user/update/{id}', [Controllers\UserController::class, 'update']);
Route::get('/user/delete/{id}', [Controllers\UserController::class, 'delete']);

Route::get('/', [Controllers\SchoolController::class, 'index']);
Route::post('/school', [Controllers\SchoolController::class, 'store']);
Route::put('/school/{school}', [Controllers\SchoolController::class, 'update']);
Route::delete('/school/{school}', [Controllers\SchoolController::class, 'destroy']);

Route::get('/subject/', [Controllers\AssignmentController::class, 'index']);
Route::post('/subject/assignment', [Controllers\AssignmentController::class, 'store']);
