/* MENU BURGER */
document.addEventListener("DOMContentLoaded", function () {
    const burgerMenuButton = document.querySelector(".burger-menu-button");
    const burgerMenuButtonIcon = document.querySelector(".burger-menu-button i");
    const burgerMenu = document.querySelector(".burger-menu");

    burgerMenuButton.onclick = function () {
        burgerMenu.classList.toggle("active"); // Remplace "open" par "active"
        const isActive = burgerMenu.classList.contains("active"); // Remplace "open" par "active"
        burgerMenuButtonIcon.classList = isActive ? "fa-solid fa-xmark" : "fa-solid fa-bars";
    };

    document.addEventListener("click", function (event) {
        if (!burgerMenu.contains(event.target) && !burgerMenuButton.contains(event.target)) {
            burgerMenu.classList.remove("active"); // Remplace "open" par "active"
            burgerMenuButtonIcon.classList = "fa-solid fa-bars"; // Réinitialise l'icône
        }
    });
});