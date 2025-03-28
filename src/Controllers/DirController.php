<?php 
namespace App\Controllers;

use App\Models\CorporationModel;

class DirController extends Controller {

    public function __construct($templateEngine) {
        $this->model = new CorporationModel();
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
        
        echo $this->templateEngine->render("home.html.twig", [
            "user"=> $user
        ]);
    }   

    public function loginPage() {
        echo $this->templateEngine->render('login.html.twig');
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