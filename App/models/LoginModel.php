<?php
namespace Models;

use App\Database;

class LoginModel {
    protected $db;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->db = new Database();
    }

    // Function to authenticate user login details
    public function authenticate($mail, $password) {
        // Prepare the SQL statement to find the user by email
        $pdo = $this->db->getConnection()->prepare("SELECT * FROM user WHERE mail = :mail");
        $pdo->bindParam(':mail', $mail);
        $pdo->execute();
        $user = $pdo->fetch(\PDO::FETCH_ASSOC);

        // Verify the password and check if the email exists
        if ($user && password_verify($password, $user['pswd'])) {
            // Set session variables for authenticated user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            return false;
        }
    }
}
?>