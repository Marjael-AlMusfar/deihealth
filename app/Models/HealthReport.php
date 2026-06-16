<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthReport extends Model
{
    use HasFactory;

    public const STATUSES = ['dilaporkan', 'diperiksa', 'dalam_pemantauan', 'sembuh', 'dirujuk', 'ditutup'];
    public const URGENCY_LEVELS = ['rendah', 'sedang', 'tinggi'];

    protected $fillable = [
        'student_id', 'reported_by', 'reported_at', 'main_symptom', 'symptoms', 'temperature',
        'urgency', 'location', 'status', 'diagnosis', 'treatment_notes', 'follow_up_notes', 'closed_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'closed_at' => 'datetime',
        'symptoms' => 'array',
        'temperature' => 'decimal:1',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function observations(): HasMany
    {
        return $this->hasMany(DailyObservation::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }
}
