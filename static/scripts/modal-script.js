document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-overlay");
    const closeModalBtn = document.querySelector(".close-modal");

    // Sélectionner TOUS les boutons de détails
    const detailButtons = document.querySelectorAll(".details-btn");
    
    // Ajouter un écouteur d'événements à chaque bouton
    detailButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Récupère les données du bouton
            const title = button.getAttribute("data-title") || "Non spécifié";
            const location = button.getAttribute("data-location") || "Non spécifié";
            const compname = button.getAttribute("data-compname") || "Non spécifié";
            const date = button.getAttribute("data-date") || "Non spécifié";
            const remuneration = button.getAttribute("data-remuneration") || "Non spécifié";
            const duration = button.getAttribute("data-duration") || "Non spécifié";
            const description = button.getAttribute("data-description") || "Aucune description disponible";
            const skills = button.getAttribute("data-skills") || "";
            const compdesc = button.getAttribute("data-compdesc") || "Aucune description disponible";
            const compmail = button.getAttribute("data-compmail") || "Non spécifié";
            const compphone = button.getAttribute("data-compphone") || "Non spécifié";
            const rating = button.getAttribute("data-compeval") || "0";

            // Debug - Afficher les données dans la console
            console.log({
                title, location, compname, date, remuneration, duration, 
                description, skills, compdesc, compmail, compphone, rating
            });

            // Remplir les champs de la modale
            document.getElementById("modal-title").textContent = title;
            document.getElementById("modal-location").textContent = location;
            document.getElementById("modal-compname").textContent = compname;
            document.getElementById("modal-compname2").textContent = compname;
            document.getElementById("modal-date").textContent = date;
            
            // Formatage de la rémunération
            const remunerationText = remuneration && remuneration !== "Non spécifié" ? 
                `${remuneration} €` : "Non spécifié";
            document.getElementById("modal-remuneration").textContent = remunerationText;
            
            document.getElementById("modal-duration").textContent = duration;
            document.getElementById("modal-description").textContent = description;
            document.getElementById("modal-compdesc").textContent = compdesc;
            document.getElementById("modal-compmail").textContent = `Email: ${compmail}`;
            document.getElementById("modal-compphone").textContent = `Téléphone: ${compphone}`;
            
            // Affichage des étoiles pour l'évaluation
            const ratingValue = parseInt(rating) || 0;
            let ratingHtml = "Évaluation: ";
            for (let i = 0; i < 5; i++) {
                if (i < ratingValue) {
                    ratingHtml += "★"; // Étoile pleine
                } else {
                    ratingHtml += "☆"; // Étoile vide
                }
            }
            document.getElementById("model-rating").innerHTML = ratingHtml;
            
            // Transformation des compétences en liste
            const skillsList = document.getElementById("modal-skills-list");
            skillsList.innerHTML = ""; // Vider la liste
            
            if (skills && skills.trim() !== "") {
                const skillsArray = skills.split(",");
                skillsArray.forEach(skill => {
                    const li = document.createElement("li");
                    li.textContent = skill.trim();
                    skillsList.appendChild(li);
                });
            } else {
                const li = document.createElement("li");
                li.textContent = "Aucune compétence spécifiée";
                skillsList.appendChild(li);
            }

            // Afficher la modale
            modal.style.display = "block";
        });
    });

    // Fermer la modale avec le bouton de fermeture
    closeModalBtn.addEventListener("click", () => modal.style.display = "none");
    
    // Fermer la modale en cliquant en dehors
    modal.addEventListener("click", (event) => {
        if (event.target === modal) modal.style.display = "none";
    });
});