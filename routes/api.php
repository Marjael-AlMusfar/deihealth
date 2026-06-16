<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HealthReportController;
use App\Http\Controllers\Api\MedicationAdministrationController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::apiResource('students', StudentController::class);
    Route::apiResource('health-reports', HealthReportController::class);
    Route::apiResource('medicines', MedicineController::class);
    Route::post('medicines/{medicine}/stock-movements', [MedicineController::class, 'moveStock']);
    Route::patch('medication-administrations/{medicationAdministration}/status', [MedicationAdministrationController::class, 'updateStatus']);
    Route::get('dashboard', DashboardController::class);
    Route::get('reports/summary', [ReportController::class, 'summary']);
});
