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
        $pdo = $this->db->getConnection()->prepare($query);
        $pdo->execute();
        return $pdo->fetchAll(\PDO::FETCH_ASSOC);
    }
}