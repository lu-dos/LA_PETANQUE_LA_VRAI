<?php

/**
 * Simple database configuration file used by the PHP controllers.
 *
 * The previous implementation attempted to expose a `$connexion` variable
 * through a `db` class, but the constructor name was misspelled and the
 * variable was not returned or exported, resulting in `$connexion` being
 * `null` in the controllers.  This file now simply initialises a `mysqli`
 * connection and exposes it via the `$connexion` variable so that the
 * controllers can include this file directly.
 */

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "tablepetanque";

// Create the connection and expose it as $connexion
$connexion = new mysqli($servername, $username, $password, $dbname);

// Check connection errors and throw a descriptive exception if needed
if ($connexion->connect_error) {
    throw new \RuntimeException(
        "Database connection failed: " . $connexion->connect_error
    );
}

?>