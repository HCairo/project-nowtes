<?php
require_once('vendor/autoload.php');
use Controllers\RegisterController;
use Controllers\LoginController;
use Controllers\AccountController;
use Controllers\TasksController; // Add this line
use App\Database;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = $_REQUEST['action'] ?? null;
$taskId = $_REQUEST['taskId'] ?? null; // Add taskId retrieval

switch($action) {
    default:
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
            exit();
        } else {
            $tasksController = new TasksController();
            $tasksController->listTasks();
        }
        break;
    case 'notes':
        echo 'Petite note';
        break;
    case 'billing':
        echo 'Paye moi';
        break;
    case 'account':
        $accountController = new AccountController();
        $accountController->modifyAccount();
        break;
    case 'register':
        $registerController = new RegisterController();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $registerController->userSave();
        } else {
            $registerController->registerForm();
        }
        break;
    case 'login':
        $loginController = new LoginController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginController->userConnect();
        } else {
            $loginController->showLoginForm();
        }
        break;
    case 'logout':
        $loginController = new LoginController();
        $loginController->logout();
        break;
}