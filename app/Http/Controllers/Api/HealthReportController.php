<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HealthReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $reports = HealthReport::with('student')
            ->when($request->query('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($request->query('urgency'), fn ($query, $urgency) => $query->where('urgency', $urgency))
            ->when($request->query('from'), fn ($query, $from) => $query->whereDate('reported_at', '>=', $from))
            ->when($request->query('to'), fn ($query, $to) => $query->whereDate('reported_at', '<=', $to))
            ->latest('reported_at')
            ->paginate($request->integer('per_page', 15));

        return response()->json($reports);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $data['reported_at'] ??= now();

        return response()->json(HealthReport::create($data)->load('student'), 201);
    }

    public function show(HealthReport $healthReport): JsonResponse
    {
        return response()->json($healthReport->load(['student', 'prescriptions.items.medicine', 'prescriptions.items.schedules']));
    }

    public function update(Request $request, HealthReport $healthReport): JsonResponse
    {
        $data = $request->validate($this->rules(false));
        $healthReport->update($data);

        return response()->json($healthReport->refresh()->load('student'));
    }

    public function destroy(HealthReport $healthReport): JsonResponse
    {
        $healthReport->delete();

        return response()->json(status: 204);
    }

    private function rules(bool $creating = true): array
    {
        return [
            'student_id' => [$creating ? 'required' : 'sometimes', 'exists:students,id'],
            'reported_by' => [$creating ? 'required' : 'sometimes', 'string', 'max:255'],
            'reported_at' => ['nullable', 'date'],
            'main_symptom' => [$creating ? 'required' : 'sometimes', 'string', 'max:255'],
            'symptoms' => ['nullable', 'array'],
            'temperature' => ['nullable', 'numeric', 'between:30,45'],
            'urgency' => ['sometimes', Rule::in(HealthReport::URGENCY_LEVELS)],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', Rule::in(HealthReport::STATUSES)],
            'diagnosis' => ['nullable', 'string', 'max:255'],
            'treatment_notes' => ['nullable', 'string'],
            'follow_up_notes' => ['nullable', 'string'],
            'closed_at' => ['nullable', 'date'],
        ];
    }
}
