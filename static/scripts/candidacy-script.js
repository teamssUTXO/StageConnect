/* COMPTAGE DES CARACTERES DANS TEXTAREA "MESSAGE AU RECRUTEUR */
const textarea = document.getElementById('messageTextarea');
const charCountDisplay = document.getElementById('charCount');
const maxLength = 200;

textarea.addEventListener('input', () => {
    const currentLength = textarea.value.length;
    const remainingChars = maxLength - currentLength;

    // Mettre à jour l'affichage du nombre de caractères restants
    charCountDisplay.textContent = `${remainingChars} caractères restants`;

    // Changer la couleur du texte si la limite est atteinte
    if (remainingChars <= 0) {
        charCountDisplay.style.color = 'red';
    } else {
        charCountDisplay.style.color = 'inherit'; // Réinitialiser la couleur
    }
});

/* AFFICHAGE DE LA POP UP APRES POSTULATION */

const applyButton = document.getElementById('applyButton');
const popup = document.getElementById('popup');

applyButton.addEventListener('click', () => {
    // Afficher la popup
    popup.classList.add('show');

    // Masquer la popup après 2 secondes
    setTimeout(() => {
        popup.classList.remove('show');
    }, 2000); // 2 secondes
    
    setTimeout(() => {
        window.location.href="home.html";
    }, 2000); // 2 secondes

    
    
});