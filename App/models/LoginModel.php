<?php
namespace Models;

use App\Database;

class LoginModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }
    // Fonction pour verifier les informations de login de l'utilisateur
    public function authenticate($mail, $password) {
        $pdo = $this->db->getConnection()->prepare("SELECT * FROM user WHERE mail = :mail");
        $pdo->bindParam(':mail', $mail);
        $pdo->execute();
        $user = $pdo->fetch(\PDO::FETCH_ASSOC);
        // Si le password et le mail sont correct => connexion
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