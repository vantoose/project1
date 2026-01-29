@extends('layouts.templates.default')

@push('head')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">{{ $room->name }}</h2>
                <a href="{{ route('chat.index') }}" 
                   class="text-gray-500 hover:text-gray-700">← Все комнаты</a>
            </div>
            <p class="text-gray-600 mt-1">{{ $room->description }}</p>
        </div>

        <div class="p-4 h-96 overflow-y-auto" id="messages-container">
            @foreach($room->messages->reverse() as $message)
            <div class="mb-3">
                <div class="flex items-start">
                    <div class="flex-1">
                        <span class="font-semibold text-blue-600">{{ $message->user->name }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $message->created_at->format('H:i') }}</span>
                        <p class="text-gray-800 mt-1">{{ $message->message }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-4 border-t">
            <form id="message-form" class="flex space-x-2">
                @csrf
                <input type="text" 
                       id="message-input"
                       class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       placeholder="Введите сообщение..."
                       autocomplete="off">
                <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    Отправить
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('message-form');
    const input = document.getElementById('message-input');
    const container = document.getElementById('messages-container');
    const roomId = {{ $room->id }};
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (input.value.trim() === '') return;
        
        axios.post('/room/' + roomId + '/message', {
            message: input.value,
            _token: '{{ csrf_token() }}'
        })
        .then(response => {
            input.value = '';
            addMessage(response.data);
        })
        .catch(error => {
            console.error(error);
        });
    });
    
    function addMessage(message) {
        const time = new Date(message.created_at).toLocaleTimeString('ru-RU', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const html = `
            <div class="mb-3">
                <div class="flex items-start">
                    <div class="flex-1">
                        <span class="font-semibold text-blue-600">${message.user.name}</span>
                        <span class="text-xs text-gray-500 ml-2">${time}</span>
                        <p class="text-gray-800 mt-1">${message.message}</p>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        container.scrollTop = container.scrollHeight;
    }
    
    // Автопрокрутка к новым сообщениям
    container.scrollTop = container.scrollHeight;
    
    // Polling для новых сообщений (можно заменить на WebSocket)
    let lastMessageId = {{ $room->messages->first() ? $room->messages->first()->id : 0 }};
    
    setInterval(() => {
        axios.get(`/room/${roomId}/messages?last_id=${lastMessageId}`)
            .then(response => {
                if (response.data.length > 0) {
                    response.data.forEach(message => {
                        addMessage(message);
                        if (message.id > lastMessageId) {
                            lastMessageId = message.id;
                        }
                    });
                }
            });
    }, 3000);
});
</script>
@endpush