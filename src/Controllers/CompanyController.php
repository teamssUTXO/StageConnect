<?php 
namespace App\Controllers;

use App\Models\CorporationModel;
use App\Models\WishlistModel;

class CompanyController extends Controller {

  protected $templateEngine;
  protected $corporationModel;
  protected $wishlistModel;

  public function __construct($templateEngine) {
    $this->templateEngine = $templateEngine;
    $this->corporationModel = new CorporationModel();
    $this->wishlistModel = new WishlistModel();
  }

  public function company($id) {
    $user = $_SESSION['user'] ?? null;

    $currentPage = $_GET['page'] ?? 1;
    $offersPerPage = 5;
    $offset = ($currentPage - 1) * $offersPerPage;

    $company = $this->corporationModel->getById($id);
  
    if ($company == []) {
      $_SESSION['flash'] = "Vous ne pouvez pas voir le descriptif de cette entreprise car elle ne possède pas d'offre";
      header("Location: /search-company");
    }
    
    $totalOffers = count($company);
    $totalPages = ceil($totalOffers / $offersPerPage);
    $offersOnPage = array_slice($company, $offset, $offersPerPage);

    

    echo $this->templateEngine->render("pages/company.html.twig", [
      'user' => $user,
      'company' => $company,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
    ]);
  }

  public function search() {
    $user = $_SESSION['user'] ?? null;

    $search = [$_GET['q'] ?? null, $_GET['l'] ?? null, $_GET['e'] ?? null, $_GET['s'] ?? null, $_GET['t'] ?? null];
    // recherche, localisation, evaluation, secteur, type

    $currentPage = $_GET['page'] ?? 1;
    $companiesPerPage = 10; 
    $offset = ($currentPage - 1) * $companiesPerPage;

    if ($search[0] || $search[1] || $search[2] || $search[3] || $search[4]) {
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
      'search' => $search ?? [],
      'count' => $company ? count($company) : 0,
      'companies' => $companiesOnPage,  // on passe les entreprises qui doivent être affichées sur la page
      'currentPage' => $currentPage,
      'totalPages' => $totalPages  
    ]);
  }

  public function listCompany() {
    return $this->corporationModel->getAll();
  }

  public function rating($siret) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $user = $_SESSION['user'] ?? null;

    $newRating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
    $newRating = round($newRating, 1);
    if ($newRating < 0.5 || $newRating > 5.5) {
        $_SESSION['flash'] = "La note doit être comprise entre 1 et 5.";
        header("Location: /company/{$siret}");
        exit();
    }

    $success = $this->corporationModel->updateRating($siret, $newRating);

    if ($success) {
        $_SESSION['flash'] = "Votre note a été enregistrée.";
    } else {
        $_SESSION['flash'] = "Erreur lors de l'enregistrement de votre note.";
    }

    header("Location: /company/{$siret}");
    exit();
  }

  public function updateCompany() {
    $Siret = $_POST['Siret'] ?? null;
    $name = $_POST['name'] ?? null;
    $mail = $_POST['mail'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $description = $_POST['description'] ?? null; 
    $intern = $_POST['intern'] ?? null;
    

    if (!$Siret || !$name || !$mail || !$phone || !$description) {
        echo "Données manquantes.";
        return;
    }

    // Appelez la méthode du modèle pour mettre à jour l'utilisateur
    $user = $this->corporationModel->updateCompany($Siret, $name, $mail, $phone, $description, $intern);

    if ($user) {
        // Redirigez immédiatement après la mise à jour
        header("Location: /account");
        exit; // Assurez-vous que le script s'arrête après la redirection
    } else {
        echo "Échec de la modification de l'utilisateur.";
    }
  }


  public function createCompany() {
    $Siret = $_POST['Siret'] ?? null;
    $name = $_POST['name'] ?? null;
    $mail = $_POST['mail'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $description = $_POST['description'] ?? null; 
    $grade = $_POST['grade'] ?? null;


    if (!$Siret || !$name || !$mail || !$phone || !$description || !$grade) {
      $_SESSION['flash'] = "Données manquantes.";
      return;
    }

    $user = $this->corporationModel->createCompany($Siret, $name, $mail, $phone, $description, $grade);
    if ($user) {
        // Redirigez immédiatement après la mise à jour
        header("Location: /account");
        exit; // Assurez-vous que le script s'arrête après la redirection
    } else {
        echo "Échec de la modification de l'entreprise.";
    }
  }
}