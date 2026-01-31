@extends('layouts.templates.default')

@section('content')
<div class="container">

	<vue-chat-room :_room="{{ $chatRoom }}" _load-url="{{ route('chat.rooms.load', $chatRoom) }}" _send-url="{{ route('chat.rooms.send', $chatRoom) }}"/>

</div>
@endsection