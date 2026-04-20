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
                'name' => 'HR Director - Davao Digital Solutions',
                'address' => 'Admin Office, Davao City',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Employer user
        $employer = User::firstOrCreate(
            ['email' => 'employer@job.com'],
            [
                'name' => 'Davao Digital Solutions Inc.',
                'address' => 'Startup Hub, Davao City',
                'role' => 'employer',
                'password' => Hash::make('password'),
            ]
        );

        // Applicant user
        User::firstOrCreate(
            ['email' => 'applicant@job.com'],
            [
                'name' => 'Applicant User',
                'address' => 'Matina, Davao City',
                'role' => 'applicant',
                'password' => Hash::make('password'),
            ]
        );

        // Seed the specific Job Post
        \App\Models\JobPost::firstOrCreate(
            ['title' => 'Junior Web Developer', 'user_id' => $employer->id],
            [
                'company' => 'Davao Digital Solutions Inc.',
                'location' => 'Davao City',
                'description' => "Company Overview\nDavao Digital Solutions Inc. is a startup technology company located in Davao City that provides digital services to local businesses. The company focuses on helping small and medium enterprises (SMEs) transition into the digital world by offering web development, job posting systems, and business management tools.\n\nVision\nTo become one of the leading IT solution providers in Mindanao by empowering local businesses through innovative digital platforms.\n\nMission\n- To deliver high-quality and affordable IT solutions\n- To support local businesses in digital transformation\n- To provide excellent customer service and technical support\n\nJob Description\nThe Junior Web Developer is responsible for assisting in the development of web-based systems such as job portals, company websites, and management systems. The role involves coding, debugging, testing, and maintaining web applications.\n\nKey Responsibilities\n- Develop web applications using HTML, CSS, JavaScript, and Laravel\n- Assist in building a Job Posting System\n- Fix bugs and troubleshoot system issues\n- Work with the UI/UX team for design implementation\n- Maintain and update existing systems\n\nQualifications\n- Bachelor’s degree in IT, Computer Science, or related field\n- Basic knowledge of web development (HTML, CSS, JavaScript)\n- Familiarity with Laravel is an advantage\n- Good problem-solving skills\n- Willing to learn and work in a team",
                'salary' => 'PHP 15,000 - 25,000',
                'type' => 'Full-time',
                'industry' => 'Technology'
            ]
        );
    }
}
