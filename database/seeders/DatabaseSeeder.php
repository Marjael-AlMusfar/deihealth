<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@deihealth.local')],
            [
                'name' => env('ADMIN_NAME', 'Admin DeiHealth'),
                'password' => env('ADMIN_PASSWORD', 'password123'),
                'role' => Role::ADMIN,
                'approval_status' => User::APPROVAL_APPROVED,
                'approved_at' => now(),
                'approval_notes' => 'Initial administrator seeded by system.',
                'is_active' => true,
            ]
        );
    }
}
