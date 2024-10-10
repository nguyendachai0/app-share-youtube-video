<?php

use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use App\Models\Video;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('a video can have multiple likes', function () {
    $video = Video::factory()->create();

    // Create likes for the video
    Like::factory(3)->create(['video_id' => $video->id]);

    // Assert that the video has 3 likes
    expect($video->likes)->toHaveCount(3);
});

it('a video belongs to a user', function () {
    $user = User::factory()->create();
    $video = Video::factory()->create(['user_id' => $user->id]);

    expect($video->user->id)->toBe($user->id);
});
