<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatMessage;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rooms = $request->user()->chatRooms;
        if ($request->wantsJson()) return response()->json([ 'rooms' => $rooms ]);
        return view('chat.index');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function getChatMessages(Request $request, ChatRoom $chatRoom)
    {
        $lastId = $request->get('last_id', 0);
        $chatMessages = $chatRoom->messages()
            ->where('id', '>', $lastId)
            ->latest()
            ->limit(50)
            ->get();
        
        return response()->json([ 'messages' => $chatMessages ]);
    }

    /**
     * @param  \Illuminate\Http\StoreChatMessage  $request
     * @param  App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function storeChatMessage(StoreChatMessage $request, ChatRoom $chatRoom)
    {
        $validated = $request->validated();

        $chatMessage = new ChatMessage;
        $chatMessage->message = $validated['message'];
        $chatMessage->chat_room_id = $chatRoom->id;
        $chatMessage->user_id = $request->user()->id;
        $chatMessage->save();

        return response()->json($chatMessage);
    }

    // public function joinRoom(ChatRoom $room, User $user)
    // {
    //     if (!$room->users->contains($user)) {
    //         $room->users()->attach($user);
    //     }
    // }

    // public function leaveRoom(ChatRoom $room, User $user)
    // {
    //     $room->users()->detach($user);
    // }
}