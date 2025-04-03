<?php 
namespace App\Controllers;

use App\Models\OfferModel;
use App\Models\WishlistModel;

class OfferController extends Controller {

  protected $templateEngine;
  protected $offerModel;
  protected $wishlistModel;

  public function __construct($templateEngine) {
    $this->templateEngine = $templateEngine;
    $this->offerModel = new OfferModel();
    $this->wishlistModel = new WishlistModel();
  }

  public function search() {
    $user = $_SESSION['user'] ?? null;

    $search = [$_GET['q'] ?? null, $_GET['l'] ?? null, $_GET['s'] ?? null, $_GET['t'] ?? null, $_GET['n'] ?? null];
    // recherche, localisation, secteur, type de stage, niveau d'études

    $currentPage = $_GET['page'] ?? 1;
    $offersPerPage = 10; 
    $offset = ($currentPage - 1) * $offersPerPage;

    if ($search[0] || $search[1] || $search[2] || $search[3] || $search[4]) {
      // recherche avec les filtres
      $offers = $this->offerModel->searchoffer($search);

    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $offers = $this->offerModel->getAll(); // recherche toutes les offres
    }

    $totalOffers = count($offers);
    $totalPages = ceil($totalOffers / $offersPerPage); 

    $offersOnPage = array_slice($offers, $offset, $offersPerPage);

    $wishlistOffers = $this->wishlistModel->getWishlistForUser($user->Id_Users);

    echo $this->templateEngine->render('pages/search-offer.html.twig', [
      'user' => $user,
      'search' => $search ?? [],
      'count' => $offers ? count($offers) : 0,
      'offers' => $offersOnPage,
      'wishlist' => $wishlistOffers,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
    ]);
  }

  public function candidate($id){
    $user = $_SESSION['user'] ?? null;
    $popup = $_SESSION['flash'] ?? null;

    $offer = $this->offerModel->offerCorporation($id);

    echo $this->templateEngine->render('pages/candidacy.html.twig', [
      'user'=> $user,
      'flash' => $popup,
      'offer'=> $offer,
    ]);
  }
  public function updateOffer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $offerId = $_POST['Id_Offer'];
        
        $offerData = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'competence' => $_POST['competence'],
            'remuneration' => $_POST['remuneration'],
            'typeoffer' => $_POST['typeoffer'],
            'studieslevel' => $_POST['studieslevel'],
            'duration' => $_POST['duration'],
            'Siret' => $_POST['Siret']
        ];
        
        $success = $this->offerModel->updateOffer($offerId, $offerData);
        
        if ($success) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Offre mise à jour avec succès.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur lors de la mise à jour de l\'offre.'];
        }
        
        header('Location: /account');
        exit;
    }
    
    header('Location: /user');
    exit;
}

public function createOffer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentDate = date('Y-m-d');
        
        $offerData = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'competence' => $_POST['competence'],
            'remuneration' => $_POST['remuneration'],
            'typeoffer' => $_POST['typeoffer'],
            'studieslevel' => $_POST['studieslevel'],
            'duration' => $_POST['duration'],
            'Siret' => $_POST['Siret'],
            'publication_date' => $currentDate,
            'candidate_nb' => 0
        ];
        
        $success = $this->offerModel->createOffer($offerData);
        
        if ($success) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Offre créée avec succès.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur lors de la création de l\'offre.'];
        }
        
        header('Location: /user');
        exit;
    }
    
    header('Location: /account');
    exit;
}

public function deleteOffer() {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['Id_Offer'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de l\'offre manquant']);
        exit;
    }
    
    $offerId = $data['Id_Offer'];
    $success = $this->offerModel->deleteOffer($offerId);
    
    if ($success) {
        http_response_code(200);
        echo json_encode(['success' => 'Offre supprimée avec succès']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la suppression de l\'offre']);
    }
    exit;
}
}