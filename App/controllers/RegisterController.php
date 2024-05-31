<?php
namespace Controllers;

use Models\RegisterModel; 
use Views\RegisterForm;

class RegisterController {

    protected $registerModel; 
    protected $registerView;

    public function __construct() {
        $this->registerModel = new RegisterModel(); 
        $this->registerView = new RegisterForm(); 
    }

    public function registerForm() {
        $this->registerView->initForm();
    }

    public function userSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerModel->createUser();
        }
    }
}
?>