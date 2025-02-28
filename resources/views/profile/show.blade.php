@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Mon Profil') }}
                    </h2>
                </header>

                <div class="space-y-6">
                    <!-- Photo de profil -->
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-300 rounded-full overflow-hidden">
                            @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                     alt="Photo de profil" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-2xl text-gray-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Informations du profil -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <dl class="divide-y divide-gray-200">
                            <!-- Statut -->
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                    {{ $user->status ?? 'Non défini' }}
                                </dd>
                            </div>

                            <!-- Formation -->
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Formation</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                    {{ $user->course->name ?? 'Non définie' }}
                                </dd>
                            </div>

                            <!-- Matières enseignées -->
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Matières enseignées</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($user->subjects as $subject)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $subject->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500">Aucune matière spécifiée</span>
                                        @endforelse
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Modifier mon profil') }}
                        </a>
                        <a href="{{ route('index.levelup') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Retour à LevelUp') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
