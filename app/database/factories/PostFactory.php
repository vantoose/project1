<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
		$user_id = User::all()->random()->id;
		return [
			'title' => $this->faker->text($maxNbChars = 100),
			'content' => $this->faker->text($maxNbChars = 1000),
			'user_id' => $user_id,
		];
    }
}
