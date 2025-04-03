<?php 
namespace App\Controllers;

use App\Models\UserModel;

class AuthentificationController extends Controller {

    protected $templateEngine;
    protected $userModel;

    public function __construct($templateEngine) {
      $this->templateEngine = $templateEngine;
      $this->userModel = new UserModel();
    }

    public function login() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $mail = $_POST['mail'] ?? '';
          $password = $_POST['password'] ?? '';
          
          $user = $this->userModel->getUserByEmail($mail);
          
          if ($user && $password=== $user->password) { // if ($user && password_verify($password, $user->password)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
              $_SESSION['user'] = $user;

              header('Location: /');
          } else {
              echo $this->templateEngine->render('pages/login.html.twig', [
                'error' => 'Email ou mot de passe incorrect.'
              ]);
          }
      } else {
          echo $this->templateEngine->render('pages/login.html.twig');
      }
    }

    public function logout() {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      session_destroy();
      header('Location: /login');
      exit();
    }
}
