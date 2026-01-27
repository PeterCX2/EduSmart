<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [Controllers\SchoolController::class, 'index'])->name('index');
Route::post('/school', [Controllers\SchoolController::class, 'store'])->name('store');
Route::put('/school/{school}', [Controllers\SchoolController::class, 'update'])->name('update');
Route::delete('/school/{school}', [Controllers\SchoolController::class, 'destroy'])->name('destroy');

Route::get('/Dashboard', [Controllers\DashboardController::class, 'index'])->name('index');

Route::get('/subject/', [Controllers\AssignmentController::class, 'index'])->name('index');
Route::post('/subject/assignment', [Controllers\AssignmentController::class, 'store'])->name('store');