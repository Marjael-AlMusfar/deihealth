<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use App\Models\MedicationSchedule;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'active_cases' => HealthReport::whereNotIn('status', ['sembuh', 'dirujuk', 'ditutup'])->count(),
            'high_urgency_cases' => HealthReport::where('urgency', 'tinggi')->whereNotIn('status', ['sembuh', 'dirujuk', 'ditutup'])->count(),
            'sick_today' => HealthReport::whereDate('reported_at', today())->count(),
            'low_stock_medicines' => Medicine::whereColumn('current_stock', '<=', 'minimum_stock')->count(),
            'expired_or_expiring_medicines' => Medicine::whereDate('expires_at', '<=', today()->addDays(30))->count(),
            'medication_due_today' => MedicationSchedule::whereDate('scheduled_at', today())->where('status', 'terjadwal')->count(),
            'recent_reports' => HealthReport::with('student')->latest('reported_at')->limit(10)->get(),
        ]);
    }
}
