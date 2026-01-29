@extends('layouts.templates.default')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($rooms as $room)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">{{ $room->name }}</h3>
            <p class="text-gray-600 mb-4">{{ $room->description }}</p>
            
            @if($room->users->contains(Auth::user()))
                <div class="flex space-x-2">
                    <a href="{{ route('chat.room', $room) }}" 
                       class="flex-1 bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600">
                        Войти в чат
                    </a>
                    <form method="POST" action="{{ route('chat.leave', $room) }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Покинуть
                        </button>
                    </form>
                </div>
            @else
                <form method="POST" action="{{ route('chat.join', $room) }}">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Присоединиться
                    </button>
                </form>
            @endif
            
            <div class="mt-4 text-sm text-gray-500">
                Участников: {{ $room->users->count() }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection