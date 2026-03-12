<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\StandardIndicatorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuditScheduleController; 
use App\Http\Controllers\AuditTeamController;// Import ini wajib!

Route::get('/', function () {
    return view('welcome');
});

// Route Modul Lain
Route::resource('units', UnitController::class);
Route::resource('users', UserController::class);
Route::resource('standards', StandardController::class);
Route::resource('standardindicators', StandardIndicatorController::class)->names('indicators');
Route::resource('documents', DocumentController::class);
Route::resource('audit_schedules', AuditScheduleController::class);
Route::resource('audit_teams', AuditTeamController::class);