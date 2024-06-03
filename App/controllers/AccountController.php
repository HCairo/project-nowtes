<?php
namespace Controllers;

use Models\AccountModel;
use Views\AccountView;

class AccountController {

    protected $accountModel;
    protected $accountView;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            exit('Utilisateur non connecté.');
        }
        $this->accountModel = new AccountModel();
        $this->accountView = new AccountView();
    }

    public function modifyAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $data = [
                'username' => $_POST['username'] ?? null,
                'mail' => $_POST['mail'] ?? null,
                'old_password' => $_POST['old_password'] ?? null,
                'new_password' => $_POST['new_password'] ?? null,
                'confirm_password' => $_POST['confirm_password'] ?? null,
            ];

            var_dump($data); // Débogage: vérifier les données reçues

            // Récupérer les données actuelles de l'utilisateur si nécessaire
            $currentUser = $this->accountModel->getUserById($userId);
            if (!$currentUser) {
                exit('Utilisateur non trouvé.');
            }

            // Assurez-vous d'avoir un nom d'utilisateur valide
            $username = $data['username'] ?? $currentUser['username'];
            $mail = $data['mail'] ?? $currentUser['mail'];

            // Mettre à jour le nom d'utilisateur et/ou le mail
            if ($username || $mail) {
                if ($this->accountModel->updateUser($userId, $username, $mail)) {
                    echo 'Les détails de l\'utilisateur ont été mis à jour avec succès.';
                } else {
                    echo 'Erreur lors de la mise à jour des détails de l\'utilisateur.';
                }
            }

            // Mettre à jour le mot de passe
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

            // Redirection après la modification
            header('Location: account');
            exit();
        } else {
            $userId = $_SESSION['user_id'];
            $user = $this->accountModel->getUserById($userId);
            $this->accountView->showAccount($user);
        }
    }
}
?>