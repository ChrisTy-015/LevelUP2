@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mes messages</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($messages->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                    </svg>
                    <p>Vous n'avez pas encore de messages</p>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach($messages as $userId => $conversation)
                        @php
                            $otherUser = $conversation->first()->sender_id === auth()->id() 
                                ? $conversation->first()->recipient 
                                : $conversation->first()->sender;
                            $lastMessage = $conversation->first();
                        @endphp
                        <a href="{{ route('messages.conversation', $otherUser->id) }}" 
                           class="block hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($otherUser->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $otherUser->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $lastMessage->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500 truncate">
                                            {{ $lastMessage->content }}
                                        </p>
                                    </div>
                                    @if($conversation->where('recipient_id', auth()->id())->where('read', false)->count() > 0)
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-600 text-white text-xs">
                                                {{ $conversation->where('recipient_id', auth()->id())->where('read', false)->count() }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
