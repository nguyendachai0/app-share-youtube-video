<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoService
{
    public function getAllVideos()
    {
        return Video::with(['user', 'likes'])->get()->map(function ($video) {
            return [
                'id' => $video->id,
                'title' => $video->title,
                'description' => $video->description,
                'likes' => $video->likeCount(),
                'dislike' => $video->dislikeCount(),
                'video_url' => $video->url,
                'thumbnail_url' => $video->thumbnail_url,
                'user' => $video->user->name
            ];
        });
    }
    public function toggleLike(Video $video, $type)
    {
        $userId = Auth::id();

        $existingLike = Like::where('user_id', $userId)
            ->where('video_id', $video->id)
            ->first();

        if ($existingLike) {

            if ($existingLike->type === $type) {
                $existingLike->active = !$existingLike->active;
                $existingLike->save();
            } else {

                $existingLike->update(['type' => $type, 'active' => true]);
            }
        } else {

            Like::create([
                'user_id' => $userId,
                'video_id' => $video->id,
                'type' => $type,
                'active' => true
            ]);
        }
    }
}
