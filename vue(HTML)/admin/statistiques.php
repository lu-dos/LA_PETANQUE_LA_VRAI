<?php
// Démarre la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Redirige si l'utilisateur n'est pas administrateur
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}
// Inclut les fonctions de statistiques
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/admin/statistiques.php';
$pdo = getPDO();

// Récupère toutes les statistiques nécessaires via les fonctions dédiées
$totalUsers      = fetchTotalUsers($pdo);
$totalAdmins     = fetchTotalAdmins($pdo);

// Statistiques sur les terrains
$totalTerrains    = fetchTotalTerrains($pdo);
$reservedTerrains = fetchReservedTerrains($pdo);
$occupationRate   = tauxOccupationTerrain($pdo);
$percentReserved  = round($occupationRate * 100, 2);

$cities     = fetchTopCities($pdo, 5);
$reservers  = fetchTopReservers($pdo, 5);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Utilisateurs</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Statistiques Utilisateurs</h1>
    <div class="card">
        <p>Nombre total d'utilisateurs : <?= htmlspecialchars($totalUsers) ?></p>
        <p>Nombre d'administrateurs : <?= htmlspecialchars($totalAdmins) ?></p>
    </div>

    <h2>Statistiques Terrains</h2>
    <div class="card">
        <p>Nombre total de terrains : <?= htmlspecialchars($totalTerrains) ?></p>
        <p>Terrains réservés : <?= htmlspecialchars($reservedTerrains) ?></p>
        <p>Pourcentage de terrains réservés : <?= htmlspecialchars($percentReserved) ?>%</p>
    </div>

    <h2>Villes les plus représentées</h2>
    <div class="card">
        <table>
            <thead>
                <tr><th>Ville</th><th>Utilisateurs</th></tr>
            </thead>
            <tbody>
                <?php foreach ($cities as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['ville']) ?></td>
                    <td><?= htmlspecialchars($c['nbr']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <h2>Top réservants</h2>
    <div class="card">
        <table>
            <thead>
                <tr><th>Utilisateur</th><th>Nombre de réservations</th></tr>
            </thead>
            <tbody>
                <?php foreach ($reservers as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nom'] . ' ' . $r['Prenom']) ?></td>
                    <td><?= htmlspecialchars($r['nbr']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
