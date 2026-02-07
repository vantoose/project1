<?php

namespace Database\Factories;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $chat_room_id = ChatRoom::all()->random()->id;
		$user_id = User::all()->random()->id;
        return [
            'chat_room_id' => $chat_room_id,
            'user_id' => $user_id,
            'message' => $this->faker->text($maxNbChars = 100),
        ];
    }
}
