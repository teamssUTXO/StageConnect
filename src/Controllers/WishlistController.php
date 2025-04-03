<?php
namespace App\Controllers;

use App\Models\WishlistModel;

class WishlistController extends Controller {

    protected $templateEngine;
    protected $wishlistModel;

    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
        $this->wishlistModel = new WishlistModel();
    }

    public function toggle($offerId) {
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
      $user = $_SESSION['user'] ?? null;

      $userId = $user->Id_Users;

      $this->wishlistModel->toggleWishlist($userId, $offerId);


      // redirection vers la page précédente
      $referer = $_SERVER['HTTP_REFERER'] ?? null;

      if ($referer) {
          $redirectUrl = $referer;
      } else {
          $redirectUrl = '/';
      }

      header("Location: $redirectUrl");
      exit();
    }
  }