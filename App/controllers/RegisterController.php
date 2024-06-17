<?php
namespace Controllers;

// Import necessary classes
use Models\RegisterModel;
use Views\RegisterForm;
use Google_Client;
use Google_Service_Oauth2;

class RegisterController {

    // Properties for the model and view
    protected $registerModel;
    protected $registerView;

    // Constructor to initialize the model and view
    public function __construct() {
        $this->registerModel = new RegisterModel();
        $this->registerView = new RegisterForm();
    }

    // Method to display the registration form
    public function registerForm() {
        $this->registerView->initForm();
    }

    // Method to save a new user
    public function userSave() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerModel->createUser();
        }
    }

    // Method for Google authentication
    public function googleAuth() {
        // Initialize the Google Client
        $client = new Google_Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']); // Set the client ID
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']); // Set the client secret
        $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']); // Set the redirect URI
        $client->addScope('email'); // Add email scope
        $client->addScope('profile'); // Add profile scope

        // If the Google auth code is not set, redirect to the Google login page
        if (!isset($_GET['code'])) {
            $authUrl = $client->createAuthUrl(); // Create the auth URL
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL)); // Redirect to Google login
            exit();
        } else {
            // Handle the callback from Google after user authentication
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']); // Fetch the access token
            $client->setAccessToken($token); // Set the access token

            // Get user info from Google
            $oauth2 = new Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();

            // Authenticate the user using the Google user info
            $this->registerModel->googleUserAuth($userInfo);

            // Redirect to the home page
            header('Location: http://localhost/project-nowtes/');
            exit();
        }
    }
}