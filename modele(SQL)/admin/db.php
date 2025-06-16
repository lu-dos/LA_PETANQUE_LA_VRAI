<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "tablepetanque";

// Crée la connexion et l'expose sous le nom $connexion
$connexion = new mysqli($servername, $username, $password, $dbname);

// Vérifie les erreurs de connexion et lance une exception descriptive si besoin
if ($connexion->connect_error) {
    throw new \RuntimeException(
        "Échec de la connexion à la base de données : " . $connexion->connect_error
    );
}

?>