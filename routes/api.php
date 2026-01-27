<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/subject/', [AssignmentController::class, 'index'])->name('index');
Route::post('/subject/assignment', [AssignmentController::class, 'store'])->name('store');
