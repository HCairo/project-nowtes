<?php
namespace Models;

use App\Database;

class NotesModel {
    protected $db;

        public function __construct() {
            $this->db = new Database();
    }
}
