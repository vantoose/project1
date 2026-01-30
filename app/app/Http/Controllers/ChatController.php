<?php

namespace App\Http\Controllers;

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
     * @param  App\Models\ChatRoom  $room
     * @return \Illuminate\Http\Response
     */
    public function getNewMessages(Request $request, ChatRoom $room)
    {
        $lastId = $request->get('last_id', 0);
        $messages = $room->messages()
            ->where('id', '>', $lastId)
            ->latest()
            ->limit(50)
            ->get();
        
        return response()->json([ 'messages' => $messages ]);
    }
}