<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $rooms = ChatRoom::with(['users', 'messages' => function($query) {
            $query->latest()->limit(50);
        }])->get();

        return view('chat.index', compact('rooms'));
    }

    public function show(ChatRoom $room)
    {
        $room->load(['messages' => function($query) {
            $query->with('user')->latest()->limit(100);
        }]);

        return view('chat.room', compact('room'));
    }

    public function sendMessage(Request $request, ChatRoom $room)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = ChatMessage::create([
            'chat_room_id' => $room->id, // Изменено с room_id на chat_room_id
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        $message->load('user');

        return response()->json($message);
    }

    public function joinRoom(ChatRoom $room)
    {
        $user = Auth::user();
        
        if (!$room->users->contains($user)) {
            $room->users()->attach($user);
        }

        return redirect()->route('chat.room', $room);
    }

    public function leaveRoom(ChatRoom $room)
    {
        $room->users()->detach(Auth::id());

        return redirect()->route('chat.index');
    }

    public function getNewMessages(ChatRoom $room, Request $request)
    {
        $lastId = $request->get('last_id', 0);
        
        $messages = $room->messages()
            ->with('user')
            ->where('id', '>', $lastId)
            ->latest()
            ->limit(50)
            ->get();
        
        return response()->json($messages);
    }
}