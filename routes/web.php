<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\ProfileController;


// ======================================
// PUBLIC LANDING PAGE
// ======================================
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/demo', function () {
    return view('landing.demo');
})->name('demo');

Route::get('/hero', [LandingController::class, 'hero'])->name('landing.hero');
Route::get('/features', [LandingController::class, 'features'])->name('landing.features');
Route::get('/cta', [LandingController::class, 'cta'])->name('landing.cta');
Route::get('/testimonials', [LandingController::class, 'testimonials'])->name('landing.testimonials');


// ======================================
// USER ROUTES (LOGIN + VERIFIED)
// ======================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // Profile management (breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ======================================
// ADMIN ROUTES (ROLE ADMIN REQUIRED)
// ======================================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
});


// Auth Routes (Login, Register, Forgot Password)
require __DIR__ . '/auth.php';
