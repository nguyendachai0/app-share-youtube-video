<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Video;
use Illuminate\Support\Facades\Log;

class YoutubeVideoService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    /**
     * Fetch video details from YouTube.
     *
     * @param string $url
     * @return array
     */
    public function fetchVideoDetails(string $url): array
    {
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([\w-]{11})/', $url, $matches);
        $videoId = $matches[1] ?? null;

        if (!$videoId) {
            return ['error' => 'Invalid YouTube URL'];
        }

        $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
            'part' => 'snippet,contentDetails',
            'id' => $videoId,
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            return ['error' => 'Failed to fetch video details'];
        }
        return $this->formatResponseData($response->json());
    }

    protected function formatResponseData(array $videoData): array
    {
        $item = $videoData['items'][0];
        $formattedDuration = $this->formatDuration($item['contentDetails']['duration']);

        return [
            'title' => $item['snippet']['title'],
            'description' => $item['snippet']['description'],
            'thumbnail' => $item['snippet']['thumbnails']['high']['url'],
            'duration' => $formattedDuration,
        ];
    }

    protected function formatDuration(string $isoDuration): string
    {
        preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/', $isoDuration, $matches);

        $hours = isset($matches[1]) ? (int)$matches[1] : 0;
        $minutes = isset($matches[2]) ? (int)$matches[2] : 0;
        $seconds = isset($matches[3]) ? (int)$matches[3] : 0;

        $durationParts = [];
        if ($hours > 0) {
            $durationParts[] = "{$hours} hour" . ($hours > 1 ? 's' : '');
        }
        if ($minutes > 0) {
            $durationParts[] = "{$minutes} minute" . ($minutes > 1 ? 's' : '');
        }
        if ($seconds > 0) {
            $durationParts[] = "{$seconds} second" . ($seconds > 1 ? 's' : '');
        }

        return implode(', ', $durationParts);
    }

    public function shareVideo($url, $userID)
    {
        $videoDetails = $this->fetchVideoDetails($url);

        if (isset($videoDetails['error'])) {
            return ['error' => $videoDetails['error']];
        }

        $video = Video::create([
            'user_id' => $userID,
            'title' => $videoDetails['title'],
            'description' => $videoDetails['description'],
            'video_url' => $url,
            'thumbnail_url' => $videoDetails['thumbnail'],
        ]);

        return $video;
    }
}
