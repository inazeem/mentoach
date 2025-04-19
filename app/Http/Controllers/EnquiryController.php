<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEnquiryNotification;
use App\Mail\EnquiryAssignedNotification;
use App\Mail\EnquiryRejectedNotification;
use App\Mail\EnquiryConvertedNotification;
use Illuminate\Routing\Controller as BaseController;

class EnquiryController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    public function __construct()
    {
        $this->middleware('auth')->except(['store']);
    }

    public function index(): Response
    {
        $this->authorize('viewAny', Enquiry::class);

        return Inertia::render('Admin/Enquiries/Index', [
            'enquiries' => Enquiry::with(['user', 'assigned_mentor'])
                ->latest()
                ->paginate(10),
            'mentors' => User::where('role', 'mentor')->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string',
            'service' => 'required|string|max:255',
            'preferred_date' => 'required|date',
            'g-recaptcha-token' => 'required|string',
        ]);

        // Remove reCAPTCHA token from enquiry data
        $enquiryData = array_diff_key($validated, ['g-recaptcha-token' => '']);

        $enquiry = Enquiry::create($enquiryData);

        // Send notification email
        Mail::to(config('mail.from.address'))->send(new NewEnquiryNotification($enquiry));

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Enquiry submitted successfully']);
        }

        return redirect()->back()->with('success', 'Your enquiry has been submitted successfully.');
    }

    public function show(Enquiry $enquiry): Response
    {
        $this->authorize('view', $enquiry);

        return Inertia::render('Admin/Enquiries/Show', [
            'enquiry' => $enquiry->load('assigned_mentor'),
            'mentors' => User::where('role', 'mentor')->get()
        ]);
    }

    public function assign(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $this->authorize('update', $enquiry);
        
        $validated = $request->validate([
            'mentor_id' => ['required', 'exists:users,id']
        ]);

        $enquiry->update([
            'assigned_mentor_id' => $validated['mentor_id'],
            'status' => 'assigned'
        ]);

        // Send notification email
        Mail::to(config('mail.from.address'))->send(new EnquiryAssignedNotification($enquiry));

        return redirect()->back()->with('success', 'Mentor assigned successfully');
    }

    public function convert(Enquiry $enquiry): RedirectResponse
    {
        $this->authorize('update', $enquiry);

        if (!$enquiry->assigned_mentor_id) {
            return redirect()->back()->with('error', 'Cannot convert enquiry without an assigned mentor.');
        }

        // Create appointment from enquiry
        $appointment = new \App\Models\Appointment([
            'user_id' => auth()->id(),
            'mentor_id' => $enquiry->assigned_mentor_id,
            'title' => $enquiry->subject,
            'description' => $enquiry->message,
            'appointment_date' => $enquiry->preferred_date ?? now()->addDays(7),
            'duration' => $enquiry->duration ?? 60,
            'status' => 'pending'
        ]);
        
        $appointment->save();

        // Update enquiry status
        $enquiry->update(['status' => 'converted']);

        // Send notification email
        Mail::to(config('mail.from.address'))->send(new EnquiryConvertedNotification($enquiry));

        return redirect()->route('appointments.index')->with('success', 'Enquiry converted to appointment successfully');
    }

    public function reject(Enquiry $enquiry): RedirectResponse
    {
        $this->authorize('update', $enquiry);

        $enquiry->update(['status' => 'rejected']);

        // Send notification email
        Mail::to(config('mail.from.address'))->send(new EnquiryRejectedNotification($enquiry));

        return redirect()->back()->with('success', 'Enquiry rejected');
    }
}
