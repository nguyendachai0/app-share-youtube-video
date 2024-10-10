<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\User;
use App\Models\Video;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'video_id' => Video::factory(),
            'type' => $this->faker->randomElement(['like', 'dislike']),
            'active' => true
        ];
    }
}
