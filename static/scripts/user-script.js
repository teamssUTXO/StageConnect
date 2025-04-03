// Sélection des éléments de la sidebar et des sections de contenu
const sidebarItems = document.querySelectorAll('.sidebar ul li');
const contentSections = document.querySelectorAll('.content-section');

// Fonction pour afficher une section spécifique et masquer les autres
function showSection(sectionId) {
    // Masquer toutes les sections
    contentSections.forEach(section => {
        section.classList.remove('active');
    });

    // Masquer les formulaires lorsqu'on change de section
    document.getElementById("updateUserForm").style.display = "none";
    document.getElementById("createUserForm").style.display = "none";

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
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez tous les boutons avec la classe "modify-promo"
    const modifyButtons = document.querySelectorAll(".btn.modify-promo");

    // Ajoutez un gestionnaire d'événements à chaque bouton
    modifyButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Récupérez l'ID de l'utilisateur à partir de l'attribut data-id
            const userId = this.getAttribute("data-id");
            

            // Récupérez les données de l'utilisateur dans la ligne correspondante
            const row = this.closest("tr");
            const email = row.querySelector("td:nth-child(3)").textContent.trim();
            const nameSurname = row.querySelector("td:nth-child(2)").textContent.trim();

            
            // Séparez le prénom et le nom
            const [name, ...surnameParts] = nameSurname.split(" ");
            const surname = surnameParts.join(" "); // Recombine les parties restantes pour le nom
            
            // Vérifier si on est dans la section pilotes ou étudiants
            const isStudent = this.closest("#students-management") !== null;
            const promotion = this.getAttribute("data-prom");
            
            // Remplissez les champs du formulaire
            document.getElementById("formIdUser").value = userId;
            document.getElementById("formEmail").value = email;
            document.getElementById("formName").value = name || ""; // Si le prénom est absent
            document.getElementById("formSurname").value = surname || ""; // Si le nom est absent
            document.getElementById("formIdProm").value = promotion;
            
            // Définir le rôle en fonction de la section
            document.getElementById("formIdRole").value = isStudent ? "1" : "2";
            
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

document.getElementById("addStudentButton").addEventListener("click", function() {
    // Réinitialiser les champs du formulaire
    document.getElementById("createFormEmail").value = "";
    document.getElementById("createFormName").value = "";
    document.getElementById("createFormSurname").value = "";
    document.getElementById("createFormPassword").value = "";
    document.getElementById("createFormIdProm").value = "";
    document.getElementById("createFormIdRole").value = "1"; // Étudiant par défaut
    
    // Afficher le formulaire
    const form = document.getElementById("createUserForm");
    form.style.display = "block";
    
    // Faire défiler jusqu'au formulaire
    form.scrollIntoView({ behavior: "smooth" });
});

// Ajouter un gestionnaire pour le bouton "Ajouter un pilote"
document.querySelector(".div-pilots .btn.add").addEventListener("click", function() {
    // Réinitialiser les champs du formulaire
    document.getElementById("createFormEmail").value = "";
    document.getElementById("createFormName").value = "";
    document.getElementById("createFormSurname").value = "";
    document.getElementById("createFormPassword").value = "";
    document.getElementById("createFormIdProm").value = ""; // Peut rester vide ou vous pouvez mettre une valeur par défaut
    document.getElementById("createFormIdRole").value = "2"; // Pilote par défaut
    
    // Afficher le formulaire
    const form = document.getElementById("createUserForm");
    form.style.display = "block";
    
    // Faire défiler jusqu'au formulaire
    form.scrollIntoView({ behavior: "smooth" });
});


// Ajouter un gestionnaire pour le bouton de suppression d'étudiant
document.querySelectorAll(".btn.delete").forEach(button => {
    button.addEventListener("click", function () {
        // Récupérez l'ID de l'utilisateur à partir de l'attribut data-id
        const userId = this.getAttribute("data-id");

        if (!userId) {
            alert("ID utilisateur manquant.");
            return;
        }

        // Demander confirmation avant de supprimer
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            return;
        }

        // Effectuer une requête DELETE
        fetch(`/deleteUser`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ Id_User: userId })
        })
        .then(response => {
            if (response.ok) {
                alert("Utilisateur supprimé avec succès.");
                // Rafraîchir la page ou supprimer la ligne correspondante dans le tableau
                location.reload();
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || "Échec de la suppression de l'utilisateur.");
                });
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur s'est produite lors de la suppression de l'utilisateur.");
        });
    });
});

// Ajouter un gestionnaire pour le bouton de suppression de pilote  
document.querySelectorAll(".btn.delete-pilot").forEach(button => {
    button.addEventListener("click", function () {
        // Récupérez l'ID de l'utilisateur à partir de l'attribut data-id
        const userId = this.getAttribute("data-id");

        if (!userId) {
            alert("ID utilisateur manquant.");
            return;
        }

        // Demander confirmation avant de supprimer
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            return;
        }

        // Effectuer une requête DELETE
        fetch(`/deleteUser`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ Id_User: userId })
        })
        .then(response => {
            if (response.ok) {
                alert("Utilisateur supprimé avec succès.");
                // Rafraîchir la page ou supprimer la ligne correspondante dans le tableau
                location.reload();
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || "Échec de la suppression de l'utilisateur.");
                });
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur s'est produite lors de la suppression de l'utilisateur.");
        });
    });
});

// Ajouter un gestionnaire pour le bouton de suppression des entreprises
document.querySelectorAll(".btn.delete-company").forEach(button => {
    button.addEventListener("click", function () {
        // Récupérez l'ID de l'utilisateur à partir de l'attribut data-id
        const userId = this.getAttribute("data-id");

        if (!userId) {
            alert("ID utilisateur manquant.");
            return;
        }

        // Demander confirmation avant de supprimer
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            return;
        }

        // Effectuer une requête DELETE
        fetch(`/deleteUser`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ Id_User: userId })
        })
        .then(response => {
            if (response.ok) {
                alert("Utilisateur supprimé avec succès.");
                // Rafraîchir la page ou supprimer la ligne correspondante dans le tableau
                location.reload();
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || "Échec de la suppression de l'utilisateur.");
                });
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur s'est produite lors de la suppression de l'utilisateur.");
        });
    });
});

// Sélectionnez tous les boutons avec la classe "modify-company"
const modifyCompanyButtons = document.querySelectorAll(".btn.modify-company");

// Ajoutez un gestionnaire d'événements à chaque bouton
modifyCompanyButtons.forEach(button => {
    button.addEventListener("click", function () {
        // Récupérez le Siret de l'entreprise à partir de l'attribut data-id
        const siret = this.getAttribute("data-id");
        const phone = this.getAttribute("data-phone");
        const description = this.getAttribute("data-des");
        const grade = this.getAttribute("data-grade");

        // Récupérez les données de l'entreprise dans la ligne correspondante
        const row = this.closest("tr");
        const name = row.querySelector("td:nth-child(2)").textContent.trim();
        const email = row.querySelector("td:nth-child(3)").textContent.trim();
        
        
        // Vous pourriez avoir besoin de récupérer d'autres informations
        // comme description, téléphone, etc. depuis la base de données
        // car elles ne sont peut-être pas affichées dans le tableau
        
        // Remplissez les champs du formulaire avec les informations disponibles
        document.getElementById("formSiret").value = siret;
        document.getElementById("formCompanyName").value = name;
        document.getElementById("formCompanyEmail").value = email;
        document.getElementById("formCompanyPhone").value = phone;
        document.getElementById("formCompanyDescription").value = description;
        document.getElementById("formCompanyGrade").value = grade;


        
        // Affichez le formulaire
        const form = document.getElementById("updateCompanyForm");
        form.style.display = "block";
        
        // Faites défiler jusqu'au formulaire
        form.scrollIntoView({ behavior: "smooth" });
    });
});

// Masquer les formulaires lorsqu'on change de section (ajoutez à votre fonction showSection)
// Modifiez la fonction showSection pour inclure le nouveau formulaire
function showSection(sectionId) {
    // Masquer toutes les sections
    contentSections.forEach(section => {
        section.classList.remove('active');
    });

    // Masquer les formulaires lorsqu'on change de section
    document.getElementById("updateUserForm").style.display = "none";
    document.getElementById("createUserForm").style.display = "none";
    document.getElementById("updateCompanyForm").style.display = "none"; // Ajoutez cette ligne

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




    document.querySelector(".div-companies .btn.add").addEventListener("click", function() {
        // Créez un formulaire de création d'entreprise ou réutilisez celui de modification
        // Réinitialiser les champs du formulaire
        document.getElementById("formSiret").value = "";
        document.getElementById("formCompanyName").value = "";
        document.getElementById("formCompanyEmail").value = "";
        document.getElementById("formCompanyPhone").value = "";
        document.getElementById("formCompanyDescription").value = "";
        
       
        
        // Modifiez l'action du formulaire pour la création
        const form = document.getElementById("updateCompanyForm");
        form.action = "/createCompany";
        
        // Affichez le formulaire
        form.style.display = "block";
        
        // Faites défiler jusqu'au formulaire
        form.scrollIntoView({ behavior: "smooth" });
    });   
}

    