<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Создаем тестовых пользователей
        $users = User::all();
        
        // Создаем комнаты
        $generalRoom = ChatRoom::create([
            'name' => 'Общий чат',
            'description' => 'Чат для общих обсуждений'
        ]);
        
        $supportRoom = ChatRoom::create([
            'name' => 'Техподдержка',
            'description' => 'Вопросы по техническим проблемам'
        ]);
        
        $offtopicRoom = ChatRoom::create([
            'name' => 'Оффтопик',
            'description' => 'Обсуждения не по теме'
        ]);
        
        // Присоединяем всех пользователей к комнатам
        $rooms = ChatRoom::all();
        foreach ($rooms as $room) {
            $room->users()->attach($users->pluck('id'));
        }
        
        // Создаем несколько тестовых сообщений
        foreach ($rooms as $room) {
            foreach ($users->take(3) as $user) {
                ChatMessage::create([
                    'chat_room_id' => $room->id, // Изменено с room_id на chat_room_id
                    'user_id' => $user->id,
                    'message' => 'Тестовое сообщение от ' . $user->name . ' в комнате ' . $room->name
                ]);
            }
        }
    }
}