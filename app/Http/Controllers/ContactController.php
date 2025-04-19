<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('recaptcha')->only('store');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-token' => 'required|string',
        ]);

        // Remove reCAPTCHA token from email data
        $emailData = array_diff_key($validated, ['g-recaptcha-token' => '']);

        // Send email notification
        Mail::to(config('mail.from.address'))->send(new ContactFormSubmission($emailData));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
} 