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
        Route::post('/', [EnquiryController::class, 'store'])->name('store');
        Route::post('/{enquiry}/assign', [EnquiryController::class, 'assign'])->name('assign');
        Route::post('/{enquiry}/convert', [EnquiryController::class, 'convert'])->name('convert');
        Route::post('/{enquiry}/reject', [EnquiryController::class, 'reject'])->name('reject');
    });
});

// Contact Form Route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';
