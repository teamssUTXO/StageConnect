<?php 
namespace App\Controllers;

use App\Models\CorporationModel;

class CompanyController extends Controller {

  protected $templateEngine;
  protected $corporationModel;

  public function __construct($templateEngine) {
    $this->templateEngine = $templateEngine;
    $this->corporationModel = new CorporationModel();
  }

  public function search() {
    $user = $_SESSION['user'] ?? null;

    $search = $_GET['q'] ?? null;

    if ($search) {
        // on cherche les entreprises correspondant au mot-clé
        $company = $this->corporationModel->searchcorporation($search);
    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $company = $this->corporationModel->getAll();
    }

    echo $this->templateEngine->render('pages/search-company.html.twig', [
      'user' => $user,
      'companies' => $company,
      'name' => $search,
      'search' => $search ?? '',
      'count' => $company ? count($company) : 0,
    ]);
  

  }


}