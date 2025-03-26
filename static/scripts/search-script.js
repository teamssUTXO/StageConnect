/* ICON COEUR WISHLIST */
document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        icon.classList.toggle('active');
        icon.classList.toggle('far'); // Cœur vide
        icon.classList.toggle('fas'); // Cœur plein

    });
});

/* GESTION DE LA FERMETURE DE LA FENETRE MODALE */
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('modal-overlay');
    const detailsButtons = document.querySelectorAll('.details-btn');
    const closeModalButton = document.querySelector('.close-modal');

    // Fonction pour ouvrir la modale
    function openModal() {
        modalOverlay.style.display = 'flex'; // Affiche la modale
        document.body.classList.add('no-scroll'); // Désactive le défilement
    }

    // Fonction pour fermer la modale
    function closeModal() {
        modalOverlay.style.display = 'none'; // Masque la modale
        document.body.classList.remove('no-scroll'); // Réactive le défilement
    }

    // Ouvrir la modale lors du clic sur un bouton "details-btn"
    detailsButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });

    // Fermer la modale lors du clic sur le bouton de fermeture
    closeModalButton.addEventListener('click', closeModal);

    // Fermer la modale lors du clic à l'extérieur de la modale
    modalOverlay.addEventListener('click', function (event) {
        if (event.target === modalOverlay) {
            closeModal();
        }
    });
});

/* GESTION DU CHANGEMENT DE PAGE AVEC INPUT */
document.getElementById('sort-by').addEventListener('change', function () {
    const selectedValue = this.value;

    if (selectedValue === 'offer') {
        window.location.href = 'search-offer.html';
    } else if (selectedValue === 'company') {
        window.location.href = 'search-company.html';
    }
});
