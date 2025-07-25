<?php
// Restrict page access to administrators only
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

if (empty($_GET['id'])) {
    echo 'Aucun identifiant de terrain fourni.';
    exit();
}

$terrainId = $_GET['id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php';
$pdo = getPDO();

$stmt = $pdo->prepare('DELETE FROM terrain WHERE Id_Terrain = ?');
$stmt->execute([$terrainId]);

header('Location: resa2.php');
exit();
?>
