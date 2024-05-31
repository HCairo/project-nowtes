<?php
namespace Models;

use App\Database;

class LoginModel {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function authenticate($mail, $password) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE mail = :mail");
        $stmt->bindParam(':mail', $mail); // Corrected parameter name
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pswd'])) {
            $_SESSION['user_id'] = $user['id']; // Set session variables after successful verification
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            return false;
        }
    }
}
?>