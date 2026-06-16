<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis', 'name', 'gender', 'birth_date', 'class_name', 'dormitory',
        'guardian_name', 'guardian_phone', 'allergies', 'medical_notes', 'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function healthReports(): HasMany
    {
        return $this->hasMany(HealthReport::class);
    }
}
