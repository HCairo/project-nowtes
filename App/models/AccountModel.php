<?php
namespace Models;

use App\Database;
use PDO;

class AccountModel {
    
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getUserById($userId) {
        $pdo = $this->db->prepare("SELECT * FROM user WHERE id = ?");
        $pdo->execute([$userId]);
        return $pdo->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $username, $mail) {
        $pdo = $this->db->prepare("UPDATE user SET username = ?, mail = ? WHERE id = ?");
        return $pdo->execute([$username, $mail, $userId]);
    }

    public function verifyPassword($userId, $password) {
        $pdo = $this->db->prepare("SELECT pswd FROM user WHERE id = ?");
        $pdo->execute([$userId]);
        $hash = $pdo->fetchColumn();
        return password_verify($password, $hash);
    }

    public function updatePassword($userId, $hashedPassword) {
        $pdo = $this->db->prepare("UPDATE user SET pswd = ? WHERE id = ?");
        return $pdo->execute([$hashedPassword, $userId]);
    }
}