<?php
namespace Models;

use App\Database;

class BillingModel {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}