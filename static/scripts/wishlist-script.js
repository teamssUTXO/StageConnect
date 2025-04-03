// document.addEventListener('DOMContentLoaded', function() {
//   console.log("Script wishlist.js chargé");
//   const favIcons = document.querySelectorAll('.favorite-icon');
//   favIcons.forEach(icon => {
//       icon.addEventListener('click', function() {
//           const offerId = this.getAttribute('data-offer');
//           // Envoi d'une requête POST vers le contrôleur de la wishlist
//           fetch(`/wishlist/toggle/${offerId}`, {
//               method: 'POST',
//               headers: {
//                   'Content-Type': 'application/json'
//               }
//           })
//           .then(response => response.text())
//           .then(text => {
//               console.log("Réponse textuelle:", text);
//               try {
//                   const data = JSON.parse(text);
//                   console.log("Données JSON:", data);
//                   if (data.error) {
//                       alert(data.error);
//                   } else {
//                       if (data.inWishlist) {
//                           this.classList.remove('far');
//                           this.classList.add('fas');
//                       } else {
//                           this.classList.remove('fas');
//                           this.classList.add('far');
//                       }
//                   }
//               } catch (e) {
//                   console.error("Erreur lors du parsing JSON :", e);
//               }
//           })
//           .catch(error => {
//               console.error('Erreur lors de la requête fetch :', error);
//           });
//       });
//   });
// });
