<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Services\YoutubeVideoService;
use Illuminate\Support\Facades\Log;

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

        // Use the VideoSharingService to share the video
        $video = $this->youtubeVideoService->shareVideo($request->url, $userID);

        if (isset($video['error'])) {
            return response()->json(['error' => $video['error']], 422);
        }

        return response()->json($video, 201);
    }
}
