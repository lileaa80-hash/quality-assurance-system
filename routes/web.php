<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage; // Penting untuk testing MinIO
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\StandardIndicatorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuditScheduleController; 
use App\Http\Controllers\AuditTeamController;
use App\Http\Controllers\AuditChecklistController;
use App\Http\Controllers\AuditFindingController;
use App\Http\Controllers\CorrectiveActionController;
use App\Http\Controllers\AccreditationPeriodController;
use App\Http\Controllers\AccreditationBorangController;

Route::get('/', function () {
    return view('welcome');
});

// Route Modul Utama SPMI
Route::resource('units', UnitController::class);
Route::resource('users', UserController::class);
Route::resource('standards', StandardController::class);
Route::resource('standardindicators', StandardIndicatorController::class)->names('indicators');
Route::resource('documents', DocumentController::class);
Route::resource('audit_schedules', AuditScheduleController::class);
Route::resource('audit_teams', AuditTeamController::class);
Route::resource('audit_checklists', AuditChecklistController::class);
Route::resource('audit_findings', AuditFindingController::class);
Route::resource('corrective_actions', CorrectiveActionController::class);
Route::resource('accreditation_periods', AccreditationPeriodController::class);
Route::resource('accreditation_borangs', AccreditationBorangController::class);

// Route Testing Koneksi MinIO
Route::get('/test-minio', function () {
    try {
        Storage::disk('minio')->put('test.txt', 'Halo MinIO, ini dari Laravel! File ini dibuat pada: ' . now());  
        return "Berhasil upload ke MinIO! Silakan cek dashboard MinIO kamu.";
    } catch (\Exception $e) {
        return "Gagal terhubung ke MinIO. Pesan Error: " . $e->getMessage();
    }
});