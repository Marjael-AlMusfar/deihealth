<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLogger
{
    public function record(string $action, Model $model, ?Request $request = null, ?array $before = null): AuditLog
    {
        return AuditLog::create([
            'actor_id' => $request?->user()?->id,
            'action' => $action,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'before' => $before,
            'after' => $model->fresh()?->toArray(),
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
