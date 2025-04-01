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

 
    // public function verifyCredentials(string $email, string $password): bool {
    //     $user = $this->getUserByEmail($email);
        
    //     if (!$user) {
    //         return false;
    //     }

    //     return password_verify($password, $user->password);
    // }

    
    // public function createUser(string $email, string $password, array $additionalData = []): bool {
    //     $data = array_merge($additionalData, [
    //         'email' => $email,
    //         'password' => password_hash($password),
    //         'created_at' => date('Y-m-d H:i:s')
    //     ]);

    //     return $this->connexion->create($this->table, $data);
    // }


    public function updatePassword(int $userId, string $newPassword): bool {
        return $this->connexion->update(
            $this->table,
            ['password' => password_hash($newPassword, PASSWORD_DEFAULT)],
            ['id' => $userId]
        );
    }
}