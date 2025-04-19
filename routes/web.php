<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EnquiryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    $mentors = User::where('role', 'mentor')
        ->select('id', 'name', 'email')
        ->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'mentors' => $mentors,
    ]);
});

// Public Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Appointment Routes
    Route::resource('appointments', AppointmentController::class);

    // Enquiry routes
    Route::prefix('enquiries')->name('enquiries.')->group(function () {
        Route::get('/', [EnquiryController::class, 'index'])->name('index');
        Route::get('/{enquiry}', [EnquiryController::class, 'show'])->name('show');
        Route::post('/{enquiry}/assign', [EnquiryController::class, 'assign'])->name('assign');
        Route::post('/{enquiry}/convert', [EnquiryController::class, 'convert'])->name('convert');
        Route::post('/{enquiry}/reject', [EnquiryController::class, 'reject'])->name('reject');
    });

    // Admin Routes - temporarily removed admin middleware
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/smtp', [App\Http\Controllers\Admin\SettingsController::class, 'updateSmtp'])->name('settings.smtp.update');
        Route::post('/settings/smtp/test', [App\Http\Controllers\Admin\SettingsController::class, 'testSmtp'])->name('settings.smtp.test');
        Route::post('/settings/recaptcha', [App\Http\Controllers\Admin\SettingsController::class, 'updateRecaptcha'])->name('settings.recaptcha.update');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware(['recaptcha']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(['recaptcha']);

    // ... other auth routes ...
});

require __DIR__.'/auth.php';
