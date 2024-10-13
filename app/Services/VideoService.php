<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                'dislikes' => $video->dislikeCount(),
                'video_url' => $video->video_url,
                'embed_url' => $video->embed_url,
                'thumbnail_url' => $video->thumbnail_url,
                'user_name' => $video->user->name
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

    public function getUserLikes()
    {
        $userId = Auth::id();

        $listLikeOrDislike = Like::where('user_id', $userId)
            ->where('active', 1)
            ->select('id', 'video_id', 'type')
            ->get();

        return $listLikeOrDislike;
    }
}
