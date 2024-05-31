<?php
namespace Controllers;

use Models\TasksModel;
use Views\TasksView;

class TasksController {
    protected $tasksModel;
    protected $tasksView;

    public function __construct() {
        $this->tasksModel = new TasksModel();
        $this->tasksView = new TasksView();
    }

    public function listTasks() {
        $tasks = $this->tasksModel->taskRetrieve();
        $this->tasksView->showTasks($tasks);
    }
}