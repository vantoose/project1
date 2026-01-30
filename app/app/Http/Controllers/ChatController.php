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
        $rooms = ChatRoom::with(['users', 'messages' => function($query) {
            $query->latest()->limit(50);
        }])->get();
        if ($request->wantsJson()) return [ 'rooms' => $rooms ];
        return view('chat.index');
    }
}