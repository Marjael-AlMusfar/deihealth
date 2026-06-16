<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = ['actor_id', 'action', 'auditable_type', 'auditable_id', 'before', 'after', 'ip_address', 'user_agent'];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];
}
