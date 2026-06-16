<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use App\Models\Prescription;
use App\Services\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function store(Request $request, HealthReport $healthReport, AuditLogger $auditLogger): JsonResponse
    {
        $data = $request->validate([
            'prescribed_by' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => ['required', 'exists:medicines,id'],
            'items.*.dose' => ['required', 'string', 'max:100'],
            'items.*.frequency_per_day' => ['required', 'integer', 'min:1', 'max:6'],
            'items.*.duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'items.*.instructions' => ['nullable', 'string'],
        ]);

        $prescription = DB::transaction(function () use ($healthReport, $data): Prescription {
            $prescription = $healthReport->prescriptions()->create(collect($data)->except('items')->all());

            foreach ($data['items'] as $itemData) {
                $item = $prescription->items()->create($itemData);
                $this->createSchedules($item, Carbon::parse($data['started_at']), $itemData['duration_days'], $itemData['frequency_per_day']);
            }

            $healthReport->update(['status' => 'dalam_pemantauan']);

            return $prescription;
        });

        $auditLogger->record('prescription.created', $prescription, $request);

        return response()->json($prescription->load('items.medicine', 'items.schedules'), 201);
    }

    private function createSchedules($item, Carbon $start, int $days, int $frequency): void
    {
        $intervalHours = intdiv(24, $frequency);

        for ($day = 0; $day < $days; $day++) {
            for ($dose = 0; $dose < $frequency; $dose++) {
                $item->schedules()->create([
                    'scheduled_at' => $start->copy()->addDays($day)->addHours($dose * $intervalHours),
                    'status' => 'terjadwal',
                ]);
            }
        }
    }
}
