<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'unit', 'default_dose', 'indication', 'contraindication',
        'minimum_stock', 'current_stock', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'minimum_stock' => 'integer',
        'current_stock' => 'integer',
        'expires_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function stockMovements(): HasMany
    {
        return $this->hasMany(MedicineStockMovement::class);
    }
}
