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

$segments = explode('/', trim($uri, '/'));

$controller = new DirController($twig);
$controllerauth = new AuthentificationController($twig);
$controlleroffer = new OfferController($twig);
$controllercompany = new CompanyController($twig);

// echo $segments[0];
// echo $segments[1];

switch ($segments[0]) {
    case '':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->homePage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controllerauth->login(); 
        } else {
            session_start();
            if (isset($_SESSION['user'])) {
                $controller->homePage();
                exit;
            } else {
                $controller->loginPage();
            }
        }
        break;
        
    case 'about':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->aboutPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'cgu':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->cguPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'contact':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->contactPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'cookies-policy':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->cookiesPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'legal-notices':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->legalNoticesPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'privacy-policy':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->privacyPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'search':
        session_start();
        if (isset($_SESSION['user'])) {
            $controlleroffer->search(); 
        } else {
            $controller->loginPage();
        }
        break;
        
    case 'search-company':
        session_start();
        if (isset($_SESSION['user'])) {
            $controllercompany->search(); 
        } else {
            $controller->loginPage();
        }
        break;
    
    case 'company':
        session_start();
        if (isset($_SESSION['user'])) {
            if (isset($segments[1])) {
                $controllercompany->company($segments[1]);
                exit;
            } else {
                echo '404 Not Found';
            }
        } else {
            $controller->loginPage();
        }

    case 'account':
        session_start();
        if (isset($_SESSION['user'])) {
            $controller->accountPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'logout': 
        session_start();
        session_destroy(); 
        header('Location: /login'); 
        exit;

        case 'candidacy':
            session_start();
            if (isset($_SESSION['user'])) {
                $controlleroffer->candidate();
                exit;
            } else {
                $controller->loginPage();
            }

    default:
        echo '404 Not Found';
        break;
}