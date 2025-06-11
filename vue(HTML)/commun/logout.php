<?php
session_start();
session_unset();
session_destroy();
header('Location: /LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php');
exit();
?>
