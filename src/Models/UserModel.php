<?php
namespace App\Models;
use App\Models\Model;

class UserModel extends Model {

    protected $table = "Users";
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getUserByEmail(string $mail): ? object {
        $result = $this->connexion->select($this->table, ['mail' => $mail]);
        return $result[0] ?? null;
    }
 
    public function verifyCredentials(string $email, string $password): bool {
        $user = $this->getUserByEmail($email);
        
        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password);
    }

    
    public function createUser(string $email, string $password, string $name, string $surname = "", $Id_Prom = 1 , $Id_Role = 1 ): bool {
        $data = [
            'name' => $name,
            'surname' => $surname,
            'mail' => $email,
            'password' => $password,
            'Id_Promotion' => $Id_Prom,
            'Id_Role' => $Id_Role
        ];
        return $this->connexion->insert($this->table, $data);
    }

    public function updateUser(string $email, ?string $password, string $name, string $surname, $Id_Prom, $Id_Role, $Id_User) {
        // Préparez les données à mettre à jour
        $data = [
            'name' => $name,
            'surname' => $surname,
            'mail' => $email,
            'Id_Promotion' => $Id_Prom,
            'Id_Role' => $Id_Role
        ];
    
        // Si un nouveau mot de passe est fourni, ajoutez-le aux données
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT); // Hachez le mot de passe
        }
    
        // Condition pour identifier l'utilisateur
        $condition = [
            'Id_Users' => $Id_User
        ];
    
        // Exécutez la mise à jour
        return $this->connexion->update($this->table, $data, $condition);
    }

    public function deleteUser($Id_User): bool {
        if (empty($Id_User)) {
            error_log("L'ID utilisateur est manquant pour la suppression.");
            return false;
        }
    
        try {
            // Supprimez les enregistrements associés dans la table Candidate
            $this->connexion->delete('Candidate', ['Id_Users' => $Id_User]);
    
            // Supprimez les enregistrements associés dans la table Wishlist
            $this->connexion->delete('Wishlist', ['Id_Users' => $Id_User]);
    
            // Supprimez l'utilisateur dans la table Users
            $condition = ['Id_Users' => $Id_User];
            $result = $this->connexion->delete($this->table, $condition);
    
            error_log("Résultat de la suppression de l'utilisateur : " . ($result ? "succès" : "échec"));
            return $result;
        } catch (\Exception $e) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public function getAllStudents(): array {
        $condition = ['Id_Role' => 1];
        $students = $this->connexion->select($this->table, $condition);

        if (empty($students)) {
            error_log("No students found in the database.");
        }
        return $students;
    }

    public function getAllTutor(): array {
        $condition = ['Id_Role' => 2];
        $tutor = $this->connexion->select($this->table, $condition);

        if (empty($tutor)) {
            error_log("No tutor found in the database.");
        }
        return $tutor;
    }



































    // public function deleteUser($condition){
    //     return $this->pdo->delete
    // }


    // public function updatePassword(int $userId, string $newPassword): bool {
    //     return $this->connexion->update(
    //         $this->table,
    //         ['password' => password_hash($newPassword)],
    //         ['id' => $userId]
    //     );
    // }

     
    // public function verifyCredentials(string $email, string $password): bool {
    //     $user = $this->getUserByEmail($email);
        
    //     if (!$user) {
    //         return false;
    //     }

    //     return password_verify($password, $user->password);
    // }
}