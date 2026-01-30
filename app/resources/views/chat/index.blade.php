@extends('layouts.templates.default')

@section('content')
<div class="container">

	<vue-chat-room url="{{ route('chat.index') }}"/>

</div>
@endsection