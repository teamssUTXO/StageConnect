<?php 
namespace App\Controllers;

use App\Models\OfferModel;

class OfferController extends Controller {

  protected $templateEngine;
  protected $offerModel;

  public function __construct($templateEngine) {
    $this->templateEngine = $templateEngine;
    $this->offerModel = new OfferModel();
  }

  public function search() {
    $user = $_SESSION['user'] ?? null;

    $search = [$_GET['q'] ?? null, $_GET['l'] ?? null, $_GET['s'] ?? null, $_GET['e'] ?? null, $_GET['d'] ?? null, $_GET['t'] ?? null, $_GET['n'] ?? null];
    // recherche, localisation, secteur, evaluation, durée, type de stage, niveau d'études
    if ($search[0] || $search[1] || $search[2] || $search[3] || $search[4] || $search[5] || $search[6]) {
      // recherche avec les filtres
      $offers = $this->offerModel->searchoffer($search);

    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $offers = $this->offerModel->getAll(); // recherche toutes les offres
    }

    echo $this->templateEngine->render('pages/search-offer.html.twig', [
      'user' => $user,
      'offers' => $offers,
      'search' => $search ?? [],
      'count' => $offers ? count($offers) : 0
    ]);
  }
}