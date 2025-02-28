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
                            onclick="openMessageModal('{{ $user->id }}', '{{ $user->name }}')"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                            </svg>
                            Envoyer un message
                        </button>

                        <!-- Bouton "Réserver une session" -->
                        <button type="button"
                            onclick="openReservationModal('{{ $user->id }}')"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
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
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" id="closeMessageModal" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="messageModalTitle">
                            Envoyer un message
                        </h3>

                        <div class="mt-4">
                            <form id="messageForm" class="space-y-4">
                                @csrf
                                <input type="hidden" id="messageUserId" name="recipient_id">

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">
                                        Votre message
                                    </label>
                                    <div class="mt-1">
                                        <textarea
                                            id="message"
                                            name="message"
                                            rows="4"
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Écrivez votre message ici..."
                                        ></textarea>
                                    </div>
                                </div>

                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button
                                        type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                                    >
                                        Envoyer
                                    </button>
                                    <button
                                        type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm"
                                        onclick="closeMessageModal()"
                                    >
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de réservation -->
    <div id="reservationModal" class="hidden fixed inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" onclick="closeReservationModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Réserver une session
                        </h3>

                        <form id="reservationForm" class="mt-6 space-y-6">
                            <input type="hidden" id="teacherId" name="teacher_id">
                            
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">
                                    Date de la session
                                </label>
                                <input type="date" 
                                       name="date" 
                                       id="date" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       required>
                            </div>

                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700">
                                    Heure de la session
                                </label>
                                <input type="time" 
                                       name="time" 
                                       id="time" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       required>
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">
                                    Durée (en heures)
                                </label>
                                <select name="duration" 
                                        id="duration" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="1">1 heure</option>
                                    <option value="1.5">1h30</option>
                                    <option value="2">2 heures</option>
                                </select>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">
                                    Notes ou demandes particulières
                                </label>
                                <textarea name="notes" 
                                          id="notes" 
                                          rows="3" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                          placeholder="Précisez vos besoins ou questions..."></textarea>
                            </div>

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Confirmer la réservation
                                </button>
                                <button type="button"
                                        onclick="closeReservationModal()"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour ouvrir le modal de message
        function openMessageModal(userId, userName) {
            document.getElementById('messageUserId').value = userId;
            document.getElementById('messageModalTitle').textContent = `Envoyer un message à ${userName}`;
            document.getElementById('messageModal').classList.remove('hidden');
        }

        // Fonction pour fermer le modal de message
        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
            document.getElementById('message').value = '';
        }

        // Gestionnaire de soumission du formulaire de message
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route('messages.send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    recipient_id: formData.get('recipient_id'),
                    message: formData.get('message')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher un message de succès
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    successMessage.textContent = 'Message envoyé avec succès !';
                    document.body.appendChild(successMessage);
                    
                    // Fermer le modal
                    closeMessageModal();
                    
                    // Supprimer le message après 3 secondes
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Afficher un message d'erreur
                const errorMessage = document.createElement('div');
                errorMessage.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg';
                errorMessage.textContent = 'Une erreur est survenue lors de l\'envoi du message.';
                document.body.appendChild(errorMessage);
                
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            });
        });

        // Fermer le modal en cliquant sur le bouton de fermeture
        document.getElementById('closeMessageModal').addEventListener('click', closeMessageModal);

        // Fermer le modal en cliquant en dehors
        window.addEventListener('click', (event) => {
            const modal = document.getElementById('messageModal');
            if (event.target === modal) {
                closeMessageModal();
            }
        });
    </script>

    <script>
        // Fonction pour ouvrir le modal de réservation
        function openReservationModal(userId) {
            document.getElementById('teacherId').value = userId;
            document.getElementById('reservationModal').classList.remove('hidden');
            
            // Définir la date minimale à aujourd'hui
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').min = today;
        }

        // Fonction pour fermer le modal de réservation
        function closeReservationModal() {
            document.getElementById('reservationModal').classList.add('hidden');
            document.getElementById('reservationForm').reset();
        }

        // Gestionnaire de soumission du formulaire de réservation
        document.getElementById('reservationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route('reservations.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    teacher_id: formData.get('teacher_id'),
                    date: formData.get('date'),
                    time: formData.get('time'),
                    duration: formData.get('duration'),
                    notes: formData.get('notes')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher un message de succès
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    successMessage.textContent = 'Réservation confirmée avec succès !';
                    document.body.appendChild(successMessage);
                    
                    // Fermer le modal
                    closeReservationModal();
                    
                    // Supprimer le message après 3 secondes
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Afficher un message d'erreur
                const errorMessage = document.createElement('div');
                errorMessage.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg';
                errorMessage.textContent = 'Une erreur est survenue lors de la réservation.';
                document.body.appendChild(errorMessage);
                
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            });
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