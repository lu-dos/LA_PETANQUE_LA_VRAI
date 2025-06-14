<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['Id_utilisateur'])) {
    header('Location: login.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/reservation.php';
$pdo = getDbConnection();

$terrainId = $_GET['id'] ?? '';
if (!$terrainId) {
    echo 'Aucun terrain sélectionné.';
    exit();
}

// Fetch terrain details
$stmt = $pdo->prepare('SELECT * FROM terrain WHERE Id_Terrain = ?');
$stmt->execute([$terrainId]);
$terrain = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$terrain) {
    echo 'Terrain introuvable';
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateDebut = $_POST['date_debut'] ?? '';
    $dateFin = $_POST['date_fin'] ?? '';
    $nbrUtil = (int)($_POST['nbr_util'] ?? 1);

    if (strtotime($dateFin) <= strtotime($dateDebut)) {
        $message = 'La date de fin doit être supérieure à la date de début';
    } elseif (!isTerrainAvailable($pdo, $terrainId, $dateDebut, $dateFin)) {
        $message = 'Ce terrain est déjà réservé pour cette période';
    } else {
        createReservation($pdo, $terrainId, $_SESSION['Id_utilisateur'], $dateDebut, $dateFin, $nbrUtil);
        $message = 'Réservation enregistrée !';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
<div class="card">
<h1>Réserver le terrain: <?= htmlspecialchars($terrain['nom_terrain']) ?></h1>
<?php if ($message) echo '<p>' . htmlspecialchars($message) . '</p>'; ?>
<form method="POST">
    <label for="date_debut">Date de début</label>
    <input type="datetime-local" id="date_debut" name="date_debut" required><br>
    <label for="date_fin">Date de fin</label>
    <input type="datetime-local" id="date_fin" name="date_fin" required><br>
    <label for="nbr_util">Nombre d\'utilisateurs</label>
    <input type="number" id="nbr_util" name="nbr_util" value="1" min="1" required><br>
    <button class="button" type="submit">Réserver</button>
</form>
</div>
</div>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
