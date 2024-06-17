<?php
namespace Controllers;

use Models\RegisterModel;
use Views\RegisterForm;
use Google_Client;
use Google_Service_Oauth2;

class RegisterController {

    protected $registerModel;
    protected $registerView;

    public function __construct() {
        $this->registerModel = new RegisterModel();
        $this->registerView = new RegisterForm();
    }

    // Affiche le formulaire d'inscription
    public function registerForm() {
        $this->registerView->initForm();
    }

    // Enregistre un nouvel utilisateur
    public function userSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerModel->createUser();
        }
    }

    // Gère l'authentification via Google
    public function googleAuth() {
        $client = new Google_Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $client->addScope('email');
        $client->addScope('profile');

        if (!isset($_GET['code'])) {
            // Initialise le processus d'authentification Google
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit();
        } else {
            // Gère le rappel de Google après l'authentification de l'utilisateur
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $oauth2 = new Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();

            // Enregistre les informations de l'utilisateur dans la base de données ou le connecte
            $this->registerModel->googleUserAuth($userInfo);

            // Redirige vers la page d'accueil
            header('Location: http://localhost/project-nowtes/');
            exit();
        }
    }
}