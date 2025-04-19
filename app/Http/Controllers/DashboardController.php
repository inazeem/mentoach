<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Appointments Query
        $query = $user->role === 'mentor' 
            ? Appointment::where('mentor_id', $user->id)
            : Appointment::where('user_id', $user->id);

        // Get appointments for calendar
        $appointments = $query->clone()
            ->with(['user', 'mentor'])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->title,
                    'start' => $appointment->appointment_date,
                    'end' => Carbon::parse($appointment->appointment_date)->addMinutes($appointment->duration),
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'status' => $appointment->status,
                        'mentor' => $appointment->mentor->name,
                        'user' => $appointment->user->name,
                        'duration' => $appointment->duration
                    ]
                ];
            });

        $upcomingAppointments = $query->clone()
            ->with(['user', 'mentor'])
            ->where('appointment_date', '>=', Carbon::now())
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();

        $pastAppointments = $query->clone()
            ->with(['user', 'mentor'])
            ->where('appointment_date', '<', Carbon::now())
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        // Enquiries data (only for admin and mentors)
        $enquiriesData = [];
        if ($user->isAdmin() || $user->isMentor()) {
            $enquiriesQuery = Enquiry::query();
            
            if ($user->isMentor()) {
                $enquiriesQuery->where('assigned_mentor_id', $user->id);
            }

            $enquiriesData = [
                'recent' => $enquiriesQuery->clone()
                    ->with(['user', 'assigned_mentor'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'stats' => [
                    'total' => $enquiriesQuery->clone()->count(),
                    'pending' => $enquiriesQuery->clone()->where('status', 'pending')->count(),
                    'assigned' => $enquiriesQuery->clone()->where('status', 'assigned')->count(),
                    'converted' => $enquiriesQuery->clone()->where('status', 'converted')->count(),
                    'rejected' => $enquiriesQuery->clone()->where('status', 'rejected')->count(),
                ]
            ];
        }

        $stats = [
            'total' => $query->count(),
            'upcoming' => $query->clone()->where('appointment_date', '>=', Carbon::now())->count(),
            'completed' => $query->clone()->where('status', 'completed')->count(),
            'cancelled' => $query->clone()->where('status', 'cancelled')->count(),
        ];

        return Inertia::render('Dashboard', [
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,
            'calendarEvents' => $appointments,
            'stats' => $stats,
            'enquiriesData' => $enquiriesData,
            'role' => $user->role,
        ]);
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'pending' => '#FCD34D',    // Yellow
            'confirmed' => '#34D399',   // Green
            'cancelled' => '#EF4444',   // Red
            'completed' => '#60A5FA',   // Blue
            default => '#9CA3AF',       // Gray
        };
    }
} 