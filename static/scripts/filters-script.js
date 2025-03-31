document.addEventListener("DOMContentLoaded", function () {
    const resetButton = document.querySelector(".reset-filters");

    resetButton.addEventListener("click", function () {

        const selects = document.querySelectorAll(".filters select");
        selects.forEach(select => {
            select.selectedIndex = 0;
        });

        // Réinitialise les champs input si tu en ajoutes
        const inputs = document.querySelectorAll(".filters input");
        inputs.forEach(input => {
            input.value = "";
        });
    });
});
