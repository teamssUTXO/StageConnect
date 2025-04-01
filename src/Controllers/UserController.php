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

    public function UpdateUser() { 

        $user = $_SESSION['user'] ?? null;
        $id = $_GET['id'] ?? null;
        $role = $_GET['role'] ?? null;
        $newPassword = $_POST['password'] ?? null;

        if ($user) {
            if ($this->userModel->updatePassword($id, $newPassword)) {
                echo $this->templateEngine->render('pages/user.html.twig', [
                    'user' => $user,
                    'message' => 'Le mot de passe a été mis à jour avec succès.'
                ]);
            } else {
                echo $this->templateEngine->render('pages/user.html.twig', [
                    'user' => $user,
                    'message' => 'Erreur lors de la mise à jour du mot de passe.'
                ]);
            }
        }
    }

}




