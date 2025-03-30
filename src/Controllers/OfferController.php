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

    $search = $_GET['q'] ?? null;

    if ($search) {
        // on cherche les entreprises correspondant au mot-clé
        $offers = $this->offerModel->searchoffer($search);
    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $offers = null;
    }

    echo $this->templateEngine->render('pages/search-offer.html.twig', [
      'user' => $user,
      'offers' => $offers,
      'search' => $search ?? '',
      'count' => $offers ? count($offers) : 0,
    ]);
  

  }


}