<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicationAdministration extends Model
{
    use HasFactory;

    public const STATUSES = ['terjadwal', 'diberikan', 'terlewat', 'ditolak', 'dihentikan'];

    protected $fillable = ['medication_schedule_id', 'administered_by', 'administered_at', 'status', 'notes', 'side_effects'];

    protected $casts = ['administered_at' => 'datetime'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MedicationSchedule::class, 'medication_schedule_id');
    }
}
