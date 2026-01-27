<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/Dashboard', [Controllers\DashboardController::class, 'index'])->name('index');

Route::get('/subject/', [Controllers\AssignmentController::class, 'index'])->name('index');
Route::post('/subject/assignment', [Controllers\AssignmentController::class, 'store'])->name('store');