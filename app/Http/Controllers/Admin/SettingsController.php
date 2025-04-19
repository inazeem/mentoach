<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $smtp = Setting::getGroup('smtp');
        $recaptcha = Setting::getGroup('recaptcha');

        return Inertia::render('Admin/Settings/Index', [
            'smtp' => [
                'host' => $smtp['host'] ?? '',
                'port' => $smtp['port'] ?? '',
                'username' => $smtp['username'] ?? '',
                'encryption' => $smtp['encryption'] ?? 'tls',
                'from_address' => $smtp['from_address'] ?? '',
                'from_name' => $smtp['from_name'] ?? '',
            ],
            'recaptcha' => [
                'site_key' => $recaptcha['site_key'] ?? '',
                'secret_key' => $recaptcha['secret_key'] ?? '',
                'is_enabled' => $recaptcha['is_enabled'] ?? false,
            ],
        ]);
    }

    public function updateSmtp(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string',
            'port' => 'required|numeric',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'encryption' => 'required|in:tls,ssl',
            'from_address' => 'required|email',
            'from_name' => 'required|string',
        ]);

        // Update settings in database
        Setting::setGroup('smtp', array_filter($validated));

        // Update runtime configuration
        $this->updateConfig([
            'mail.mailers.smtp.host' => $validated['host'],
            'mail.mailers.smtp.port' => $validated['port'],
            'mail.mailers.smtp.username' => $validated['username'],
            'mail.mailers.smtp.encryption' => $validated['encryption'],
            'mail.from.address' => $validated['from_address'],
            'mail.from.name' => $validated['from_name'],
        ]);

        if (!empty($validated['password'])) {
            Setting::set('smtp', 'password', $validated['password']);
            $this->updateConfig([
                'mail.mailers.smtp.password' => $validated['password'],
            ]);
        }

        return back()->with('success', 'SMTP settings updated successfully.');
    }

    public function testSmtp()
    {
        try {
            $settings = Setting::getGroup('smtp');
            
            // Temporarily configure mail settings for the test
            Config::set([
                'mail.mailers.smtp.host' => $settings['host'],
                'mail.mailers.smtp.port' => $settings['port'],
                'mail.mailers.smtp.username' => $settings['username'],
                'mail.mailers.smtp.password' => $settings['password'],
                'mail.mailers.smtp.encryption' => $settings['encryption'],
                'mail.from.address' => $settings['from_address'],
                'mail.from.name' => $settings['from_name'],
            ]);

            Mail::raw('Test email from ' . config('app.name'), function($message) use ($settings) {
                $message->to($settings['from_address'])
                    ->subject('Test Email');
            });

            return back()->with('success', 'Test email sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    public function updateRecaptcha(Request $request)
    {
        $validated = $request->validate([
            'site_key' => 'required|string',
            'secret_key' => 'required|string',
            'is_enabled' => 'required|boolean',
        ]);

        // Update settings in database
        Setting::setGroup('recaptcha', $validated);

        // Update runtime configuration
        $this->updateConfig([
            'services.recaptcha.site_key' => $validated['site_key'],
            'services.recaptcha.secret_key' => $validated['secret_key'],
            'services.recaptcha.enabled' => $validated['is_enabled'],
        ]);

        return back()->with('success', 'reCAPTCHA settings updated successfully.');
    }

    private function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            Config::set($key, $value);
        }
    }
} 