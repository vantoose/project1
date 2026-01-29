<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Memo>
 */
class MemoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
		$user_id = User::all()->except(1)->random()->id;
		return [
			'content' => $this->faker->text($maxNbChars = 100),
			'user_id' => $user_id,
		];
    }
}
