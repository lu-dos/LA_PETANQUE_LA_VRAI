<?php
// Start the session if it is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables and destroy the session
$_SESSION = [];
session_destroy();

// Redirect to the homepage after logout
header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php');
exit();
?>
