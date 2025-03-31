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

    // public function searchoffer($search) {
    //     $result = $this->connexion->selectLike($this->table, [
    //                 'title' => $search,
    //                 'description' => $search,
    //                 'competence' => $search,
    //     ]);
    //     return $result ?? null;
    // }

    public function searchoffer($search = []) {

        $conditions = [
            'title'=> $search[0],
            'description'=> $search[0],
            'competence'=> $search[0],
        ];

        $rawfilters = [
            // 'localisation'=> $search[1],
            // 'sector'=> $search[2],
            'rating'=> $search[3],
            // 'duration'=> $search[4],
            // 'type'=> $search[5],
            // 'studies'=> $search[6],
        ];

        $filters = array_filter($rawfilters, fn($v) => $v !== null && $v !== '');

        $result = $this->connexion->selectLikeFilters($this->table, $conditions, $filters);

        return $result ?? null;
    }

}