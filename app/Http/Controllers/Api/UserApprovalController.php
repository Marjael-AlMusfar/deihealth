<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $users = User::query()
            ->when($request->query('status'), fn ($query, $status) => $query->where('approval_status', $status))
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json($users);
    }

    public function approve(Request $request, User $user, AuditLogger $auditLogger): JsonResponse
    {
        $data = $request->validate([
            'approval_notes' => ['nullable', 'string'],
        ]);

        $before = $user->toArray();
        $user->update([
            'approval_status' => User::APPROVAL_APPROVED,
            'approved_by' => $request->user()?->id,
            'approved_at' => now(),
            'approval_notes' => $data['approval_notes'] ?? null,
            'is_active' => true,
        ]);
        $auditLogger->record('user.approved', $user, $request, $before);

        return response()->json([
            'message' => 'User berhasil disetujui dan diaktifkan.',
            'user' => $user->refresh()->load('approver'),
        ]);
    }

    public function reject(Request $request, User $user, AuditLogger $auditLogger): JsonResponse
    {
        $data = $request->validate([
            'approval_notes' => ['required', 'string'],
        ]);

        $before = $user->toArray();
        $user->update([
            'approval_status' => User::APPROVAL_REJECTED,
            'approved_by' => $request->user()?->id,
            'approved_at' => null,
            'approval_notes' => $data['approval_notes'],
            'is_active' => false,
        ]);
        $user->tokens()->delete();
        $auditLogger->record('user.rejected', $user, $request, $before);

        return response()->json([
            'message' => 'User ditolak dan dinonaktifkan.',
            'user' => $user->refresh()->load('approver'),
        ]);
    }
}
