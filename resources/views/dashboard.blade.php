<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-white leading-tight">
                LevelUP
            </h2>
        </div>
    </x-slot>

    <!-- Section principale avec fond sombre -->
    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 text-gray-200 shadow-lg rounded-xl p-6">

                <!-- Titre du questionnaire -->
                <h2 class="text-2xl font-bold text-center text-pink-400 mb-6">
                    Quel est votre objectif ? 🎯
                </h2>

                <!-- Questionnaire -->
                <form action="#" method="POST">
                    <div class="space-y-6">
                        <!-- Options -->
                        @foreach (['carriere' => 'Carrière et activité professionnelle 💼', 'enfants' => 'Cours pour enfants 👶', 'cours_examen' => 'Cours et examens 📚', 'culture' => 'Culture, voyages et loisirs 🌍'] as $value => $label)
                            <div class="flex items-center">
                                <input type="radio" id="{{ $value }}" name="objectif" value="{{ $value }}" class="mr-3 text-pink-600 focus:ring-pink-500">
                                <label for="{{ $value }}" class="text-lg text-gray-300">{{ $label }}</label>
                            </div>
                        @endforeach

                        <!-- Bouton "Découvrez-nous !" -->
                        <div class="text-center mt-6">
                            <a href="{{ route('index.levelup') }}" class="bg-pink-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-pink-700 transition duration-200">
                                Découvrez-nous !
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-pink-600 text-white text-center py-4 mt-16">
        <p class="text-sm">© 2025 LevelUP</p>
    </footer>
</x-app-layout>