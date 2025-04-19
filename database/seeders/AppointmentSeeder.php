<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $mentors = User::where('role', 'mentor')->get();

        // Sample appointment titles and descriptions
        $appointmentTypes = [
            [
                'title' => 'Career Planning Session',
                'description' => 'Discuss career goals and create an action plan for professional development.'
            ],
            [
                'title' => 'Resume Review',
                'description' => 'Review and improve your resume to stand out in job applications.'
            ],
            [
                'title' => 'Interview Preparation',
                'description' => 'Practice common interview questions and improve your presentation skills.'
            ],
            [
                'title' => 'Academic Guidance',
                'description' => 'Get advice on course selection and academic performance improvement.'
            ],
            [
                'title' => 'Leadership Coaching',
                'description' => 'Develop leadership skills and learn effective team management strategies.'
            ]
        ];

        // Create past appointments
        foreach ($users as $user) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                $appointmentType = $appointmentTypes[array_rand($appointmentTypes)];
                $status = ['completed', 'cancelled'][array_rand(['completed', 'cancelled'])];
                
                Appointment::create([
                    'user_id' => $user->id,
                    'mentor_id' => $mentors->random()->id,
                    'title' => $appointmentType['title'],
                    'description' => $appointmentType['description'],
                    'appointment_date' => Carbon::now()->subDays(rand(1, 30)),
                    'duration' => [30, 60, 90][array_rand([30, 60, 90])],
                    'status' => $status,
                    'meeting_link' => $status === 'completed' ? 'https://meet.google.com/example' : null,
                ]);
            }
        }

        // Create upcoming appointments
        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $appointmentType = $appointmentTypes[array_rand($appointmentTypes)];
                $status = ['pending', 'confirmed'][array_rand(['pending', 'confirmed'])];
                
                Appointment::create([
                    'user_id' => $user->id,
                    'mentor_id' => $mentors->random()->id,
                    'title' => $appointmentType['title'],
                    'description' => $appointmentType['description'],
                    'appointment_date' => Carbon::now()->addDays(rand(1, 14)),
                    'duration' => [30, 60, 90][array_rand([30, 60, 90])],
                    'status' => $status,
                    'meeting_link' => $status === 'confirmed' ? 'https://meet.google.com/example' : null,
                ]);
            }
        }
    }
}
