@extends('layouts.templates.default')

@section('content')
<div class="container">

	@if ($chatRooms->count())
		<div class="card">
			<div class="list-group list-group-flush">
				@foreach ($chatRooms as $chatRoom)
					<a href="{{ route('chat.rooms.show', $chatRoom) }}" class="list-group-item list-group-item-action">
						<div>{{ $chatRoom->name == "" ? $chatRoom->users->reject(fn($u) => $u->id === Auth::id())->pluck('name')->join(', ') : $chatRoom->name }}</div>
						<div class="text-muted small">{{ $chatRoom->description }}</div>
					</a>
				@endforeach
			</div>
		</div>
	@endif

</div>
@endsection