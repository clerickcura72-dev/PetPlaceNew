<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffApprovalController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\VetDashboardController;

// ── HOME ──────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── CHOOSE ACCOUNT ────────────────────────────────────────
Route::get('/choose', function () {
    return view('choose');
})->name('choose');

// ── VET AUTH ──────────────────────────────────────────────
Route::get('/login/vet', function () {
    return view('auth.login-vet');
})->name('login.vet');

Route::get('/register/vet', function () {
    return view('auth.register-vet');
})->name('register.vet');

// ── OWNER AUTH ────────────────────────────────────────────
Route::get('/login/owner', function () {
    return view('auth.login-owner');
})->name('login.owner');

Route::get('/register/owner', function () {
    return view('auth.register-owner');
})->name('register.owner');

// ── PROTECTED ROUTES ──────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Sends each user to their own dashboard
    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->dashboardRouteName());
    })->name('dashboard');

    // Profile routes (required by Breeze navigation)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::get('/admin/dashboard', function () {
        abort_unless(auth()->user()->isAdmin(), 403);
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/staff-applications', [StaffApprovalController::class, 'index'])
        ->name('admin.staff-applications');

    Route::patch('/admin/staff-applications/{vet}/approve', [StaffApprovalController::class, 'approve'])
        ->name('admin.staff-approve');

    Route::patch('/admin/staff-applications/{vet}/reject', [StaffApprovalController::class, 'reject'])
        ->name('admin.staff-reject');

    // Vet dashboard
    Route::get('/vet/dashboard', [VetDashboardController::class, 'show'])
        ->name('vet.dashboard');

    Route::patch('/vet/availability', [VetDashboardController::class, 'saveAvailability'])
        ->name('vet.availability.update');

    Route::patch('/vet/appointments/{appointment}/respond', [VetDashboardController::class, 'respond'])
        ->name('vet.appointments.respond');

    Route::post('/vet/patients/{pet}/visits', [VetDashboardController::class, 'storeVisit'])
        ->name('vet.visits.store');

    Route::post('/vet/patients/{pet}/vaccinations', [VetDashboardController::class, 'storeVaccination'])
        ->name('vet.vaccinations.store');

    // Owner dashboard
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'show'])
        ->name('owner.dashboard');

    Route::post('/owner/pets', [OwnerDashboardController::class, 'storePet'])
        ->name('owner.pets.store');

    Route::patch('/owner/pets/{pet}', [OwnerDashboardController::class, 'updatePet'])
        ->name('owner.pets.update');

    Route::delete('/owner/pets/{pet}', [OwnerDashboardController::class, 'destroyPet'])
        ->name('owner.pets.destroy');

    Route::patch('/owner/pets/{pet}/birthdate', [OwnerDashboardController::class, 'updateBirthdate'])
        ->name('owner.pets.birthdate');

    Route::post('/owner/pets/{pet}/photo', [OwnerDashboardController::class, 'updatePhoto'])
        ->name('owner.pets.photo');

    Route::post('/owner/appointments', [OwnerDashboardController::class, 'bookAppointment'])
        ->name('owner.appointments.store');

});

// ── BREEZE AUTH ROUTES (login, logout, password reset) ────
require __DIR__.'/auth.php';
