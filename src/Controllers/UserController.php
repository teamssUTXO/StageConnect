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

    public function listUsers() {
        return $this->userModel->getAllStudents();
    }

}