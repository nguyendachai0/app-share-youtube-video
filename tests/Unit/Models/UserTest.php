<?php

use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('a user can have multiple videos', function () {
    $user = User::factory()->create();

    $videos = Video::factory(3)->create(['user_id' => $user->id]);

    expect($user->videos)->toHaveCount(3);
    expect($user->videos->contains($videos->first()))->toBeTrue();
});

it('a user can like multiple videos', function () {
    $user = User::factory()->create();
    $video = Video::factory()->create();

    Like::factory()->create(['user_id' => $user->id, 'video_id' => $video->id]);

    expect($user->likes->contains('video_id', $video->id))->toBeTrue();
});
