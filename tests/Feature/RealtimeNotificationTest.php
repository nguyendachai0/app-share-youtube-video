<?php

use App\Events\UserShareVideoEvent;
use App\Models\User;
use App\Models\Video;
use App\Services\YoutubeVideoService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;

it('dispatches a UserShareVideoEvent event when a video is shared', function () {

    Event::fake();

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

    $this->actingAs($user)->postJson('/share-video', [
        'url' => 'https://www.youtube.com/watch?v=sampleId'
    ]);

    Event::assertDispatched(UserShareVideoEvent::class);
});


it('returns error for invalid video URL', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/share-video', ['url' => 'invalid-url']);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['url']);
});
