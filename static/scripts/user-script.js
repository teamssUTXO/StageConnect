// Sélection des éléments de la sidebar et des sections de contenu
const sidebarItems = document.querySelectorAll('.sidebar ul li');
const contentSections = document.querySelectorAll('.content-section');

// Fonction pour afficher une section spécifique et masquer les autres
function showSection(sectionId) {
    // Masquer toutes les sections
    contentSections.forEach(section => {
        section.classList.remove('active');
    });

    // Afficher la section correspondante
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }

    // Mettre à jour l'élément actif dans la sidebar
    sidebarItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('onclick').includes(sectionId)) {
            item.classList.add('active');
        }
    });
}

// Ajouter un écouteur d'événements à chaque élément de la sidebar
sidebarItems.forEach(item => {
    item.addEventListener('click', () => {
        // Récupérer l'ID de la section à afficher depuis l'attribut onclick
        const sectionId = item.getAttribute('onclick').match(/'(.*?)'/)[1];
        showSection(sectionId);
    });
});

// Afficher la première section par défaut au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    showSection('settings'); // Remplacez 'settings' par l'ID de la section par défaut
});