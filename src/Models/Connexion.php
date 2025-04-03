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

    public function selectById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); //bindParam() lie la variable elle-même, pas juste sa valeur donc si tu modifies $id après le bindParam(), la nouvelle valeur sera utilisée au moment du execute().
    
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // retourne un seul résultat
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

    public function selectJoin($table, $join = "", $conditions = [], $alias = null) {
        // Déterminer l'alias à utiliser (premier caractère du nom de la table ou alias spécifié)
        $tableAlias = $alias ?: strtolower(substr($table, 0, 1));
        
        // Colonnes à sélectionner
        $sql = "SELECT * FROM $table AS $tableAlias";
        
        // Ajouter les jointures
        if (is_object($join) && property_exists($join, 'value')) {
            $sql .= " " . $join->value;
        } elseif (is_string($join)) {
            $sql .= " " . $join; // Si c'est une simple chaîne, on l'ajoute directement
        }        
        
        // Préparer les conditions
        $params = [];
        if (!empty($conditions)) {
            $where = [];
            // print_r($conditions);
            foreach ($conditions as $column => $value) {
                $where[] = "$tableAlias.$column = :$column";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectJoinWithFilters($table, $join = "", $conditions = [], $filtres = [], $alias = null) {
        // Déterminer l'alias à utiliser (premier caractère du nom de la table ou alias spécifié)
        $tableAlias = $alias ?: strtolower(substr($table, 0, 1));
        
        $sql = "SELECT * FROM $table AS $tableAlias";
    
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
                // Utilisation de l'alias dynamique de la table pour éviter l'ambiguïté
                $likeClauses[] = "$tableAlias.$column LIKE :$paramKey"; 
                $params[$paramKey] = '%' . $value . '%';
            }
            $clauses[] = '(' . implode(' OR ', $likeClauses) . ')';  
        }
    
        // Filtres 
        if (!empty($filtres)) {
            foreach ($filtres as $column => $value) {
                $paramKey = 'filter_' . $column;
                $clauses[] = "$tableAlias.$column = :$paramKey";
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

    public function insert($table, $data = []) {   //A appeler de la manière : $newUserId = $db->insert('Users', ['name' => 'Antoine','surname' => 'Dupont','mail' => 'user@example.com','password' => password_hash('mot_de_passe_secure', PASSWORD_DEFAULT),'Id_Promotion' => 1,'Id_Role' => 1]);
        // Préparation des colonnes et des valeurs pour la requête
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));
        // Construction de la requête SQL
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
   
        // Préparation et exécution de la requête
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute($data);
        
        // Si l'insertion a réussi, on retourne l'ID de la nouvelle ligne
        if ($success) {
            return true;
        }
        
        return false;
    }
    
    // public function deleteJoin($table, $join = "", $conditions = [], $alias = null) {
    //     // Déterminer l'alias à utiliser (premier caractère du nom de la table ou alias spécifié)
    //     $tableAlias = $alias ?: strtolower(substr($table, 0, 1));
        
    //     // Construction de la requête DELETE avec une sous-requête pour gérer les jointures
    //     $sql = "DELETE $tableAlias FROM $table AS $tableAlias";
        
    //     // Ajouter les jointures
    //     if (is_object($join) && property_exists($join, 'value')) {
    //         $sql .= " " . $join->value;
    //     } elseif (is_string($join)) {
    //         $sql .= " " . $join;
    //     }
        
    //     // Préparer les conditions
    //     $params = [];
    //     if (!empty($conditions)) {
    //         $where = [];
    //         foreach ($conditions as $column => $value) {
    //             $where[] = "$tableAlias.$column = :$column";
    //             $params[$column] = $value;
    //         }
    //         $sql .= " WHERE " . implode(" AND ", $where);
    //     }
        
    //     $stmt = $this->pdo->prepare($sql);
    //     return $stmt->execute($params);
    // }
    
    /**
     * Méthode pour tester le bon fonctionnement de la connexion et des méthodes CRUD
     * 
     * @param string $tableName Nom d'une table existante dans la base de données pour les tests
     * @return array Résultats des tests avec statut et messages
     */
    public function testFunctionality($tableName = null) {
        $results = [];
        
        // Test 1: Connexion à la base de données
        try {
            $this->pdo->query("SELECT 1");
            $results['connection'] = [
                'status' => 'success',
                'message' => 'Connexion à la base de données réussie'
            ];
        } catch (PDOException $e) {
            $results['connection'] = [
                'status' => 'error',
                'message' => 'Échec de la connexion à la base de données: ' . $e->getMessage()
            ];
            // Si la connexion échoue, pas besoin de continuer les tests
            return $results;
        }
        
        // Vérification qu'une table de test est fournie
        if (empty($tableName)) {
            $results['table_check'] = [
                'status' => 'warning',
                'message' => 'Aucune table fournie pour les tests complets. Tests limités à la connexion.'
            ];
            return $results;
        }
        
        // Test 2: Vérification que la table existe
        try {
            $stmt = $this->pdo->prepare("SHOW TABLES LIKE :tableName");
            $stmt->execute(['tableName' => $tableName]);
            if ($stmt->rowCount() === 0) {
                $results['table_existence'] = [
                    'status' => 'error',
                    'message' => "La table '$tableName' n'existe pas dans la base de données"
                ];
                return $results;
            }
            $results['table_existence'] = [
                'status' => 'success',
                'message' => "La table '$tableName' existe dans la base de données"
            ];
        } catch (PDOException $e) {
            $results['table_existence'] = [
                'status' => 'error',
                'message' => "Erreur lors de la vérification de l'existence de la table: " . $e->getMessage()
            ];
            return $results;
        }
        
        // Test 3: Test de la méthode select
        try {
            $data = $this->select($tableName, []);
            $results['select_method'] = [
                'status' => 'success',
                'message' => "La méthode select() fonctionne correctement",
                'data_count' => count($data)
            ];
        } catch (PDOException $e) {
            $results['select_method'] = [
                'status' => 'error',
                'message' => "Erreur lors du test de la méthode select(): " . $e->getMessage()
            ];
        }
        
        // Test 4: Test de la méthode selectJoin avec différents alias
        try {
            // Récupérer une autre table pour le test de jointure
            $stmt = $this->pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Filtre pour trouver une table différente de celle passée en paramètre
            $otherTables = array_filter($tables, function($t) use ($tableName) {
                return $t !== $tableName;
            });
            
            if (count($otherTables) > 0) {
                $secondTable = reset($otherTables);
                
                // Essai avec l'alias par défaut
                $defaultAliasQuery = "SELECT * FROM $tableName AS " . strtolower(substr($tableName, 0, 1)) . " LIMIT 1";
                $this->pdo->query($defaultAliasQuery);
                
                // Essai avec un alias personnalisé
                $customAliasQuery = "SELECT * FROM $tableName AS custom_alias LIMIT 1";
                $this->pdo->query($customAliasQuery);
                
                $results['alias_test'] = [
                    'status' => 'success',
                    'message' => "Les requêtes avec alias par défaut et personnalisé fonctionnent correctement"
                ];
            } else {
                $results['alias_test'] = [
                    'status' => 'warning',
                    'message' => "Impossible de tester les jointures: pas assez de tables dans la base de données"
                ];
            }
        } catch (PDOException $e) {
            $results['alias_test'] = [
                'status' => 'error',
                'message' => "Erreur lors du test des alias: " . $e->getMessage()
            ];
        }
        
        // Test 5: Vérifier les requêtes préparées pour l'injection SQL
        try {
            $maliciousCondition = ["id" => "1; DROP TABLE $tableName;"];
            $safeSql = $this->prepareDeleteJoinQuery($tableName, "", $maliciousCondition);
            
            $results['sql_injection'] = [
                'status' => 'success',
                'message' => "Les requêtes sont correctement préparées contre l'injection SQL",
                'prepared_query' => $safeSql
            ];
        } catch (PDOException $e) {
            $results['sql_injection'] = [
                'status' => 'error',
                'message' => "Erreur lors du test de protection contre l'injection SQL: " . $e->getMessage()
            ];
        }
        
        
        return $results;
    }
    
    /**
     * Méthode utilitaire pour préparer une requête deleteJoin sans l'exécuter
     * Utilisé pour les tests de requêtes préparées
     */
    private function prepareDeleteJoinQuery($table, $join = "", $conditions = [], $alias = null) {
        $tableAlias = $alias ?: strtolower(substr($table, 0, 1));
        
        $sql = "DELETE $tableAlias FROM $table AS $tableAlias";
        
        if (is_object($join) && property_exists($join, 'value')) {
            $sql .= " " . $join->value;
        } elseif (is_string($join)) {
            $sql .= " " . $join;
        }
        
        $where = [];
        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $where[] = "$tableAlias.$column = :$column";
            }
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        
        return $sql;
    }
}


// // Instantiation de la classe connexion
// $db = new connexion();

// // Exécution des tests sur une table existante
// $testResults = $db->testFunctionality('Users');

// // Affichage des résultats
// echo "<pre>";
// print_r($testResults);
// echo "</pre>";

// Exemple d'utilisation
// $newUserId = $db->insert('Users', [
//     'name' => 'Antoine',
//     'surname' => 'Dupont',
//     'mail' => 'user@example.com',
//     'password' => password_hash('mot_de_passe_secure', PASSWORD_DEFAULT),
//     'Id_Promotion' => 1,
//     'Id_Role' => 1
// ]);

// if ($newUserId) {
//     echo "Nouvel utilisateur créé avec l'ID: " . $newUserId;
// } else {
//     echo "Erreur lors de la création de l'utilisateur";
// }