<?php

use App\Models\User;
use App\Models\Video;
use App\Services\YoutubeVideoService;
use Illuminate\Http\Response;



it('returns error for invalid video URL', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/share-video', ['url' => 'invalid-url']);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY); // or whatever status your validation returns
    $response->assertJsonValidationErrors(['url']);
});

it('stores video details when sharing a video', function () {

    $user = User::factory()->create();

    $youtubeService = mock(YoutubeVideoService::class);

    $youtubeService->shouldReceive('shareVideo')
        ->once()
        ->with('https://www.youtube.com/watch?v=sampleId', $user->id)
        ->andReturnUsing(function ($url, $userId) {
            return Video::create([
                'user_id' => $userId,
                'title' => 'Sample Video Title',
                'description' => 'Sample Video Description',
                'video_url' => $url,
                'thumbnail_url' => 'http://example.com/thumbnail.jpg',
            ]);
        });

    app()->instance(YoutubeVideoService::class, $youtubeService);

    $response = $this->actingAs($user)
        ->postJson('/share-video', ['url' => 'https://www.youtube.com/watch?v=sampleId']);

    $response->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('videos', [
        'user_id' => $user->id,
        'title' => 'Sample Video Title',
        'description' => 'Sample Video Description',
        'video_url' => 'https://www.youtube.com/watch?v=sampleId',
        'thumbnail_url' => 'http://example.com/thumbnail.jpg',
    ]);
});
