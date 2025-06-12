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

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tablepetanque';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

$stmt = $pdo->prepare('DELETE FROM terrain WHERE Id_Terrain = ?');
$stmt->execute([$terrainId]);

header('Location: resa2.php');
exit();
?>
