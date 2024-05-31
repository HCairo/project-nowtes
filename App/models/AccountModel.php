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
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $username, $mail) {
        $stmt = $this->db->prepare("UPDATE user SET username = ?, mail = ? WHERE id = ?");
        return $stmt->execute([$username, $mail, $userId]);
    }

    public function verifyPassword($userId, $password) {
        $stmt = $this->db->prepare("SELECT pswd FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        $hash = $stmt->fetchColumn();
        return password_verify($password, $hash);
    }

    public function updatePassword($userId, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE user SET pswd = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }
}