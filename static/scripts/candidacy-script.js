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

// Pop-up
const popup = document.getElementById('popup');
if (popup) {
    popup.style.display = 'block';
    setTimeout(() => {
        popup.style.display = 'none';
    }, 4000); // 4 secondes
}