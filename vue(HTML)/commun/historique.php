<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Restrict access to logged in non-admin users
if (empty($_SESSION['Id_utilisateur']) || (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) {
    header('Location: login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/reservation.php';
$pdo = getDbConnection();

$userId = $_SESSION['Id_utilisateur'];
// Handle reservation cancellation
if (isset($_GET['delete'])) {
    deleteReservation($pdo, $_GET['delete'], $userId);
    header('Location: historique.php');
    exit();
}

$reservations = getReservationsForUser($pdo, $userId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Mes Réservations</h1>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Terrain</th>
                    <th>Du</th>
                    <th>Au</th>
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
                    <td><?= htmlspecialchars($r['nbr_util']) ?></td>
                    <td>
                        <a class="button" href="vue(HTML)/commun/historique.php?delete=<?= urlencode($r['Id_reservation']) ?>" onclick="return confirm('Annuler cette réservation ?');">Annuler</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
