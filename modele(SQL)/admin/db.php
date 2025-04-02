<?php

class db{

private $servername = "localhost";
private $username = "root";
private $password = "";
private $dbname = "tablepetanque";

public function __contrcut(){
    
$connexion = new mysqli(hostname:$this->servername , password:$this->password, username:$this->username,database:$this->dbname);
}

}
?>