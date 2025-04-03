<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends Controller {

    protected $templateEngine;
    protected $userModel;

    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
        $this->userModel = new UserModel();
    }

    public function createUser() {
        $email = $_POST['email'] ?? null;
        $name = $_POST['name'] ?? null;
        $surname = $_POST['surname'] ?? null;
        $password = $_POST['password'] ?? null;
        $Id_Prom = $_POST['Id_Prom'] ?? null;
        $Id_Role = $_POST['Id_Role'] ?? null;
    
        if (!$email || !$name || !$surname || !$password || !$Id_Prom || !$Id_Role) {
            echo "Données manquantes.";
            return;
        }
    
        $passwordHash = password_hash($password, PASSWORD_BCRYPT); // Hachez le mot de passe
        $user = $this->userModel->createUser($email, $passwordHash, $name, $surname, $Id_Prom, $Id_Role);
    
        if ($user) {
            // Redirigez immédiatement après la création
            header("Location: /account");
            exit; // Assurez-vous que le script s'arrête après la redirection
        } else {
            echo "Échec de la création de l'utilisateur.";
        }
    }

    public function updateUser() {
        $Id_User = $_POST['Id_User'] ?? null;
        $email = $_POST['email'] ?? null;
        $name = $_POST['name'] ?? null;
        $surname = $_POST['surname'] ?? null;
        $password = $_POST['password'] ?? null; // Nouveau mot de passe (peut être vide)
        $Id_Prom = $_POST['Id_Prom'] ?? null;
        $Id_Role = $_POST['Id_Role'] ?? null;
    
        if (!$Id_User || !$email || !$name || !$surname || !$Id_Prom || !$Id_Role) {
            echo "Données manquantes.";
            return;
        }
    
        // Appelez la méthode du modèle pour mettre à jour l'utilisateur
        $user = $this->userModel->updateUser($email, $password, $name, $surname, $Id_Prom, $Id_Role, $Id_User);
    
        if ($user) {
            // Redirigez immédiatement après la mise à jour
            header("Location: /account");
            exit; // Assurez-vous que le script s'arrête après la redirection
        } else {
            echo "Échec de la modification de l'utilisateur.";
        }
    }

    public function listUsers() {
        return $this->userModel->getAllStudents();
    }

    public function listTutor(){
        return $this->userModel->getAllTutor();
    }

}