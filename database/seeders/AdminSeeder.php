<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@job.com',
            'address'  => 'Admin Office, Davao City',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}