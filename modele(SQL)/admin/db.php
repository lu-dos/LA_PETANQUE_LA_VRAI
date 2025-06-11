<?php
class db {
    private $servername = 'localhost';
    private $username = 'ludo';
    private $password = 'Bonjour123!';
    private $dbname = 'ludo_ppe2';
    private $connexion;

    public function __construct() {
        $this->connexion = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        );

        if ($this->connexion->connect_error) {
            die('Connection failed: ' . $this->connexion->connect_error);
        }
    }

    public function getConnection() {
        return $this->connexion;
    }
}

// Crée une connexion lorsqu'on inclut ce fichier
$connexion = (new db())->getConnection();
?>
