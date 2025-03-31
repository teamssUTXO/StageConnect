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

    $search = [$_GET['q'] ?? null, $_GET['l'] ?? null, $_GET['s'] ?? null, $_GET['t'] ?? null];

    $currentPage = $_GET['page'] ?? 1;
    $companiesPerPage = 10; 
    $offset = ($currentPage - 1) * $companiesPerPage;

    if ($search[0] || $search[1] || $search[2] || $search[3]) {
        // on cherche les entreprises correspondant au mot-clé
        $company = $this->corporationModel->searchcorporation($search);

    } else {
        // si rien dans bdd, on récupère toutes les offres (ou rien)
        $company = $this->corporationModel->getAll();
    }

    $totalCompanies = count($company);
    $totalPages = ceil($totalCompanies / $companiesPerPage); 

    $companiesOnPage = array_slice($company, $offset, $companiesPerPage);

    echo $this->templateEngine->render('pages/search-company.html.twig', [
      'user' => $user,
      'name' => $search,
      'search' => $search ?? [],
      'count' => $company ? count($company) : 0,
      'companies' => $companiesOnPage,  // on passe les entreprises qui doivent être affichées sur la page
      'currentPage' => $currentPage,
      'totalPages' => $totalPages  
    ]);
  }
}