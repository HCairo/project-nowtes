<?php
namespace Models;

use App\Database;

class TasksModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function taskRetrieve() {
        $query = "SELECT * FROM tasks";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function taskAdd($taskData) {
        $query = "INSERT INTO tasks (title, description, due_date, priority, status) VALUES (:title, :description, :due_date, :priority, :status)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':title', $taskData['title']);
        $stmt->bindParam(':description', $taskData['description']);
        $stmt->bindParam(':due_date', $taskData['due_date']);
        $stmt->bindParam(':priority', $taskData['priority']);
        $stmt->bindParam(':status', $taskData['status']);
        return $stmt->execute();
    }

    public function taskUpdate($taskId, $newData) {
        $query = "UPDATE tasks SET title = :title, description = :description, due_date = :due_date, priority = :priority, status = :status WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':title', $newData['title']);
        $stmt->bindParam(':description', $newData['description']);
        $stmt->bindParam(':due_date', $newData['due_date']);
        $stmt->bindParam(':priority', $newData['priority']);
        $stmt->bindParam(':status', $newData['status']);
        return $stmt->execute();
    }

    public function taskDelete($taskId) {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }
}