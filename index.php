<?php

// Inclut l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\DirController;
use App\Controllers\AuthentificationController;
use App\Controllers\OfferController;
use App\Controllers\CompanyController;
use App\Controllers\CandidateController;
use App\Controllers\WishlistController;
use \App\Controllers\UserController;

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
session_start();
$twig->addGlobal('session', $_SESSION); // ajoute la session comme variable global dans tous les templates twig

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
$controllercandidate = new CandidateController($twig);
$controlleruser = new UserController($twig);
$controllerwishlist = new WishlistController($twig);

switch ($segments[0]) {
    case '':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->homePage();
            if (isset($_SESSION['flash'])) {
                unset($_SESSION['flash']);
            }
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controllerauth->login(); 
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user'])) {
                $controller->homePage();
                exit;
            } else {
                $controller->loginPage();
            }
        }
        break;
        
    case 'about':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->aboutPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'cgu':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->cguPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'contact':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->contactPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'cookies-policy':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->cookiesPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'legal-notices':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->legalNoticesPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'privacy-policy':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->privacyPolicyPage();
            exit;
        } else {
            $controller->loginPage();
        }
        break;
    
    case 'wishlist':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }

        if (isset($_SESSION['user'])) {
            if (count($segments) === 3 && $segments[0] === 'wishlist' && $segments[1] === 'toggle' && is_numeric($segments[2])) {
                $offerId = $segments[2];
                $controllerwishlist->toggle($offerId);
                if (isset($_SESSION['flash'])) {
                    unset($_SESSION['flash']);
                }
                exit();
            }
        } else {
            $controller->loginPage();
        }

    case 'search':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controlleroffer->search(); 
            exit;
        } else {
            $controller->loginPage();
        }
        break;
        
    case 'search-company':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controllercompany->search(); 
            if (isset($_SESSION['flash'])) {
                unset($_SESSION['flash']);
            }
            exit;
        } else {
            $controller->loginPage();
        }
        break;
    
    case 'company':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            if (isset($segments[1])) {
                $controllercompany->company($segments[1]);
                if (isset($_SESSION['flash'])) {
                    unset($_SESSION['flash']);
                }
                exit;
            } else {
                echo '404 Not Found';
                exit;
            }
        } else {
            $controller->loginPage();
        }
        break;

    case 'account':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $controller->renderPagesAccount();
            exit;
        } else {
            $controller->loginPage();
        }
        break;

    case 'logout': 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy(); 
        header('Location: /login'); 
        exit;

    case 'candidacy':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controllercandidate->candidacy($segments[1]); 
                if (isset($_SESSION['flash'])) {
                    unset($_SESSION['flash']);
                }
                exit;
            } elseif (isset($segments[1])) {
                $controlleroffer->candidate($segments[1]);
                if (isset($_SESSION['flash'])) {
                    unset($_SESSION['flash']);
                }
                exit;
            } else {
                echo '404 Not Found';
                exit;
            }
        } else {
            $controller->loginPage();
        }
        break;

    case 'updateUser':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlleruser->updateUser();
        } else {
            echo 'Méthode non autorisée.';
        }
        break;

    case 'createUser':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlleruser->createUser(); // Appelle la méthode createUser du contrôleur
        } else {
            echo 'Méthode non autorisée.';
        }
        break;

    case 'deleteUser':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $controlleruser->deleteUser(); // Appelle la méthode deleteUser du contrôleur
        } else {
            echo 'Méthode non autorisée.';
            http_response_code(405); // Méthode non autorisée
        }
        break;

    case 'rating':
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($segments[1])) {
                $siret = $segments[1];
            
                $controllercompany->rating($siret);
                exit();
            } else {
                echo '404 Not Found';
            }
        } else {
            $controller->loginPage();
        }
        break;

    case 'updateCompany':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controllercompany->updateCompany();
        } else {
            echo 'Méthode non autorisée.';
        }
        break;


    case 'createCompany':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controllercompany->createCompany(); // Appelle la méthode createCompany du contrôleur
        } else {
            echo 'Méthode non autorisée.';
        }
        break;

    case 'deleteCompany':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $controllercompany->deleteCompany(); // Appelle la méthode deleteCompany du contrôleur
        } else {
            echo 'Méthode non autorisée.';
            http_response_code(405); // Méthode non autorisée
        }
        break;
    
    case 'updateOffer' : 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlleroffer->updateOffer();
        } else {
            echo 'Méthode non autorisée.';
        }
        break;
    case 'createOffer' : 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlleroffer->createOffer(); // Appelle la méthode createCompany du contrôleur
        } else {
            echo 'Méthode non autorisée.';
        }
        break;
    case 'deleteOffer':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        if ($user->Id_Role == 2 || $user->Id_Role == 1) {
            $_SESSION['flash'] = "Vous ne pouvez pas ajouter une offre dans votre wishlist.";
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $controlleroffer->deleteOffer(); // Appelle la méthode deleteCompany du contrôleur
        } else {
            echo 'Méthode non autorisée.';
            http_response_code(405); // Méthode non autorisée
        }
        break;

    default:
        echo '404 Not Found';
        break;
}