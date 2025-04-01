document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-overlay");
    const closeModalBtn = document.querySelector(".close-modal");
    const detailButtons = document.querySelectorAll(".details-btn");
    
    detailButtons.forEach(button => {
        button.addEventListener("click", () => {
            
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

            // // affiche les données dans la console pour debug
            console.log({
                title, location, compname, date, remuneration, duration, 
                description, skills, compdesc, compmail, compphone, rating
            });

            // champs de la modale
            document.getElementById("modal-title").textContent = title;
            document.getElementById("modal-location").textContent = location;
            document.getElementById("modal-compname").textContent = compname;
            document.getElementById("modal-compname2").textContent = compname;
            document.getElementById("modal-date").textContent = date;
            
            const remunerationText = remuneration && remuneration !== "Non spécifié" ? 
                `${remuneration} €` : "Non spécifié";
            document.getElementById("modal-remuneration").textContent = remunerationText;
            
            document.getElementById("modal-duration").textContent = duration;
            document.getElementById("modal-description").textContent = description;
            document.getElementById("modal-compdesc").textContent = compdesc;
            document.getElementById("modal-compmail").textContent = `${compmail}`;
            document.getElementById("modal-compphone").textContent = `${compphone}`;
            
            // évaluation
            const ratingValue = parseInt(rating) || 0;
            let ratingHtml = "";
            for (let i = 0; i < 5; i++) {
                if (i < ratingValue) {
                    ratingHtml += `<i class="fa-solid fa-star"></i>`; 
                } else {
                    ratingHtml += `<i class="fa-regular fa-star"></i>`; 
                }
            }
            document.getElementById("modal-rating").innerHTML = ratingHtml;
            
            // transformation compétences en liste
            const skillsList = document.getElementById("modal-skills-list");
            skillsList.innerHTML = "";
            
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

            // affiche la modal
            modal.style.display = "block";
            document.body.classList.add("no-scroll");
        });
    });

    // gere le bouton de fermeture
    closeModalBtn.addEventListener("click", () => {
        modal.style.display = "none";
        document.body.classList.remove("no-scroll");
    });
    
    // gere clique dehors fermeture 
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("no-scroll");
        }
    });
});