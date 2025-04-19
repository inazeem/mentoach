<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mentoach.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create mentors
        $mentors = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@mentoach.com',
                'specialization' => 'Career Development'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@mentoach.com',
                'specialization' => 'Academic Excellence'
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@mentoach.com',
                'specialization' => 'Professional Growth'
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emily.brown@mentoach.com',
                'specialization' => 'Leadership Development'
            ],
        ];

        foreach ($mentors as $mentor) {
            User::create([
                'name' => $mentor['name'],
                'email' => $mentor['email'],
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);
        }

        // Create regular users
        $users = [
            [
                'name' => 'Tom Wilson',
                'email' => 'tom.wilson@example.com',
            ],
            [
                'name' => 'Alice Cooper',
                'email' => 'alice.cooper@example.com',
            ],
            [
                'name' => 'David Lee',
                'email' => 'david.lee@example.com',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}
