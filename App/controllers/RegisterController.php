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

    public function registerForm() {
        $this->registerView->initForm();
    }

    public function userSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerModel->createUser();
        }
    }

    public function googleAuth() {
        $client = new Google_Client();
        
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $client->addScope('email');
        $client->addScope('profile');

        // Debugging: Check if the client ID and secret are set correctly
        error_log('Client ID: ' . $_ENV['GOOGLE_CLIENT_ID']);
        error_log('Client Secret: ' . $_ENV['GOOGLE_CLIENT_SECRET']);
        error_log('Redirect URI: ' . $_ENV['GOOGLE_REDIRECT_URI']);

        if (!isset($_GET['code'])) {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit();
        } else {
            try {
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                
                // Debugging: Log the fetched token
                error_log('Fetched Token: ' . print_r($token, true));
                
                if (isset($token['error'])) {
                    throw new \Exception('Error fetching token: ' . $token['error']);
                }

                $client->setAccessToken($token);

                $oauth2 = new Google_Service_Oauth2($client);
                $userInfo = $oauth2->userinfo->get();

                // Debugging: Log the user info fetched from Google
                error_log('User Info: ' . print_r($userInfo, true));

                $this->registerModel->googleUserAuth($userInfo);

                header('Location: http://localhost/project-nowtes/');
                exit();
            } catch (\Exception $e) {
                // Debugging: Log any exceptions encountered
                error_log('Exception: ' . $e->getMessage());
                echo 'An error occurred: ' . $e->getMessage();
            }
        }
    }
}