<?php

use App\Models\User;
use App\Models\Video;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * @test
 */
it('a like belongs to a user', function () {
    $user = User::factory()->create();
    $like = Like::factory()->create(['user_id' => $user->id]);

    expect($like->user->id)->toBe($user->id);
});

/**
 * @test
 */
it('a like belongs to a video', function () {
    $video = Video::factory()->create();
    $like = Like::factory()->create(['video_id' => $video->id]);

    expect($like->video->id)->toBe($video->id);
});
