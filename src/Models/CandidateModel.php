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
}