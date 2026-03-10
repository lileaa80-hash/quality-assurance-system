<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Unit/Jurusan
Route::resource('units', UnitController::class);
Route::resource('users', UserController::class);