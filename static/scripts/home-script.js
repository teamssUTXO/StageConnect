document.addEventListener("DOMContentLoaded", function() {
    const categoryButtons = document.querySelectorAll(".category-button");

    categoryButtons.forEach((button) => {
        button.addEventListener("click", function() {
            // Retirer la classe active de tous les boutons
            categoryButtons.forEach((btn) => btn.classList.remove("active"));
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add("active");

            // Récupérer la catégorie sélectionnée
            const selectedCategory = this.getAttribute("data-category");

            // Mettre à jour l'URL avec la nouvelle catégorie
            const currentUrl = window.location.href.split('?')[0]; // Récupérer l'URL sans les paramètres
            const newUrl = `${currentUrl}?category=${selectedCategory}`;

            // Rediriger vers la nouvelle URL (cela va recharger la page avec le nouveau filtre)
            window.location.href = newUrl;
        });
    });
});