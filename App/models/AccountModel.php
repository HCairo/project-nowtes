<?php
namespace Models;

use App\Database;

class AccountModel {
    
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }
    // Recuperation des donnees de l'utilisateur
    public function getUserById($userId) {
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT * FROM user WHERE id = ?");
            $pdo->execute([$userId]);
            return $pdo->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    // Recuperation des inputs pour modifier les informations dans la base de donnees
    public function updateUser($userId, $username, $mail) {
        try {
            $query = "UPDATE user SET username = :username";
            $params = [':username' => $username];
            
            if ($mail !== null) {
                $query .= ", mail = :mail";
                $params[':mail'] = $mail;
            }

            $query .= " WHERE id = :id";
            $params[':id'] = $userId;

            $pdo = $this->db->getConnection()->prepare($query);
            $result = $pdo->execute($params);

            // Information de débogage
            var_dump($pdo->errorInfo()); // Afficher les erreurs SQL
            var_dump($result); // Afficher le résultat de l'exécution

            return $result;
        } catch (\PDOException $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    // Fonction de verification du password -> si le password n'est pas celui entre en db la modification ne se lancera pas
    public function verifyPassword($userId, $password) {
        try {
            $pdo = $this->db->getConnection()->prepare("SELECT pswd FROM user WHERE id = ?");
            $pdo->execute([$userId]);
            $hash = $pdo->fetchColumn();
            return password_verify($password, $hash);
        } catch (\PDOException $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    // Ici on modifie le mot de passe si la fonction ci-dessus est valide
    public function updatePassword($userId, $hashedPassword) {
        try {
            $pdo = $this->db->getConnection()->prepare("UPDATE user SET pswd = ? WHERE id = ?");
            return $pdo->execute([$hashedPassword, $userId]);
        } catch (\PDOException $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
}
?>