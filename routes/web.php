<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\YoutubeVideoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',  [HomeController::class, 'home']);

Route::post('/get-video-details', [YoutubeVideoController::class, 'getVideoDetails']);

Route::post('/share-video', [YoutubeVideoController::class, 'shareVideo']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
