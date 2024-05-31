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
        $pdo = $this->db->prepare("SELECT * FROM user WHERE mail = :mail");
        $pdo->bindParam(':mail', $mail);
        $pdo->execute();
        $user = $pdo->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pswd'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            return false;
        }
    }
}
?>