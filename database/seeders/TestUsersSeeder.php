<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // HR Director (Admin)
        $hr = User::firstOrCreate(
            ['email' => 'admin@job.com'],
            [
                'name' => 'System Administrator',
                'address' => 'Main Office',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Employer user (representing the company HR/Manager)
        $employer = User::firstOrCreate(
            ['email' => 'employer@job.com'],
            [
                'name' => 'Davao Central Services Company',
                'address' => 'Davao City',
                'role' => 'employer',
                'password' => Hash::make('password'),
            ]
        );

        // Applicant user
        User::firstOrCreate(
            ['email' => 'applicant@job.com'],
            [
                'name' => 'Applicant User',
                'address' => 'Applicant Address',
                'role' => 'applicant',
                'password' => Hash::make('password'),
            ]
        );

        // ── Seed multiple ROLES for the single company ──
        $companyName = 'Davao Central Services Company';

        \App\Models\JobPost::firstOrCreate(
            ['title' => 'Administrative Assistant', 'user_id' => $employer->id],
            [
                'company' => $companyName,
                'location' => 'Davao City',
                'description' => "Responsible for assisting office tasks, encoding documents, and handling records.",
                'requirements' => "- Bachelor’s degree holder\n- Computer literate\n- Good communication skills",
                'salary' => 'PHP 15,000 - 20,000',
                'type' => 'full-time',
            ]
        );

        \App\Models\JobPost::firstOrCreate(
            ['title' => 'IT Support Staff', 'user_id' => $employer->id],
            [
                'company' => $companyName,
                'location' => 'Davao City',
                'description' => "Responsible for troubleshooting computers, networks, and system support inside the company.",
                'requirements' => "- BSIT or related course\n- Knowledge in hardware/software troubleshooting\n- Willing to work on campus",
                'salary' => 'PHP 20,000 - 25,000',
                'type' => 'full-time',
            ]
        );

        \App\Models\JobPost::firstOrCreate(
            ['title' => 'Librarian Assistant', 'user_id' => $employer->id],
            [
                'company' => $companyName,
                'location' => 'Davao City',
                'description' => "Assists in organizing books, encoding library records, and helping students in library services.",
                'requirements' => "- Library Science or related course\n- Organized and detail-oriented",
                'salary' => 'PHP 12,000 - 18,000',
                'type' => 'part-time',
            ]
        );

        \App\Models\JobPost::firstOrCreate(
            ['title' => 'Janitor / Utility Staff', 'user_id' => $employer->id],
            [
                'company' => $companyName,
                'location' => 'Davao City',
                'description' => "Maintains cleanliness of classrooms, offices, and school facilities.",
                'requirements' => "- Physically fit\n- Responsible and hardworking",
                'salary' => 'PHP 10,000 - 15,000',
                'type' => 'full-time',
            ]
        );
    }
}
