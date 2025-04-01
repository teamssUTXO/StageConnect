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

    $search = [$_GET['q'] ?? null, $_GET['l'] ?? null, $_GET['s'] ?? null, $_GET['d'] ?? null, $_GET['t'] ?? null, $_GET['n'] ?? null];
    // recherche, localisation, secteur, durée, type de stage, niveau d'études

    $currentPage = $_GET['page'] ?? 1;
    $offersPerPage = 10; 
    $offset = ($currentPage - 1) * $offersPerPage;

    if ($search[0] || $search[1] || $search[2] || $search[3] || $search[4] || $search[5]) {
      // recherche avec les filtres
      $offers = $this->offerModel->searchoffer($search);

    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $offers = $this->offerModel->getAll(); // recherche toutes les offres
    }

    $totalOffers = count($offers);
    $totalPages = ceil($totalOffers / $offersPerPage); 

    $offersOnPage = array_slice($offers, $offset, $offersPerPage);

    echo $this->templateEngine->render('pages/search-offer.html.twig', [
      'user' => $user,
      'search' => $search ?? [],
      'count' => $offers ? count($offers) : 0,
      'offers' => $offersOnPage,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
    ]);
  }

  public function candidate(){
    $user = $_SESSION['user'] ?? null;
    echo $this->templateEngine->render('pages/candidacy.html.twig');

  }
}