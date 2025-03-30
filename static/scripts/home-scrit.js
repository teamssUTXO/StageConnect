document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.getElementById("menu-items");
    const categoryButtons = document.querySelectorAll(".category-button");

    displayCompanies(companies);

    categoryButtons.forEach((button) => {
        button.addEventListener("click", function () {
            categoryButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");

            const category = this.getAttribute("data-category");

            const filteredCompanies = category === "all"
                ? companies
                : companies.filter(company => company.sector === category);

            if (filteredCompanies.length === 0) {
                menuItems.innerText = "Aucune entreprise trouvée.";
            } else {
                 displayCompanies(filteredCompanies);
            }
                
        });
    });

    // Affichage des entreprises
    function displayCompanies(list) {
        menuItems.innerHTML = "";

        list.slice(0, 6).forEach(company => {
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
