<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();

header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php');
exit;
?>
