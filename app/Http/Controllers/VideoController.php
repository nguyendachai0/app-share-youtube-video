<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
            $userLikes = $this->videoService->getUserLikes();
            return Inertia::render('Home', [
                'videos' => $videos,
                'userLikes' => $userLikes,
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to load videos.']);
        }
    }

    public function returnSharePage()
    {
        return Inertia::render('SharePage');
    }

    public function likeOrDislikeVideo(Request $request, Video $video)
    {
        $type = $request->input('type');

        $this->videoService->toggleLike($video, $type);

        return response()->json([
            'like_count' => $video->likeCount(),
            'dislike_count' => $video->dislikeCount(),
        ]);
    }
}
