<?php

// Inclut l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\DirController;

$host = 'db'; 
$dbname = 'stageconnectbdd'; 
$username = 'root'; 
$password = 'root123'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

} catch (PDOException $e ){
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}

// Charge Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$uri = str_replace('/index.php', '', $uri);
if ($uri == '' || $uri == '/') {
    $uri = '/';
}

$controller = new DirController($twig);

switch ($uri) {
    case '/':
        $controller->loginPage();
        break;
    // case '/about':
    //     $controller->aboutPage();
    //     break;
    // case '/candidacy':
    //     $controller->candidacyPage();
    //     break;
    // case '/cgu':
    //     $controller->cguPage();
    //     break;
    // case '/company':
    //     $controller->companyPage();
    //     break;
    // case '/contact':
    //     $controller->contactPage();
    //     break;
    // case '/cookies-policy':
    //     $controller->cookiesPolicyPage();
    //     break;
    // case '/legal-notices':
    //     $controller->legalNoticesPage();
    //     break;
    // case '/login':
    //     $controller->loginPage();
    //     break;
    // case '/privacy-policy':
    //     $controller->privacyPolicyPage();
    //     break;
    // case '/search':
    //     $controller->searchOfferPage(); // Ca doit rediriger vers la page avec l'uri search-offer
    //     break;
    // case '/search-offer':
    //     $controller->searchCompanyPage(); 
    //     break;
    // case '/account':
    //     $controller->accountPage();
    //     break;
    // case '/legal-notices':
    //     $controller->legalNoticesPage();
    //     break;

    default:
        echo '404 Not Found';
        break;
}

// $template = $twig->load('home.html.twig'); à mettre dans les fonctions du controlleur
// echo $template->render(); // pareil