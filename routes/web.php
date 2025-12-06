<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryAnalysisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserDashboardController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/demo', function () {
    return view('landing.demo');
})->name('demo');

Route::get('/hero', [LandingController::class, 'hero'])->name('landing.hero');
Route::get('/features', [LandingController::class, 'features'])->name('landing.features');
Route::get('/cta', [LandingController::class, 'cta'])->name('landing.cta');
Route::get('/testimonials', [LandingController::class, 'testimonials'])->name('landing.testimonials');


Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile (ini bawaan Breeze)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Diary
        Route::get('/diary', [DiaryController::class, 'index'])->name('diary.index');
        Route::get('/diary/create', [DiaryController::class, 'create'])->name('diary.create');
        Route::post('/diary', [DiaryController::class, 'store'])->name('diary.store');
        Route::get('/diary/{id}', [DiaryController::class, 'show'])->name('diary.show');
        Route::delete('/diary/{id}', [DiaryController::class,'destroy'])->name('diary.destroy');
        // Route::get('/diary/edit', [DiaryController::class, 'edit'])->name('diary.edit');



        // Settings (kalau ada)
    //    Route::get('/settings', [SettingsController::class, 'index'])->name('user.settings');

    });



require __DIR__ . '/auth.php';
