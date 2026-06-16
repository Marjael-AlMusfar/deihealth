<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use App\Models\Referral;
use App\Services\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferralController extends Controller
{
    public function store(Request $request, HealthReport $healthReport, AuditLogger $auditLogger): JsonResponse
    {
        $data = $request->validate([
            'referred_by' => ['required', 'string', 'max:255'],
            'facility_name' => ['required', 'string', 'max:255'],
            'reason' => ['required', 'string'],
            'referred_at' => ['nullable', 'date'],
            'result_notes' => ['nullable', 'string'],
            'follow_up_at' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['dibuat', 'dalam_tindak_lanjut', 'selesai'])],
        ]);

        $data['referred_at'] ??= now();
        $referral = $healthReport->referrals()->create($data);
        $healthReport->update(['status' => 'dirujuk']);
        $auditLogger->record('referral.created', $referral, $request);

        return response()->json($referral, 201);
    }

    public function update(Request $request, Referral $referral, AuditLogger $auditLogger): JsonResponse
    {
        $before = $referral->toArray();
        $data = $request->validate([
            'result_notes' => ['nullable', 'string'],
            'follow_up_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['dibuat', 'dalam_tindak_lanjut', 'selesai'])],
        ]);

        $referral->update($data);
        $auditLogger->record('referral.updated', $referral, $request, $before);

        return response()->json($referral->refresh());
    }
}
