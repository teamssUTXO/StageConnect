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
        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $password = $_POST['password'];
        $Id_Prom = $_POST['Id_Prom'];
        $Id_Role = $_POST['Id_Role'];

        if ($Id_Role == 1) {
            $role = "étudiant";
        } elseif ($Id_Role == 2) {
            $role = "pilote";
        } else {
            echo "Rôle non valide.";
            return;
        }

        $user = $this->userModel->createUser($email, $name, $surname, $password, $Id_Prom, $Id_Role);
        if ($user) {
            echo "$role créé avec succès.";
        } else {
            echo "$role non créé.";
        }
    }

    public function updateUser() {
        var_dump($_POST);
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
            echo "Utilisateur modifié avec succès.";
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