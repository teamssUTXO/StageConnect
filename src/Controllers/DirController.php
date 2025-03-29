<?php 
namespace App\Controllers;

use App\Models\CorporationModel;

class DirController extends Controller {

    protected $modelcorporation = null;

    public function __construct($templateEngine) { 
        $this->modelcorporation = new CorporationModel();
        $this->templateEngine = $templateEngine;
    }

    public function homePage() {
        // $entreprises = $this->model->getEntreprises();
        
        // $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

        // $filteredCompanies = $selectedCategory === 'all' ? $entreprises : array_filter($entreprises, function($entreprise) use ($selectedCategory) {
        //     return $entreprise['secteur'] === $selectedCategory;
        // });

        // $filteredCompanies = array_slice($filteredCompanies, 0, 12);

        // Passer les données à Twig
        // echo $this->templateEngine->render('home.html.twig', [
        //     'entreprises' => $filteredCompanies,
        //     'selectedCategory' => $selectedCategory
        // ]);

        $user = $_SESSION['user'] ?? null;

        $companies = $this->modelcorporation->getAll();
        
        echo $this->templateEngine->render("pages/home.html.twig", [
            "user"=> $user,
            "companies" => $companies
        ]);
    }   

    public function loginPage() {
        echo $this->templateEngine->render('pages/login.html.twig');
    }  

    public function aboutPage() {
        echo $this->templateEngine->render('pages/about.html.twig');
    }

    public function cguPage() {
        echo $this->templateEngine->render('pages/cgu.html.twig');
    }

    public function contactPage() {
        echo $this->templateEngine->render('pages/contact.html.twig');
    }

    public function cookiesPolicyPage() {
        echo $this->templateEngine->render('pages/cookies-policy.html.twig');
    }

    public function legalNoticesPage() {
        echo $this->templateEngine->render('pages/legal-notices.html.twig');
    }

    public function privacyPolicyPage() {
        echo $this->templateEngine->render('pages/privacy-policy.html.twig');
    }


    public function searchOfferPage() {
        echo $this->templateEngine->render('pages/search-offer.html.twig');
    }

    public function searchCompanyPage() {
        echo $this->templateEngine->render('pages/search-company.html.twig');
    }

    public function accountPage() {
        echo $this->templateEngine->render('pages/user.html.twig');
    }


    // public function offerPage() {
    //     echo $this->templateEngine->render('offres.html.twig');
    // }

    // public function uploadPage() {
    //     $result = ['success' => null, 'message' => ''];

    //     if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //         $uploadService = new UploadService();
    //         $result = $uploadService->handleUpload($_FILES['upfile'] ?? []);
    //     }

    //     echo $this->templateEngine->render('upload.html.twig', [
    //         'uploadSuccess' => $result['success'],
    //         'errorMessage' => $result['message']
    //     ]);
    // }
}


// $itemsPerPage = 10;
// $totalItems = count($entreprises);
// $totalPages = ceil($totalItems / $itemsPerPage);
// $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
// $startIndex = ($page - 1) * $itemsPerPage;
// $currentItems = array_slice($entreprises, $startIndex, $itemsPerPage);

// echo $this->templateEngine->render('index.html.twig', [
//     'entreprises' => $currentItems,
//     'page' => $page,
//     'totalPages' => $totalPages
// ]);