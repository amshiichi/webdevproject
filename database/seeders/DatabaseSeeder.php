<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        // Create test employer user
        User::create([
            'name' => 'Test Employer',
            'email' => 'employer@example.com',
            'role' => 'employer',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        // Create test applicant user
        User::create([
            'name' => 'Test Applicant',
            'email' => 'applicant@example.com',
            'role' => 'applicant',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
    }
}
