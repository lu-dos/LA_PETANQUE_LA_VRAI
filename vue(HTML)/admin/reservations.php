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

// Delete reservation
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM reservation WHERE Id_reservation = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/reservations.php');
    exit();
}

// Reservation to edit
$editReservation = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM reservation WHERE Id_reservation = ?');
    $stmt->execute([$_GET['edit']]);
    $editReservation = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];
    $nbrUtil = (int)$_POST['nbr_util'];
    $stmt = $pdo->prepare('UPDATE reservation SET date_debut=?, date_fin=?, nbr_util=? WHERE Id_reservation=?');
    $stmt->execute([$dateDebut, $dateFin, $nbrUtil, $id]);
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/reservations.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des réservations</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
<h1>Gestion des réservations</h1>
<?php if ($editReservation): ?>
<h2>Modifier une réservation</h2>
<div class="card">
<form method="POST" action="">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($editReservation['Id_reservation']) ?>">
    <label>Date de début</label>
    <input type="datetime-local" name="date_debut" value="<?= htmlspecialchars($editReservation['date_debut']) ?>" required><br>
    <label>Date de fin</label>
    <input type="datetime-local" name="date_fin" value="<?= htmlspecialchars($editReservation['date_fin']) ?>" required><br>
    <label>Nombre d'utilisateurs</label>
    <input type="number" name="nbr_util" min="1" value="<?= htmlspecialchars($editReservation['nbr_util']) ?>" required><br>
    <button class="button" type="submit">Mettre à jour</button>
</form>
</div>
<?php endif; ?>
<div class="card">
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
            <td>
                <a class="button" href="vue(HTML)/admin/reservations.php?delete=<?= $r['Id_reservation'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
                |
                <a class="button" href="vue(HTML)/admin/reservations.php?edit=<?= $r['Id_reservation'] ?>">Modifier</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
