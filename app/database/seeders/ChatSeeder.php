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
        // Создаем комнаты
        $generalRoom = ChatRoom::create([
            'name' => 'Общий чат',
            'description' => 'Чат для общих обсуждений',
            'user_id' => 1,
        ]);
        
        $supportRoom = ChatRoom::create([
            'name' => 'Техподдержка',
            'description' => 'Вопросы по техническим проблемам',
            'user_id' => 1,
        ]);
        
        $offtopicRoom = ChatRoom::create([
            'name' => 'Оффтопик',
            'description' => 'Обсуждения не по теме',
            'user_id' => 1,
        ]);

        $users = User::all();
        
        // Присоединяем всех пользователей к комнатам
        $rooms = ChatRoom::all();
        foreach ($rooms as $room) {
            $room->users()->attach($users->pluck('id'));
        }
        
        // Создаем несколько тестовых сообщений
        foreach ($rooms as $room) {
            foreach ($users as $user) {
                $created_at = now()
                ->subYears(1)
                ->addHours(6)
                ->addMinutes($user->id)
                ->addSeconds($user->id);
                
                ChatMessage::create([
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                    'chat_room_id' => $room->id,
                    'user_id' => $user->id,
                    'message' => 'Тестовое сообщение от ' . $user->name . ' в комнате ' . $room->name
                ]);
            }
        }
    }
}