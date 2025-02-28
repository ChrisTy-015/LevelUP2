@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-roboto">

    <!-- Barre de navigation -->
    <header class="bg-blue-600 text-white py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
            <h2 class="text-3xl font-semibold">Level Up</h2>
            <div class="space-x-6">
                <a href="#devenir-professeur" class="text-lg font-semibold hover:text-blue-800">Devenir Professeur</a>
                <a href="#trouver-professeur" class="text-lg font-semibold hover:text-blue-800">Trouver un
                    Professeur</a>
                <a href="{{ route('profile.edit') }}" class="text-lg font-semibold hover:text-blue-800">Mon Profil</a>
            </div>
        </div>
    </header>

    <!-- Section d'accueil -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 shadow-lg rounded-xl p-6">
                <h2 class="text-xl font-bold text-center">Bienvenue dans votre espace Level Up!</h2>
                <p class="mt-2 text-center text-lg">Explorez votre parcours d'apprentissage, devenez professeur ou
                    trouvez un mentor.</p>
            </div>
        </div>
    </div>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('levelup.filter') }}" method="GET" class="mb-6 max-w-7xl mx-auto px-6">
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
            <select name="subject"
                class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/3 focus:ring focus:ring-blue-300 focus:outline-none">
                <option value="">Sélectionnez une matière</option>
                @if(isset($subjects) && $subjects->count())
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                @else
                    <option disabled>Aucune matière disponible</option>
                @endif
            </select>
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-800 focus:ring focus:ring-blue-300">
                Filtrer
            </button>
        </div>
    </form>

    <!-- Liste des utilisateurs -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($users) && $users->count())
                @foreach($users as $user)
                    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center text-center">
                        <div class="w-32 h-32 bg-gray-300 rounded-md overflow-hidden border-4 border-purple-400 mb-4 relative">
                            @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                     alt="Photo de profil de {{ $user->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-500 text-xl">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            @if(Auth::id() === $user->id)
                                <input type="file" id="profilePhotoInput_{{ $user->id }}" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="uploadProfilePhoto(event, {{ $user->id }})">
                                <label for="profilePhotoInput_{{ $user->id }}" 
                                       class="absolute inset-0 cursor-pointer bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-200">
                                </label>
                            @endif
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-600 mt-2">{{ $user->biography }}</p>
                        <p class="text-sm text-gray-600 mt-2">
                            Matières enseignées :
                            @if($user->subjects->count() > 0)
                                @foreach($user->subjects as $subject)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                        {{ $subject->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-500">Aucune matière spécifiée</span>
                            @endif
                        </p>
                        <!-- Bouton "Envoyer un message" -->
                        <button type="button"
                            class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800 open-modal"
                            data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            Envoyer un message
                        </button>

                        <!-- Bouton "Réserver une session" -->
                        <button type="button"
                            class="block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 open-reservation-modal"
                            data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            Réserver une session
                        </button>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-600">Aucun utilisateur trouvé.</p>
            @endif
        </div>
    </div>

    <!-- Modal d'envoi de message -->
    <div id="messageModal" class="hidden fixed inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="messageModalTitle">
                            Envoyer un message
                        </h3>
                        <div class="mt-4">
                            <form id="messageForm">
                                <input type="hidden" id="messageUserId" name="user_id">
                                <div class="mt-2">
                                    <textarea id="message" name="message" rows="4"
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                        placeholder="Écrivez votre message ici..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" id="sendMessage"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Envoyer
                    </button>
                    <button type="button" id="cancelMessage"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de réservation -->
    <div id="reservationModal" class="hidden fixed inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Réserver une session
                        </h3>
                        <div class="mt-4">
                            <form id="reservationForm">
                                <input type="hidden" id="teacherId" name="user_id">
                                <div class="mt-2">
                                    <label for="sessionDate" class="block text-sm font-medium text-gray-700">
                                        Date et heure de la session
                                    </label>
                                    <input type="datetime-local" id="sessionDate" name="session_date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmReservation"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer
                    </button>
                    <button type="button" id="cancelReservation"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour ouvrir le modal de message
        function openMessageModal(userId, userName) {
            document.getElementById('messageUserId').value = userId;
            document.getElementById('messageModalTitle').textContent = `Envoyer un message à ${userName}`;
            const modal = document.getElementById('messageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Fonction pour fermer le modal de message
        function closeMessageModal() {
            const modal = document.getElementById('messageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('message').value = '';
        }

        // Gestionnaire d'événements pour le bouton "Envoyer un message"
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                openMessageModal(userId, userName);
            });
        });

        // Gestionnaire d'événements pour le bouton "Annuler" du modal de message
        document.getElementById('cancelMessage').addEventListener('click', closeMessageModal);

        // Gestionnaire d'événements pour le bouton "Envoyer" du modal de message
        document.getElementById('sendMessage').addEventListener('click', () => {
            const form = document.getElementById('messageForm');
            const formData = new FormData(form);
            formData.append('message', document.getElementById('message').value);

            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Message envoyé avec succès !');
                    closeMessageModal();
                } else {
                    alert('Erreur lors de l\'envoi du message');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'envoi du message');
            });
        });

        // Fonction pour ouvrir le modal de réservation
        function openReservationModal(userId) {
            document.getElementById('teacherId').value = userId;
            const modal = document.getElementById('reservationModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Fonction pour fermer le modal de réservation
        function closeReservationModal() {
            const modal = document.getElementById('reservationModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Gestionnaire d'événements pour le bouton "Réserver une session"
        document.querySelectorAll('.open-reservation-modal').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-user-id');
                openReservationModal(userId);
            });
        });

        // Gestionnaire d'événements pour le bouton "Annuler"
        document.getElementById('cancelReservation').addEventListener('click', closeReservationModal);

        // Gestionnaire d'événements pour le bouton "Confirmer"
        document.getElementById('confirmReservation').addEventListener('click', () => {
            const form = document.getElementById('reservationForm');
            const formData = new FormData(form);

            fetch('/reservations', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Réservation effectuée avec succès !');
                    closeReservationModal();
                } else {
                    alert('Erreur lors de la réservation');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la réservation');
            });
        });

        // Fermer les modals en cliquant sur l'arrière-plan
        window.addEventListener('click', (event) => {
            const messageModal = document.getElementById('messageModal');
            const reservationModal = document.getElementById('reservationModal');
            
            if (event.target === messageModal) {
                closeMessageModal();
            }
            if (event.target === reservationModal) {
                closeReservationModal();
            }
        });
    </script>

    <script>
        function uploadProfilePhoto(event, userId) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('profile_photo', file);
            formData.append('_token', '{{ csrf_token() }}');

            fetch(`/profile/photo/update`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'image affichée
                    const imgElement = event.target.parentElement.querySelector('img');
                    if (imgElement) {
                        imgElement.src = URL.createObjectURL(file);
                    } else {
                        // Si pas d'image, créer une nouvelle
                        const container = event.target.parentElement;
                        container.innerHTML = `
                            <img src="${URL.createObjectURL(file)}" 
                                 alt="Photo de profil" 
                                 class="w-full h-full object-cover">
                            ${container.innerHTML}
                        `;
                    }
                    // Afficher un message de succès
                    alert('Photo de profil mise à jour avec succès !');
                } else {
                    alert('Erreur lors de la mise à jour de la photo : ' + (data.message || 'Erreur inconnue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour de la photo : ' + error.message);
            });
        }
    </script>

</body>

</html>