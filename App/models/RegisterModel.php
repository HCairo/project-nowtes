<?php
namespace Models;

use App\Database;

class RegisterModel {
    protected $db;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->db = new Database();
    }

    // Method to create a new user
    public function createUser() {
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $pswd = password_hash($_POST['pswd'], PASSWORD_ARGON2I);
        $last = date("Y-m-d H:i:s");
        $active = 1;

        try {
            $pdo = $this->db->getConnection()->prepare("INSERT INTO user (username, mail, pswd, last_maj, active) VALUES (?, ?, ?, ?, ?)");
            $pdo->execute([$username, $mail, $pswd, $last, $active]);
            echo "<h1>Utilisateur créé avec succès</h1>";
            header('Location: ?action=login');
            exit();
        } catch (\PDOException $e) {
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
        }
    }

    // Method to create or update a Google user
    public function googleUserAuth($userInfo) {
        $mail = $userInfo->email;
        $username = $userInfo->name;
        $bill = 1;
        $last = date("Y-m-d H:i:s");
        $active = 1;

        try {
            $pdo = $this->db->getConnection()->prepare("INSERT INTO user (username, mail, last_maj, active) VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE last_maj = VALUES(last_maj)");
            $pdo->execute([$username, $mail, $bill, $last, $active]);
            echo "<h1>Utilisateur connecté avec succès</h1>";
            header('Location: ?action=login');
            exit();
        } catch (\PDOException $e) {
            echo "Erreur lors de la création ou de la mise à jour de l'utilisateur : " . $e->getMessage();
        }
    }
}