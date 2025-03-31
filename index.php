<?php

// Inclut l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\DirController;
use App\Controllers\AuthentificationController;
use App\Controllers\OfferController;
use App\Controllers\CompanyController;

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
$controllerauth = new AuthentificationController($twig);
$controlleroffer = new OfferController($twig);
$controllercompany = new CompanyController($twig);


switch ($uri) {
    case '/':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->homePage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controllerauth->login(); 
        } else {
            session_start();
            if (isset($_SESSION['user'])) {
                $controller->loginPage();
                exit;
            } else {
                $controller->homePage();
            }
        }
        break;
        
    case '/about':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->aboutPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/cgu':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->cguPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/contact':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->contactPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/cookies-policy':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->cookiesPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/legal-notices':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->legalNoticesPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/privacy-policy':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->privacyPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case '/search':
        session_start();
        if (isset($_SESSION['user'])) {
            // if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controlleroffer->search(); 
            // } else {
            //     $controller->searchOfferPage();
            // }
        } else {
            $controller->loginPage();
        }
        break;
        
        case '/search-company':
            session_start();
            if (isset($_SESSION['user'])) {
                // if ($_SERVER['REQUEST_METHOD'] === 'GET'){
                    $controllercompany->search(); 
                // } else {
                //     $controller->searchCompanyPage();
                // }
        } else {
            $controller->loginPage();
        }
        break;

        case '/account':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->accountPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

        case '/logout': 
            session_start();
            session_destroy(); 
            header('Location: /login'); 
            exit;

    default:
        echo '404 Not Found';
        break;
}

// $template = $twig->load('home.html.twig'); à mettre dans les fonctions du controlleur
// echo $template->render(); // pareil