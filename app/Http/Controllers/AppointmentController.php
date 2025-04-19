<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $appointments = auth()->user()->appointments()
            ->with(['mentor'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments
        ]);
    }

    public function create()
    {
        $mentors = User::where('role', 'mentor')->get();
        
        return Inertia::render('Appointments/Create', [
            'mentors' => $mentors
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appointment_date' => 'required|date|after:now',
            'duration' => 'required|integer|min:30|max:180',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255'
        ]);

        try {
            $appointment = auth()->user()->appointments()->create([
                'mentor_id' => $validated['mentor_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'appointment_date' => $validated['appointment_date'],
                'duration' => $validated['duration'],
                'status' => 'pending'
            ]);

            // You might want to send notifications here
            // For example, notify the mentor about the new appointment

            return redirect()->route('appointments.index')
                ->with('success', 'Appointment scheduled successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create appointment. Please try again.']);
        }
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment->load('mentor', 'user')
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed',
            'meeting_link' => 'nullable|url',
        ]);

        $appointment->update($validated);

        return redirect()->back()
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
