<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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
use App\Http\Controllers\DocumentVersionController;
use App\Http\Controllers\EvaluationQuestionnaireController;
use App\Http\Controllers\EvaluationQuestionController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\WorkflowStepController;
use App\Http\Controllers\ApprovalController;

Route::get('/', function () {
    return view('welcome');
});

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
Route::resource('document_versions', DocumentVersionController::class);
Route::resource('evaluation_questionnaires', EvaluationQuestionnaireController::class);
Route::resource('evaluation_questions', EvaluationQuestionController::class);
Route::resource('workflows', WorkflowController::class);
Route::resource('workflow_steps', WorkflowStepController::class);
Route::resource('approvals', ApprovalController::class);


// Route::get('/test-minio', function () {
//     try {
//         Storage::disk('minio')->put('test.txt', 'Halo MinIO! File dibuat pada: ' . now());  
//         return "Berhasil upload ke MinIO!";
//     } catch (\Exception $e) {
//         return "Gagal terhubung ke MinIO. Pesan Error: " . $e->getMessage();
//     }
// });