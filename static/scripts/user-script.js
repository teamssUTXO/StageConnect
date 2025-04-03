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

    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionnez tous les boutons "Modifier étudiant"
        const modifyButtons = document.querySelectorAll(".btn.modify-promo");
    
        // Ajoutez un gestionnaire d'événements à chaque bouton
        modifyButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Récupérez l'ID de l'étudiant à partir de l'attribut data-id
                const studentId = this.getAttribute("data-id");
    
                // Récupérez les données de l'étudiant dans la ligne correspondante
                const row = this.closest("tr");
                const email = row.querySelector("td:nth-child(3)").textContent.trim();
                const nameSurname = row.querySelector("td:nth-child(2)").textContent.trim();
                const promotion = row.querySelector("td:nth-child(4)").textContent.trim();
    
                // Séparez le prénom et le nom
                const [name, ...surnameParts] = nameSurname.split(" ");
                const surname = surnameParts.join(" "); // Recombine les parties restantes pour le nom
    
                // Remplissez les champs du formulaire
                document.getElementById("formIdUser").value = studentId;
                document.getElementById("formEmail").value = email;
                document.getElementById("formName").value = name || ""; // Si le prénom est absent
                document.getElementById("formSurname").value = surname || ""; // Si le nom est absent
                document.getElementById("formIdProm").value = promotion;
    
                // Laissez le champ "password" vide pour permettre la saisie d'un nouveau mot de passe
                document.getElementById("formPassword").value = "";
    
                // Affichez le formulaire
                const form = document.getElementById("updateUserForm");
                form.style.display = "block";
    
                // Faites défiler jusqu'au formulaire
                form.scrollIntoView({ behavior: "smooth" });
            });
        });
    });