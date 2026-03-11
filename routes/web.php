<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\StandardIndicatorController;
use App\Http\Controllers\DocumentController; // Import ini wajib!

Route::get('/', function () {
    return view('welcome');
});

// Route Modul Lain
Route::resource('units', UnitController::class);
Route::resource('users', UserController::class);
Route::resource('standards', StandardController::class);

// Route Indicators (panggilan pendek biar gak 404)
Route::resource('standardindicators', StandardIndicatorController::class)->names('indicators');

// Route Documents (pakai "s" biar sinkron)
Route::resource('documents', DocumentController::class);