<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminProfile;
use App\Models\EmployerProfile;
use App\Models\ApplicantProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\JobListingSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        AdminProfile::create([
            'user_id' => $admin->id,
        ]);

        // Create test employer user
        $employer = User::create([
            'name' => 'Test Employer',
            'email' => 'employer@example.com',
            'role' => 'employer',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        EmployerProfile::create([
            'user_id' => $employer->id,
            'bio' => 'We build fantasy RPG games and tools for indie studios.',
            'phone' => '0900 000 0001',
            'location' => 'Manila',
        ]);

        // Create test applicant user
        $applicant = User::create([
            'name' => 'Test Applicant',
            'email' => 'applicant@example.com',
            'role' => 'applicant',
            'account_status' => 'approved',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        ApplicantProfile::create([
            'user_id' => $applicant->id,
            'bio' => 'Aspiring game developer looking for entry-level opportunities.',
            'phone' => '0900 000 0002',
            'location' => 'Quezon City',
            'education' => 'BS Information Technology',
            'experience' => '1 year',
            'skills' => 'HTML, CSS, JavaScript, PHP, Laravel, MySQL',
        ]);

        $this->call([
            JobListingSeeder::class
        ]);
    }
}
