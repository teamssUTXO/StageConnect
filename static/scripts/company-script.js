// Gestion du système d'évaluation
const stars = document.querySelectorAll('.rating-stars-input .star');
const ratingInput = document.createElement('input');
ratingInput.type = 'hidden';
ratingInput.name = 'rating';
document.getElementById('rating-form').appendChild(ratingInput);

stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        ratingInput.value = value;

        stars.forEach((s, index) => {
            if (index < value) {
                s.classList.add('active');
                s.innerHTML = '<i class="fas fa-star"></i>';
            } else {
                s.classList.remove('active');
                s.innerHTML = '<i class="far fa-star"></i>';
            }
        });
    });
});

// Gestion de la soumission du formulaire
document.getElementById('rating-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const rating = ratingInput.value;
    const reviewText = document.getElementById('review-text').value;

    if (!rating || !reviewText) {
        alert('Veuillez donner une note et écrire un avis.');
        return;
    }

    // Envoyer les données au serveur (à implémenter)
    console.log('Note :', rating);
    console.log('Avis :', reviewText);

    // Réinitialiser le formulaire
    document.getElementById('rating-form').reset();
    stars.forEach(star => {
        star.classList.remove('active');
        star.innerHTML = '<i class="far fa-star"></i>';
    });
    alert('Merci pour votre avis !');
});