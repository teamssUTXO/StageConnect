// Gestion du système d'évaluation
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll('.rating-stars-input .star');
    const ratingInput = document.createElement('input');
    ratingInput.type = 'hidden';
    ratingInput.name = 'rating';
    // document.getElementById('rating-form').appendChild(ratingInput);
    const valueStars = document.getElementById("rating-stars-value");

    stars.forEach(star => {
        star.addEventListener('click', () => {
            v = star.getAttribute('data-value');
            const value = parseInt(v); 
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

            valueStars.innerHTML = v + ".0 / 5.0";
        });
    });    

});