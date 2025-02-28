@extends('layouts.app')

@section('content')
<div class="py-12">
    @include('components.profile-action-bar', ['user' => $user])
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ $user->name }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ $user->email }}
                            </p>
                        </div>
                        @if(auth()->id() !== $user->id)
                            <div class="flex space-x-4">
                                <a href="{{ route('messages.conversation', $user->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                                    </svg>
                                    Envoyer un message
                                </a>
                            </div>
                        @endif
                    </header>

                    <div class="mt-6 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Statut</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $user->status }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Matières</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @foreach($user->subjects as $subject)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                            {{ $subject->name }}
                                        </span>
                                    @endforeach
                                </dd>
                            </div>
                            @if($user->course)
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Cours</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ $user->course->name }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </section>
            </div>
        </div>

        @if(auth()->id() === $user->id)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Mes messages récents
                            </h2>
                        </header>

                        <div class="space-y-4">
                            @php
                                $recentMessages = \App\Models\Message::where('recipient_id', auth()->id())
                                    ->orWhere('sender_id', auth()->id())
                                    ->with(['sender', 'recipient'])
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get()
                                    ->groupBy(function($message) {
                                        return $message->sender_id === auth()->id() ? $message->recipient_id : $message->sender_id;
                                    });
                            @endphp

                            @forelse($recentMessages as $userId => $messages)
                                @php
                                    $otherUser = $messages->first()->sender_id === auth()->id() 
                                        ? $messages->first()->recipient 
                                        : $messages->first()->sender;
                                    $lastMessage = $messages->first();
                                @endphp
                                <a href="{{ route('messages.conversation', $otherUser->id) }}" 
                                   class="block p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                                {{ substr($otherUser->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $otherUser->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ Str::limit($lastMessage->content, 50) }}
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 text-sm text-gray-500">
                                            {{ $lastMessage->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-gray-500 text-center py-4">
                                    Aucun message récent
                                </p>
                            @endforelse

                            <div class="mt-6">
                                <a href="{{ route('messages.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Voir tous mes messages
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
