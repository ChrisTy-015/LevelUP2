<!-- Modal de réservation -->

<div id="reservationModal" class="hidden fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4" id="reservationModalTitle">Réserver une session</h2>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" id="reservationUserId" name="user_id">
            <input type="datetime-local" name="reservation_date" class="w-full border rounded-lg p-2 mb-4" required>

            <div class="flex justify-end space-x-2">
                <button type="button" id="closeReservationModal"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Annuler</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800">Réserver</button>
            </div>
        </form>
    </div>
</div>


<!-- Script JavaScript pour la gestion du modal -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const openReservationModalButtons = document.querySelectorAll('.open-reservation-modal');
        const reservationModal = document.getElementById('reservationModal');
        const closeReservationModalButton = document.getElementById('closeReservationModal');
        const reservationUser IdField = document.getElementById('userId'); // Correctement défini ici
        const reservationModalTitle = document.getElementById('reservationModalTitle');

        // Ouvre le modal de réservation et insère les données de l'utilisateur
        openReservationModalButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault(); // Empêcher le comportement par défaut du bouton
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
            
            reservationUser IdField.value = userId;  // Remplir le champ caché avec l'ID utilisateur
                reservationModalTitle.textContent = `Réserver une session avec ${userName}`;  // Mettre à jour le titre
                reservationModal.classList.remove('hidden');  // Ouvrir le modal
            });
        });

        // Ferme le modal de réservation
        closeReservationModalButton.addEventListener('click', () => {
            reservationModal.classList.add('hidden');  // Fermer le modal
        });

        // Ferme le modal de réservation si on clique en dehors
        window.addEventListener('click', (event) => {
            if (event.target === reservationModal) {
                reservationModal.classList.add('hidden');  // Fermer le modal si on clique en dehors
            }
        });
</script>
});