<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use App\Services\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyObservationController extends Controller
{
    public function store(Request $request, HealthReport $healthReport, AuditLogger $auditLogger): JsonResponse
    {
        $data = $request->validate([
            'observed_by' => ['required', 'string', 'max:255'],
            'observed_at' => ['nullable', 'date'],
            'temperature' => ['nullable', 'numeric', 'between:30,45'],
            'symptom_notes' => ['nullable', 'string'],
            'appetite' => ['nullable', 'string', 'max:100'],
            'rest_quality' => ['nullable', 'string', 'max:100'],
            'activity_level' => ['nullable', 'string', 'max:100'],
            'medication_compliance' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['observed_at'] ??= now();
        $observation = $healthReport->observations()->create($data);
        $auditLogger->record('observation.created', $observation, $request);

        return response()->json($observation, 201);
    }
}
