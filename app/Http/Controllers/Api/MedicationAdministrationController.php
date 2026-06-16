<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicationAdministration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicationAdministrationController extends Controller
{
    public function updateStatus(Request $request, MedicationAdministration $medicationAdministration): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(MedicationAdministration::STATUSES)],
            'administered_by' => ['required', 'string', 'max:255'],
            'administered_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'side_effects' => ['nullable', 'string'],
        ]);

        $data['administered_at'] ??= now();
        $medicationAdministration->update($data);
        $medicationAdministration->schedule()->update(['status' => $data['status']]);

        return response()->json($medicationAdministration->refresh()->load('schedule.item.medicine'));
    }
}
