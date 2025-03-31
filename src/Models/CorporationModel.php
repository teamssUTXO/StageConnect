<?php
namespace App\Models;
use App\Models\Model;

class CorporationModel extends Model {

    protected $table = "Corporation";
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getAll(): array{
        $result = $this->connexion->select($this->table);
        return $result ?? null;
    }

    public function searchcorporation($search) {
        $result = $this->connexion->selectLike($this->table, [
                    'name' => $search
        ]);
        return $result ?? null;
    }

}