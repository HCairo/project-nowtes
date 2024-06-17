<?php
namespace Controllers;

// Import necessary classes
use Models\AccountModel;
use Views\AccountView;

class AccountController {

    // Properties for the model and view
    protected $accountModel;
    protected $accountView;

    // Constructor to initialize the model and view, checks if the user is logged in
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            exit('Utilisateur non connecté.'); // Exit if the user is not logged in
        }
        $this->accountModel = new AccountModel();
        $this->accountView = new AccountView();
    }

    // Method to modify account details
    public function modifyAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];

            // Collect data from POST request
            $data = [
                'username' => $_POST['username'] ?? null,
                'mail' => $_POST['mail'] ?? null,
                'old_password' => $_POST['old_password'] ?? null,
                'new_password' => $_POST['new_password'] ?? null,
                'confirm_password' => $_POST['confirm_password'] ?? null,
            ];

            var_dump($data); // Debug: check the received data

            // Retrieve current user data if needed
            $currentUser = $this->accountModel->getUserById($userId);
            if (!$currentUser) {
                exit('Utilisateur non trouvé.');
            }

            // Ensure valid username
            $username = $data['username'] ?? $currentUser['username'];
            $mail = $data['mail'] ?? $currentUser['mail'];

            // Update username and/or mail
            if ($username || $mail) {
                if ($this->accountModel->updateUser($userId, $username, $mail)) {
                    echo 'Les détails de l\'utilisateur ont été mis à jour avec succès.';
                } else {
                    echo 'Erreur lors de la mise à jour des détails de l\'utilisateur.';
                }
            }

            // Update password if all fields are provided
            if (!empty($data['old_password']) && !empty($data['new_password']) && !empty($data['confirm_password'])) {
                if ($this->accountModel->verifyPassword($userId, $data['old_password'])) {
                    if ($data['new_password'] === $data['confirm_password']) {
                        $hashedPassword = password_hash($data['new_password'], PASSWORD_ARGON2I);
                        if ($this->accountModel->updatePassword($userId, $hashedPassword)) {
                            echo 'Mot de passe mis à jour avec succès.';
                        } else {
                            echo 'Erreur lors de la mise à jour du mot de passe.';
                        }
                    } else {
                        echo "Les nouveaux mots de passe ne correspondent pas.";
                    }
                } else {
                    echo "L'ancien mot de passe est incorrect.";
                }
            }

            // Redirect after modification
            header('Location: account');
            exit();
        } else {
            // If not POST, show the account details
            $userId = $_SESSION['user_id'];
            $user = $this->accountModel->getUserById($userId);
            $this->accountView->showAccount($user);
        }
    }
}