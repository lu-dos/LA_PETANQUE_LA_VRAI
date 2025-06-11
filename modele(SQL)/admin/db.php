<?php

class db{

private $servername = "localhost";
private $username = "ludo";
private $password = "Bonjour123!";
private $dbname = "ludo_ppe2";

public function __contrcut(){
    
$connexion = new mysqli(hostname:$this->servername , password:$this->password, username:$this->username,database:$this->dbname);
}

}
?>