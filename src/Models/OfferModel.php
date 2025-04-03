<?php
namespace App\Models;
use App\Models\Model;

enum Joins: string {
    case CORP = "JOIN Corporation ON o.Siret = Corporation.Siret";
    case WISHLIST = "JOIN Wishlist ON o.Id_Offer = Wishlist.Id_Offer JOIN Users ON Wishlist.Id_Users = Users.Id_Users";
    case CANDIDATE = "JOIN Candidate ON o.Id_Offer = Candidate.Id_Offer Join Users ON Candidate.Id_Users = Users.Id_Users";
}

class OfferModel extends Model {

    protected $table = "Offer";
    private $connexion;
    // enum OfferColumns: string {
    //     case ID = "id_Offer";
    //     case TITLE = "title";
    //     case DES = "description";
    //     case COM = "competence";
    //     case REM = "remuneration";
    //     case PUBLI = "publication_date";
    //     case NB_CAN = "candidate_nb";
    // };

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function getAll(): array{
        $result = $this->connexion->selectJoin($this->table,Joins::CORP,[]);
        return $result ?? null;
    }

    public function searchoffer($search = []) {

        $conditions = [
            'title'=> $search[0],
            'description'=> $search[0],
            'competence'=> $search[0],
        ];

        $rawfilters = [
            'Corporation.localisation'=> $search[1],
            'Corporation.sector'=> $search[2],
            'typeoffer'=> $search[3],
            'studieslevel'=> $search[4],
        ];

        $filters = array_filter($rawfilters, fn($v) => $v !== null && $v !== '');
        
        $result = $this->connexion->selectJoinWithFilters($this->table, Joins::CORP, $conditions, $filters);
        
        
        return $result ?? null;
    }

    public function wishlist_user ($Id_User){
        $result = $this->connexion->selectJoin($this->table, Joins::WISHLIST->value, [
            'Id_Users' => $Id_User // A changer si on veut chercher par rapport au nom au lieu de l'id
        ]);
        return $result ?? null;
    }
    
    public function offerCorporation($id){
        $result = $this->connexion->selectJoin($this->table, Joins::CORP->value, [
            'Id_Offer' => $id
        ]);
        return $result ?? null;
    }

    public function candidate_user ($Id_User){
        $result = $this->connexion->selectJoin($this->table, Joins::CANDIDATE->value, [
            'Id_Users' => $Id_User // A changer si on veut chercher par rapport au nom au lieu de l'id
        ]);
        return $result ?? null;
    }

    public function insertOffer ($id, $data) {
        $result =  $this->connexion->insert($this->table, $data);
        return $result ?? null;
    }

    public function getAllOffers () {
        $result = $this->connexion->select($this->table);

        return $result ?? null;
    }
    public function getOfferById($id) {
        $result = $this->connexion->select($this->table, [
            'Id_Offer' => $id
        ]);
        return $result ? $result[0] : null;
    }
    
    public function updateOffer($id, $data) {
        $result = $this->connexion->update($this->table, $data, [
            'Id_Offer' => $id
        ]);
        return $result;
    }
    
    public function deleteOffer($id) {
        $result = $this->connexion->delete($this->table, [
            'Id_Offer' => $id
        ]);
        return $result;
    }
    
    public function createOffer($data) {
        $result = $this->connexion->insert($this->table, $data);
        return $result;
    }
}