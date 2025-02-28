<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            transition: opacity 0.2s ease-in-out;
        }
        .modal-open .modal {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body class="bg-gray-100 font-roboto">

    <!-- Barre de navigation -->
    <header class="bg-blue-600 text-white py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
            <h2 class="text-3xl font-semibold">Level Up</h2>
        </div>
    </header>

    <!-- Section d'accueil -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 shadow-lg rounded-xl p-6">
                <h2 class="text-xl font-bold text-center">Bienvenue dans votre espace Level Up!</h2>
            </div>
        </div>
    </div>

    <!-- Profil utilisateur -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white shadow-lg sm:rounded-lg p-6 flex items-center space-x-6">
            <!-- Photo utilisateur -->
            <div>
                <img src="https://via.placeholder.com/150" alt="Profile Photo" class="w-32 h-32 object-cover rounded-lg border-4 border-purple-400" />
            </div>

            <!-- Informations utilisateur -->
            <div class="flex-1">
                <h1 class="text-2xl font-semibold text-gray-900">John Doe</h1>
                <p class="mt-2 text-sm text-gray-600">Statut : <span class="font-semibold text-purple-600">Mentor</span></p>
                <p class="mt-2 text-sm text-gray-600">Matières enseignées : <span class="font-semibold text-purple-600">Mathématiques, Physique</span></p>
            </div>

            <!-- Boutons d'action -->
            <div class="space-y-4 text-center">
                <button class="block px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-800">Réserver une session</button>
                <button id="openModal" class="block px-6 py-2 text-white bg-green-600 rounded-lg hover:bg-green-800">Envoyer un message</button>
            </div>
        </div>
    </div>

    <!-- Modal pour envoyer un message -->
    <div id="messageModal" class="fixed inset-0  items-center justify-center bg-gray-900 bg-opacity-50 hidden modal">
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Envoyer un message à John Doe</h2>
            <form action="{{ route('messages.send') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="message" rows="4" placeholder="Écrivez votre message ici..." class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800">Envoyer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Récupère les éléments
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const modal = document.getElementById('messageModal');

        // Ouvre le modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('modal-open');
        });

        // Ferme le modal
        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        });

        // Ferme le modal si on clique à l'extérieur
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            }
        });
    </script>
</body>
</html>
