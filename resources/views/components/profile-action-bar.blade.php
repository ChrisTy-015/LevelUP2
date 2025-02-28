<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ auth()->id() === $user->id ? 'Mon Profil' : 'Profil de ' . $user->name }}
                </h2>
                <div class="flex space-x-4">
                    <a href="{{ route('messages.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                        </svg>
                        Messages
                        @php
                            $unreadCount = \App\Models\Message::where('recipient_id', auth()->id())
                                ->where('read', false)
                                ->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('levelup.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtrer les utilisateurs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
