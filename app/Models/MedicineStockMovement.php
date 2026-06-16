<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineStockMovement extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_id', 'type', 'quantity', 'reason', 'reference_type', 'reference_id', 'moved_at'];

    protected $casts = [
        'quantity' => 'integer',
        'moved_at' => 'datetime',
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
