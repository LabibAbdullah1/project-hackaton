<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MoodResultController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\DiaryController;

// Gunakan middleware 'auth' standar
Route::middleware('auth')->group(function () {
    // URL yang lebih 'web-friendly'
    Route::post('/diaries/submit', [DiaryController::class, 'store'])->name('diaries.store');

require __DIR__.'/auth.php';