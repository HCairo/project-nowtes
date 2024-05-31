<?php
namespace Models;

use App\Database;

class TasksModel {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function taskRetrieve() {
        $query = "SELECT * FROM task";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}