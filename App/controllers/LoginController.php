<?php
namespace Controllers;

use Models\LoginModel;
use Views\LoginForm;

class LoginController {
    protected $loginModel;
    protected $loginView;

    public function __construct() {
        $this->loginModel = new LoginModel();
        $this->loginView = new LoginForm();
    }

    // Show login form
    public function showLoginForm() {
        $this->loginView->render();
    }

    // Handle user login
    public function userConnect() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['mail']) && isset($_POST['pswd'])) {  // Check if mail and pswd are set
                $mail = $_POST['mail'];
                $password = $_POST['pswd'];

                try {
                    if ($this->loginModel->authenticate($mail, $password)) {
                        // Successful login
                        header("Location: ./");
                        exit();
                    } else {
                        // Invalid login
                        echo "Invalid email or password.";
                    }
                } catch (\Exception $e) {
                    echo "An error occurred: " . $e->getMessage();
                }
            } else {
                echo "Please fill out both email and password fields.";
            }
        }
    }

    // Logout user
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: login");
        exit();
    }
}
?>