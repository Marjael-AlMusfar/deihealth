<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use App\Models\MedicationAdministration;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $from = $request->date('from', now()->startOfMonth());
        $to = $request->date('to', now()->endOfMonth());

        $cases = HealthReport::whereBetween('reported_at', [$from, $to]);

        return response()->json([
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
            ],
            'cases_by_status' => (clone $cases)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'cases_by_urgency' => (clone $cases)->selectRaw('urgency, count(*) as total')->groupBy('urgency')->pluck('total', 'urgency'),
            'top_symptoms' => (clone $cases)->selectRaw('main_symptom, count(*) as total')->groupBy('main_symptom')->orderByDesc('total')->limit(10)->pluck('total', 'main_symptom'),
            'medicine_stock' => Medicine::orderBy('name')->get(['id', 'name', 'unit', 'minimum_stock', 'current_stock', 'expires_at']),
            'medication_adherence' => MedicationAdministration::whereBetween('created_at', [$from, $to])
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
        ]);
    }
}
