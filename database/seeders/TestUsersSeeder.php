<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@job.com'],
            [
                'name' => 'Admin User',
                'address' => 'Admin Office, Davao City',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Employer user
        User::firstOrCreate(
            ['email' => 'employer@job.com'],
            [
                'name' => 'Employer User',
                'address' => 'Company HQ, Manila',
                'role' => 'employer',
                'password' => Hash::make('password'),
            ]
        );

        // Applicant user
        User::firstOrCreate(
            ['email' => 'applicant@job.com'],
            [
                'name' => 'Applicant User',
                'address' => 'Somewhere, Cebu',
                'role' => 'applicant',
                'password' => Hash::make('password'),
            ]
        );
    }
}
