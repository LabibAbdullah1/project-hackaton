<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryAnalysisController;
use App\Http\Controllers\TestimonyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [DiaryController::class, 'index'])->name('user.dashboard');

    Route::resource('diaries', DiaryController::class);

    Route::resource('analysis', DiaryAnalysisController::class)
        ->only(['index', 'show', 'destroy']);

    Route::resource('testimonials', TestimonyController::class)
        ->only(['create', 'store']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('testimony', TestimonyController::class)->except(['create', 'store']); // Create & Store ada di sisi User

});

require __DIR__ . '/auth.php';
