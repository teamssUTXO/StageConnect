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
}