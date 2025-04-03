<?php
namespace App\Models;
use App\Models\Model;

class CandidateModel extends Model {
    protected $table = "Candidate";

    private $connexion = null;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function candidatureExiste($id_user, $id_offre) {
        $result = $this->connexion->select($this->table, [
            'Id_Users' => $id_user,
            'Id_Offer' => $id_offre
        ]);
        return !empty($result);
    }

    public function enregistrerCandidature($id_user, $id_offre, $message, $cv_path) {
        return $this->connexion->insert($this->table, [
            'Id_Users' => $id_user,
            'Id_Offer' => $id_offre,
            'message' => $message,
            'cv_path' => $cv_path
        ]);
    }

    public function getCandidateCount($userId) {
        // On utilise la méthode select() de Connexion pour récupérer toutes les candidatures de l'utilisateur
        $results = $this->connexion->select("Candidate", ["Id_Users" => $userId]);
        return count($results);
    }

    public function getLastCandidateOffer($userId) {
        $sql = "SELECT o.* 
                FROM Candidate c 
                JOIN Offer o ON c.Id_Offer = o.Id_Offer 
                WHERE c.Id_Users = :userId 
                ORDER BY o.publication_date DESC 
                LIMIT 1";
        $stmt = $this->connexion->getpdo()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}