<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [Controllers\DashboardController::class, 'index']);
Route::get('/user', [Controllers\UserController::class, 'index']);
Route::post('/user/store', [Controllers\UserController::class, 'store']);
Route::put('/user/update/{id}', [Controllers\UserController::class, 'update']);
Route::get('/user/delete/{id}', [Controllers\UserController::class, 'delete']);
