<?php

namespace App\Http\Controllers;

use App\Events\UserShareVideoEvent;
use App\Jobs\SendUserNotification;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Services\YoutubeVideoService;
use Illuminate\Support\Facades\Log;
use App\Notifications\VideoSharedNotification;
use Illuminate\Support\Facades\Notification;

class YoutubeVideoController extends Controller
{
    protected $youtubeVideoService;

    public function __construct(YoutubeVideoService $youtubeVideoService)
    {
        $this->youtubeVideoService = $youtubeVideoService;
    }

    public function getVideoDetails(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $videoDetails = $this->youtubeVideoService->fetchVideoDetails($request->url);

        if (isset($videoDetails['error'])) {
            return response()->json(['error' => $videoDetails['error']], 422);
        }

        return response()->json($videoDetails);
    }

    public function shareVideo(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $userID = auth()->id();
        $userName = auth()->user()->name;


        $video = $this->youtubeVideoService->shareVideo($request->url, $userID);

        if (isset($video['error'])) {
            return response()->json(['error' => $video['error']], 422);
        }

        broadcast(new UserShareVideoEvent($userName, $video->title));

        return response()->json($video, 201);
    }
}
