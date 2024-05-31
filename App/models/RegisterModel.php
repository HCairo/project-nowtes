<?php
namespace Models;

use App\Database;

class RegisterModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createUser() {
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $pswd = password_hash($_POST['pswd'], PASSWORD_BCRYPT); // Hash the password
        $last = date("Y-m-d H:i:s");
        $active = 1;

        try {
            $pdo = $this->db->getConnection()->prepare("INSERT INTO user (username, mail, pswd, last_maj, active) VALUES (?, ?, ?, ?, ?)");
            $pdo->execute([$username, $mail, $pswd, $last, $active]);
            echo "<h1>User created successfully</h1>";
            header('Location: ?action=login');
            exit();
        } catch (\PDOException $e) {
            echo "Error creating user: " . $e->getMessage();
        }
    }
}
?>