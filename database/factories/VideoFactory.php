<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    protected $model = Video::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $videoUrls = [
            'https://www.youtube.com/watch?v=7ocpwK9uesw',
            'https://www.youtube.com/watch?v=0M84Nk7iWkA',
            'https://youtube.com/watch?v=tv-_1er1mWI',
        ];

        $thumbnailUrls = [
            'https://i.ytimg.com/vi/7ocpwK9uesw/hqdefault.jpg',
            'https://i.ytimg.com/vi/0M84Nk7iWkA/hqdefault.jpg',
            'https://i.ytimg.com/vi/tv-_1er1mWI/hqdefault.jpg',
        ];

        return [
            'title' => $this->faker->sentence,
            'video_url' => $this->faker->randomElement($videoUrls),
            'thumbnail_url' => $this->faker->randomElement($thumbnailUrls),
            'user_id' => User::factory(),
            'description' =>  $this->faker->paragraph()
        ];
    }
}
