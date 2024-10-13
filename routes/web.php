<?php

use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\YoutubeVideoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',  [VideoController::class, 'returnHomePage']);

Route::post('/get-video-details', [YoutubeVideoController::class, 'getVideoDetails']);

Route::post('/share-video', [YoutubeVideoController::class, 'shareVideo']);

Route::post('/videos/{video}/like-or-dislike', [VideoController::class, 'likeOrDislikeVideo']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
