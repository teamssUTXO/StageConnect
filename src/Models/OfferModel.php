<?php
namespace App\Models;
use App\Models\Model;

class OfferModel extends Model {

    protected $table = "Offer";
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getAll(): array{
        $result = $this->connexion->select($this->table);
        return $result ?? null;
    }

    public function searchoffer($search) {
        $result = $this->connexion->selectLike($this->table, [
                    'title' => $search,
                    'description' => $search,
                    'competence' => $search
        ]);
        return $result ?? null;
    }

}