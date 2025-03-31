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

        $conditions = [
            'name'=> $search[0],
        ];

        $rawfilters = [
            // 'localisation'=> $search[1],
            // 'sector'=> $search[2],
            // 'type'=> $search[3],
        ];

        $filters = array_filter($rawfilters, fn($v) => $v !== null && $v !== '');

        $result = $this->connexion->selectLikeFilters($this->table, $conditions, $filters);
        
        return $result ?? null;
    }

}