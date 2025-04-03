<?php
namespace App\Models;
use App\Models\Model;

class WishlistModel extends Model {

    protected $table = "Wishlist";
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function isInWishlist($userId, $offerId) {
        $result = $this->connexion->select($this->table, [
            "Id_Users" => $userId,
            "Id_Offer" => $offerId
        ]);
        return !empty($result);
    }

    // Ajoute une offre dans la wishlist
    public function addToWishlist($userId, $offerId) {
        return $this->connexion->insert($this->table, [
            "Id_Users" => $userId,
            "Id_Offer" => $offerId
        ]);
    }

    // Retire une offre de la wishlist
    public function removeFromWishlist($userId, $offerId) {
        return $this->connexion->delete($this->table, [
            "Id_Users" => $userId,
            "Id_Offer" => $offerId
        ]);
    }

    // Bascule l'état de la wishlist (toggle)
    public function toggleWishlist($userId, $offerId) {
      if ($this->isInWishlist($userId, $offerId)) {
          $result = $this->removeFromWishlist($userId, $offerId);
          error_log("Retrait de l'offre $offerId de la wishlist de l'utilisateur $userId. Résultat: " . var_export($result, true));
          return false;
      } else {
          $result = $this->addToWishlist($userId, $offerId);
          error_log("Ajout de l'offre $offerId à la wishlist de l'utilisateur $userId. Résultat: " . var_export($result, true));
          return true;
      }
    }

    public function getWishlistForUser($userId) {
  
      $results = $this->connexion->selectJoin($this->table, "JOIN Offer o ON w.Id_Offer = o.Id_Offer",["Id_Users" => $userId]);

      $wishlistOffers = [];
      
      foreach ($results as $row) {
        $wishlistOffers[] = is_object($row) ? $row->Id_Offer : $row['Id_Offer'];
      }
      return $wishlistOffers;
    }
}