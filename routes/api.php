<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DailyObservationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HealthReportController;
use App\Http\Controllers\Api\MedicationAdministrationController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportExportController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserApprovalController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('auth/logout', [AuthController::class, 'logout']);

        Route::middleware('role:admin')->group(function (): void {
            Route::get('user-approvals', [UserApprovalController::class, 'index']);
            Route::patch('user-approvals/{user}/approve', [UserApprovalController::class, 'approve']);
            Route::patch('user-approvals/{user}/reject', [UserApprovalController::class, 'reject']);
        });

        Route::apiResource('students', StudentController::class);
        Route::apiResource('health-reports', HealthReportController::class);
        Route::apiResource('medicines', MedicineController::class);
        Route::post('medicines/{medicine}/stock-movements', [MedicineController::class, 'moveStock']);

        Route::post('health-reports/{healthReport}/prescriptions', [PrescriptionController::class, 'store']);
        Route::post('health-reports/{healthReport}/observations', [DailyObservationController::class, 'store']);
        Route::post('health-reports/{healthReport}/referrals', [ReferralController::class, 'store']);
        Route::patch('referrals/{referral}', [ReferralController::class, 'update']);
        Route::patch('medication-administrations/{medicationAdministration}/status', [MedicationAdministrationController::class, 'updateStatus']);

        Route::get('dashboard', DashboardController::class);
        Route::get('reports/summary', [ReportController::class, 'summary']);
        Route::get('reports/sick-students.csv', [ReportExportController::class, 'sickStudentsCsv']);
    });
});
