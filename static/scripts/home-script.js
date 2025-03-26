/* ENTREPRISES */
document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelector(".menu-items");
    const categoryButtons = document.querySelectorAll(".category-button");

    // Données des entreprises par catégorie
    const companies = [
        // À découvrir (toutes les entreprises)
        {
            name: "TechCorp",
            category: "Tech",
            image: "images/techcorp.jpg",
            description: "Une entreprise innovante dans le domaine de la technologie.",
        },
        {
            name: "EcoShare",
            category: "Economie",
            image: "images/ecoshare.jpg",
            description: "Pionnière de l'économie collaborative.",
        },
        {
            name: "GreenEnergy",
            category: "Energie",
            image: "images/greenenergy.jpg",
            description: "Des solutions énergétiques durables.",
        },
        {
            name: "MediaPlus",
            category: "Media",
            image: "images/mediaplus.jpg",
            description: "Leader dans le domaine des médias.",
        },
        {
            name: "HelpAssociation",
            category: "Association",
            image: "images/helpassociation.jpg",
            description: "Une association dédiée à l'aide humanitaire.",
        },
        {
            name: "FashionHub",
            category: "Mode",
            image: "images/fashionhub.jpg",
            description: "Innovation et style dans le monde de la mode.",
        },
        // Entreprises supplémentaires pour chaque catégorie
        {
            name: "CodeMaster",
            category: "Tech",
            image: "images/codemaster.jpg",
            description: "Spécialiste en développement logiciel.",
        },
        {
            name: "EcoTrade",
            category: "Economie",
            image: "images/ecotrade.jpg",
            description: "Plateforme d'échange économique durable.",
        },
        {
            name: "SolarTech",
            category: "Energie",
            image: "images/solartech.jpg",
            description: "Énergie solaire pour un avenir vert.",
        },
        {
            name: "NewsWorld",
            category: "Media",
            image: "images/newsworld.jpg",
            description: "L'actualité mondiale à portée de main.",
        },
        {
            name: "GreenEarth",
            category: "Association",
            image: "images/greenearth.jpg",
            description: "Protégeons notre planète ensemble.",
        },
        {
            name: "ChicStyle",
            category: "Mode",
            image: "images/chicstyle.jpg",
            description: "La mode à son meilleur.",
        },
        // Entreprises supplémentaires pour chaque catégorie
        {
            name: "CodeMaster",
            category: "Tech",
            image: "images/codemaster.jpg",
            description: "Spécialiste en développement logiciel.",
        },
        {
            name: "EcoTrade",
            category: "Economie",
            image: "images/ecotrade.jpg",
            description: "Plateforme d'échange économique durable.",
        },
        {
            name: "SolarTech",
            category: "Energie",
            image: "images/solartech.jpg",
            description: "Énergie solaire pour un avenir vert.",
        },
        {
            name: "NewsWorld",
            category: "Media",
            image: "images/newsworld.jpg",
            description: "L'actualité mondiale à portée de main.",
        },
        {
            name: "GreenEarth",
            category: "Association",
            image: "images/greenearth.jpg",
            description: "Protégeons notre planète ensemble.",
        },
        {
            name: "ChicStyle",
            category: "Mode",
            image: "images/chicstyle.jpg",
            description: "La mode à son meilleur.",
        },
    ];

    // Afficher toutes les entreprises au chargement de la page
    displayCompanies(companies);

    // Gestion des clics sur les boutons de catégorie
    categoryButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // Retirer la classe "active" de tous les boutons
            categoryButtons.forEach((btn) => btn.classList.remove("active"));
            // Ajouter la classe "active" au bouton cliqué
            this.classList.add("active");

            // Filtrer les entreprises par catégorie
            const category = this.getAttribute("data-category");
            const filteredCompanies =
                category === "all"
                    ? companies
                    : companies.filter((company) => company.category === category);

            // Afficher les entreprises filtrées
            displayCompanies(filteredCompanies);
        });
    });

    // Fonction pour afficher les entreprises
    function displayCompanies(companies) {
        menuItems.innerHTML = ""; // Vider le contenu actuel
    
        // Limiter l'affichage aux 10 premières entreprises
        const companiesToShow = companies.slice(0, 12);
    
        companiesToShow.forEach((company) => {
            const card = `
                <div class="company-card">
                    <img src="${company.image}" alt="${company.name}">
                    <h3>${company.name}</h3>
                    <p>${company.description}</p>
                    <span class="category">${company.category}</span>
                </div>
            `;
            menuItems.insertAdjacentHTML("beforeend", card);
        });
    }
});