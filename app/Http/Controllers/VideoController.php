<?php

namespace App\Http\Controllers;

use App\Services\VideoService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function returnHomePage()
    {
        try {
            $videos = $this->videoService->getAllVideos();

            return Inertia::render('Home', [
                'videos' => $videos,
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to load videos.']);
        }
    }
}
