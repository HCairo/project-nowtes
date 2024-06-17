<?php
namespace Models;

use App\Database;

class AccountModel {
    
    protected $db;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->db = new Database();
    }

    // Function to get user data by user ID
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

    // Function to update user information in the database
    public function updateUser($userId, $username, $mail) {
        try {
            // Construct the query dynamically based on provided parameters
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

            // Debugging information
            var_dump($pdo->errorInfo()); // Display SQL errors
            var_dump($result); // Display execution result

            return $result;
        } catch (\PDOException $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    // Function to verify the user's password
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

    // Function to update the user's password
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