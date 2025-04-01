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

    document.getElementById('sort-by').addEventListener('change', function () {
        const selectedValue = this.value;
    
        if (selectedValue === 'offer') {
            console.log("je");
            window.location.href = '/search';
        } else if (selectedValue === 'company') {
            console.log("suis");
            window.location.href = '/search-company';
        }
    });
});


