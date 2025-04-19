<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class ContactController extends BaseController
{
    public function __construct()
    {
        // No middleware needed for contact form as it's public
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-token' => 'required|string'
        ]);

        // Verify reCAPTCHA
        $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret_key'));
        $resp = $recaptcha->setExpectedAction('contact')
            ->setScoreThreshold(0.5)
            ->verify($validated['g-recaptcha-token'], $request->ip());

        if (!$resp->isSuccess()) {
            return redirect()->back()->withErrors(['g-recaptcha-token' => 'Failed to verify reCAPTCHA']);
        }

        // Remove reCAPTCHA token from contact data
        $contactData = array_diff_key($validated, ['g-recaptcha-token' => '']);

        // Send email
        Mail::to(config('mail.from.address'))->send(new ContactFormSubmission($contactData));

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Message sent successfully']);
        }

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }
} 