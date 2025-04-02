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

    
    public function createUser(string $email, string $password, string $name, string $surname = "", int $Id_Role = 1, int $Id_Prom = 1): bool {
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

    public function updateUser(string $email, string $password, string $name, string $surname, $Id_Prom , $Id_Role, $Id_User){
        $data = [
            'name' => $name,
            'surname' => $surname,
            'mail' => $email,
            'password' => $password,
            'Id_Promotion' => $Id_Prom,
            'Id_Role' => $Id_Role
        ];
        $condition = [
            'Id_Users' => $Id_User
        ];
        return $this->connexion->update($this->table, $data, $condition);
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