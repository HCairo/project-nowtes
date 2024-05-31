<?php
namespace Controllers;

use Models\AccountModel;
use Views\AccountView;

class AccountController {

    protected $accountModel;
    protected $accountView;

    public function __construct() {
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

            if (!empty($data['username']) && !empty($data['mail'])) {
                $this->accountModel->updateUser($userId, $data['username'], $data['mail']);
            }

            if (!empty($data['old_password']) && !empty($data['new_password']) && !empty($data['confirm_password'])) {
                if ($this->accountModel->verifyPassword($userId, $data['old_password'])) {
                    if ($data['new_password'] === $data['confirm_password']) {
                        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
                        $this->accountModel->updatePassword($userId, $hashedPassword);
                    } else {
                        // New passwords don't match
                        echo "New passwords don't match.";
                    }
                } else {
                    // Old password incorrect
                    echo "Old password incorrect.";
                }
            }

            header('Location: account');
            exit();
        } else {
            $userId = $_SESSION['user_id'];
            $user = $this->accountModel->getUserById($userId);
            $this->accountView->showAccount($user);
        }
    }
}