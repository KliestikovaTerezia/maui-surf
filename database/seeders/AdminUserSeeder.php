<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder{
    public function run(): void
    {
        $password = env('ADMIN_PASSWORD');
        if (empty($password)) {
            throw new \RuntimeException('Set ADMIN_PASSWORD in .env (or as an environment variable) before seeding.');
        }

        User::updateOrCreate(
            ['email' => 'admin@mauisurf.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );
    }
}
