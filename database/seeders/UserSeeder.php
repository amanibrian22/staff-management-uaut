<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Risk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Clear existing users (optional, remove if you want to append)
        User::truncate();
        Risk::truncate();

        // Staff User
        $staff = User::create([
            'name' => 'Amani Brian',
            'email' => 'amanibrian@uaut.co.tz',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Admin User
        $admin = User::create([
            'name' => 'Msambili Ndaga',
            'email' => 'msabenda@uaut.co.tz',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Technical User
        $technical = User::create([
            'name' => 'John Tech',
            'email' => 'johntech@uaut.co.tz',
            'password' => Hash::make('password'),
            'role' => 'technical',
        ]);

        // Financial User
        $financial = User::create([
            'name' => 'Jane Finance',
            'email' => 'janefinance@uaut.co.tz',
            'password' => Hash::make('password'),
            'role' => 'financial',
        ]);

        // Optional: Seed sample risks for testing
        Risk::create([
            'reported_by' => $staff->id,
            'description' => 'Server is down',
            'type' => 'technical',
            'status' => 'pending',
            'assigned_to' => $technical->id,
        ]);

        Risk::create([
            'reported_by' => $staff->id,
            'description' => 'Payment system error',
            'type' => 'financial',
            'status' => 'pending',
            'assigned_to' => $financial->id,
        ]);
    }
}