<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicationSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['prescription_item_id', 'scheduled_at', 'status'];

    protected $casts = ['scheduled_at' => 'datetime'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(PrescriptionItem::class, 'prescription_item_id');
    }

    public function administrations(): HasMany
    {
        return $this->hasMany(MedicationAdministration::class);
    }
}
