<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_report_id', 'referred_by', 'facility_name', 'reason', 'referred_at',
        'result_notes', 'follow_up_at', 'status',
    ];

    protected $casts = [
        'referred_at' => 'datetime',
        'follow_up_at' => 'datetime',
    ];

    public function healthReport(): BelongsTo
    {
        return $this->belongsTo(HealthReport::class);
    }
}
