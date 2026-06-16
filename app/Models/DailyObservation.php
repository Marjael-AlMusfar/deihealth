<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_report_id', 'observed_by', 'observed_at', 'temperature', 'symptom_notes',
        'appetite', 'rest_quality', 'activity_level', 'medication_compliance', 'notes',
    ];

    protected $casts = [
        'observed_at' => 'datetime',
        'temperature' => 'decimal:1',
        'medication_compliance' => 'boolean',
    ];

    public function healthReport(): BelongsTo
    {
        return $this->belongsTo(HealthReport::class);
    }
}
