<?php
require_once('vendor/autoload.php');

use Dotenv\Dotenv;
use Controllers\RegisterController;
use Controllers\LoginController;
use Controllers\AccountController;
use Controllers\TasksController;
use Controllers\BillingController;
use App\Database;

// Start a session if none exists
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$action = $_REQUEST['action'] ?? null;

// Route based on the action parameter
switch($action) {
    default:
        // Default case: If user is logged in, display a welcome message, otherwise redirect to login
        if (isset($_SESSION['user_id'])) {
            echo "<h1>Hi, " . htmlspecialchars($_SESSION['username']) . "!</h1>";
            echo "<h2>Welcome on</h2>"; 
            echo '<img src="' . IMG . 'logo.jpeg">';
        } else {
            header("Location: login");
            exit();
        }
        break;

    case 'tasks':
        // Tasks case: Check if user is logged in, then list tasks
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        } else {
            $tasksController = new TasksController();
            $tasksController->listTasks();
        }
        break;

    case 'notes':
        // Notes case: Display a placeholder note
        echo 'Petite note';
        break;

    case 'billing':
        // Billing case: Display billing information
        $billingController = new BillingController();
        $billingController->displayBillingType();
        break;

    case 'account':
        // Account case: Modify account information
        $accountController = new AccountController();
        $accountController->modifyAccount();
        break;

    case 'register':
        // Register case: Handle user registration and Google authentication
        $registerController = new RegisterController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $registerController->userSave();
        } elseif (isset($_GET['action']) && $_GET['action'] === 'googleAuth') {
            $registerController->googleAuth();
        } else {
            $registerController->registerForm();
        }
        break;        

    case 'login':
        // Login case: Handle user login
        $loginController = new LoginController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginController->userConnect();
        } else {
            $loginController->showLoginForm();
        }
        break;

    case 'logout':
        // Logout case: Handle user logout
        $loginController = new LoginController();
        $loginController->logout();
        break;
}