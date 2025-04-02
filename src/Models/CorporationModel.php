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
            // 'rating'=> $search[2],
            // 'sector'=> $search[3],
            // 'type'=> $search[4],
        ];

        $filters = array_filter($rawfilters, fn($v) => $v !== null && $v !== '');

        $result = $this->connexion->selectLikeFilters($this->table, $conditions, $filters);
        
        return $result ?? null;
    }


    public function ajouterEntreprise(array $entrepriseData): bool|int{
        return $this->connexion->insert($this->table, $entrepriseData, [
            'Siret' => $siret 
        ]);
    }
    
    public function supprimerEntreprise(string $siret): bool{
        return $this->connexion->delete($this->table, [
            'Siret' => $siret
        ]);
    }
    
    public function modifierEntreprise(string $siret, array $entrepriseData): bool {
        return $this->connexion->update($this->table, $entrepriseData, [
            'Siret' => $siret
        ]);
    }
    
    
    // public function evaluerEntreprise()

}

