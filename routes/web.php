<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryAnalysisController;
use App\Http\Controllers\TestimonyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;


Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/demo', function () {
    return view('landing.demo');
})->name('demo');

Route::get('/hero', [LandingController::class, 'hero'])->name('landing.hero');
Route::get('/features', [LandingController::class, 'features'])->name('landing.features');
Route::get('/cta', [LandingController::class, 'cta'])->name('landing.cta');
Route::get('/testimonials', [LandingController::class, 'testimonials'])->name('landing.testimonials');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::resource('diaries', DiaryController::class);
    Route::resource('analysis', DiaryAnalysisController::class)->only(['index', 'show', 'destroy']);
    Route::resource('testimonials', TestimonyController::class)->only(['create', 'store']);
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('testimony', TestimonyController::class)->except(['create', 'store']);
});

require __DIR__ . '/auth.php';
