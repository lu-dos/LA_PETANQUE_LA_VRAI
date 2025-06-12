<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/reservation.php';
$pdo = getDbConnection();

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM reservation WHERE Id_reservation = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: reservations.php');
    exit();
}

$sql = 'SELECT r.*, t.nom_terrain, u.nom, u.Prenom FROM reservation r
        JOIN terrain t ON r.Id_Terrain = t.Id_Terrain
        JOIN utilisateur u ON r.Id_utilisateur = u.Id_utilisateur';
$reservations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des réservations</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<h1>Gestion des réservations</h1>
<table>
    <thead>
        <tr>
            <th>Terrain</th>
            <th>Du</th>
            <th>Au</th>
            <th>Utilisateur</th>
            <th>Nb Util.</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($reservations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['nom_terrain']) ?></td>
            <td><?= htmlspecialchars($r['date_debut']) ?></td>
            <td><?= htmlspecialchars($r['date_fin']) ?></td>
            <td><?= htmlspecialchars($r['nom'] . ' ' . $r['Prenom']) ?></td>
            <td><?= htmlspecialchars($r['nbr_util']) ?></td>
            <td><a href="reservations.php?delete=<?= $r['Id_reservation'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
