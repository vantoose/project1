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
        $chatRooms = $request->user()->chatRooms;
        return view('chat.index')->withChatRooms($chatRooms);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ChatRoom $chatRoom)
    {
        if ($request->wantsJson()) return response()->json([ 'chatRoom' => $chatRoom->load(['messages', 'users']) ]);
        return view('chat.room.show')->withChatRoom($chatRoom->load(['messages', 'users']));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function load(Request $request, ChatRoom $chatRoom)
    {
        $chatMessages = $chatRoom->messages;
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
}