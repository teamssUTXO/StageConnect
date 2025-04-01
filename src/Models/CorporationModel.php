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

    public function getById(int $id) {
        $result = $this->connexion->selectJoin(
            $this->table,
            'INNER JOIN Offer AS o2 ON o.Siret = o2.Siret', 
            ['Siret' => $id]
        );

        return $result ?? null;
    }

    public function searchcorporation($search) {

        $conditions = [
            'name'=> $search[0],
        ];

        $rawfilters = [
            // 'localisation'=> $search[1],
            // 'rating'=> $search[2],
            // 'sector'=> $search[3],
            // 'type'=> $search[4],
        ];

        $filters = array_filter($rawfilters, fn($v) => $v !== null && $v !== '');

        $result = $this->connexion->selectLikeFilters($this->table, $conditions, $filters);
        
        return $result ?? null;
    }

}