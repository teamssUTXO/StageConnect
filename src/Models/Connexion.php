<?php

namespace App\Models;
use PDO;
use PDOException;

class connexion {
    private $user = "root";
    private $password = 'root123';
    private $host = "db";
    private $dbname = "stageconnectbdd";
    private $pdo;

    public function __construct(){
        try {
            $this ->pdo = new PDO("mysql:host=". $this->host.";dbname=". $this->dbname .";charset=utf8", $this->user, $this->password);
        } catch (PDOException $e) {
            die("Erreur de connexion à la BDD :" . $e->getMessage());
        }
    }

    public function getpdo() {
        return $this->pdo;
    }

    //Méthodes CRUD
    public function select($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectLike($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        $params = [];
        if (!empty($conditions)) {
            $likeClauses = [];
            foreach ($conditions as $column => $value) {
                $likeClauses[] = "$column LIKE :$column";
                $params[$column] = '%' . $value . '%';
            }
            $sql .= " WHERE " . implode(" OR ", $likeClauses);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectLikeFilters($table, $conditions = [], $filtres = []) {
        $sql = "SELECT * FROM $table";
        $params = [];
        $clauses = [];
    
        // Partie LIKE (recherche)
        if (!empty($conditions)) {
            $likeClauses = [];
            foreach ($conditions as $column => $value) {
                $paramKey = 'like_' . $column;
                $likeClauses[] = "$column LIKE :$paramKey";
                $params[$paramKey] = '%' . $value . '%';
            }
            $clauses[] = '(' . implode(' OR ', $likeClauses) . ')';
        }
    
        // Partie Filtres (égalités)
        if (!empty($filtres)) {
            foreach ($filtres as $column => $value) {
                $paramKey = 'filter_' . $column;
                $clauses[] = "$column = :$paramKey";
                $params[$paramKey] = $value;
            }
        }
    
        // Si on a des conditions (LIKE ou filtres), on les ajoute au WHERE
        if (!empty($clauses)) {
            $sql .= " WHERE " . implode(' AND ', $clauses);
        }
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectJoin($Table, $join = "", $conditions = []) {
        // Colonnes à sélectionner
        $sql = "SELECT * FROM $Table AS o";
        //echo $join;
        // Ajouter les jointures
        if (is_object($join) && property_exists($join, 'value')) {
            $sql .= " " . $join->value;
        } elseif (is_string($join)) {
            $sql .= " " . $join; // Si c'est une simple chaîne, on l'ajoute directement
        }        
        //echo $sql;
        // Préparer les conditions
        $params = [];
        if (!empty($conditions)) {
            $where = [];
            print_r($conditions);
            foreach ($conditions as $column => $value) {
                $where[] = "o.$column = :$column";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectJoinWithFilters($table, $join = "", $conditions = [], $filtres = []) {
        $sql = "SELECT * FROM $table AS o"; // alias 'o' pour 'Offer'
    
        // Ajouter la jointure 
        if ($join) {
            $sql .= " " . $join->value;  
        }
    
        // LIKE 
        $params = [];
        $clauses = [];
        
        if (!empty($conditions)) {
            $likeClauses = [];
            foreach ($conditions as $column => $value) {
                $paramKey = 'like_' . $column;
                // Utilisation de l'alias de la table (o.) pour éviter l'ambiguïté
                $likeClauses[] = "o.$column LIKE :$paramKey"; 
                $params[$paramKey] = '%' . $value . '%';
            }
            $clauses[] = '(' . implode(' OR ', $likeClauses) . ')';  
        }
    
        // Filtres 
        if (!empty($filtres)) {
            foreach ($filtres as $column => $value) {
                $paramKey = 'filter_' . $column;
                $clauses[] = "o.$column = :$paramKey";
                $params[$paramKey] = $value;
            }
        }
    
        // WHERE
        if (!empty($clauses)) {
            $sql .= " WHERE " . implode(' AND ', $clauses);  
        }
    
        // Requete finale
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    

    public function update($table, $data, $condition) {
        $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $wherePart = implode(" AND ", array_map(fn($key) => "$key = :cond_$key", array_keys($condition)));
        $sql = "UPDATE $table SET $setPart WHERE $wherePart";
        $stmt = $this->pdo->prepare($sql);
        foreach ($condition as $key => $value) {
            $data["cond_$key"] = $value;
        }
        return $stmt->execute($data);
    }

    public function delete($table, $conditions) {
        $wherePart = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        $sql = "DELETE FROM $table WHERE $wherePart";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($conditions);
    }

    public function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
}
