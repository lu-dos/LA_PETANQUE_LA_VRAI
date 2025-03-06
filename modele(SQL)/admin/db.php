<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tablepetanque";

$connexion = new mysqli(hostname:$servername , password:$password, username:$username,database:$dbname);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

?>