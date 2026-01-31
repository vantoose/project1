@extends('layouts.templates.default')

@section('content')
<div class="container">

	<div class="card">
        <div class="list-group list-group-flush">
			@foreach ($chatRooms as $chatRoom)
 				<a href="{{ route('chat.rooms.show', $chatRoom) }}" class="list-group-item list-group-item-action">
					<div>{{ $chatRoom->name }}</div>
            		<div class="text-muted small">{{ $chatRoom->description }}</div>
				</a>
			@endforeach
		</div>
	</div>

</div>
@endsection