@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête de la conversation -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold">
                    {{ substr($otherUser->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-semibold">{{ $otherUser->name }}</h2>
            </div>
            <a href="{{ route('messages.index') }}" class="text-white hover:text-blue-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Zone des messages -->
        <div id="messages-container" class="h-96 overflow-y-auto p-6 space-y-4">
            @foreach($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="{{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg px-4 py-2 max-w-sm">
                        <p class="text-sm">{{ $message->content }}</p>
                        <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-blue-200' : 'text-gray-500' }} mt-1">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulaire d'envoi -->
        <div class="border-t p-4">
            <form action="{{ route('messages.send') }}" method="POST" class="flex space-x-4">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
                <input type="text" name="message" 
                    class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                    placeholder="Écrivez votre message..."
                    required>
                <button type="submit" class="bg-blue-600 text-white rounded-full px-6 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Faire défiler jusqu'au dernier message
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Actualiser les messages toutes les 10 secondes
    setInterval(() => {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMessages = doc.getElementById('messages-container').innerHTML;
                messagesContainer.innerHTML = newMessages;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }, 10000);
</script>
@endsection
