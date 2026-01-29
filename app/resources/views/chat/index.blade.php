@extends('layouts.templates.default')

@section('content')
<div class="container">

	<vue-chat-room url="{{ route('chat.messages', 1) }}"/>

</div>
@endsection