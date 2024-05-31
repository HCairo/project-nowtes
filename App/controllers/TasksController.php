<?php
namespace Controllers;

use Models\TasksModel;
use Views\TasksView;

class TasksController {
    protected $tasksModel;
    protected $tasksView;

    public function __construct() {
        // Initialize the model and view
        $this->tasksModel = new TasksModel();
        $this->tasksView = new TasksView();
    }

    public function addMyTask() {
        // Logic to handle adding a new task
        // 1. Get input data (e.g., from $_POST)
        // 2. Pass data to the model's taskAdd() method
        // 3. Provide feedback or redirect, using the view
    }

    public function updateMyTask() {
        // Logic to handle updating an existing task
        // 1. Get input data (e.g., task ID and new values)
        // 2. Pass data to the model's taskUpdate() method
        // 3. Provide feedback or redirect, using the view
    }
    
    public function deleteMyTask() {
        // Logic to handle deleting a task
        // 1. Get task ID to delete (e.g., from $_POST or $_GET)
        // 2. Pass task ID to the model's taskDelete() method
        // 3. Provide feedback or redirect, using the view
    }
}