<?php
namespace App;

class Database {
    protected $cnx;
    protected $host = 'localhost';
    protected $db = 'nowtes';
    protected $login = 'hcairo';
    protected $pw = '2807';
    
    public function __construct() {
        $this->cnx = new \PDO("mysql:host=$this->host;dbname=$this->db", $this->login, $this->pw);
        $this->cnx->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->cnx;
    }
}
?>
