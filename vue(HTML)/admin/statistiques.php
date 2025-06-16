<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

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

$totalUsers = $pdo->query('SELECT COUNT(*) FROM utilisateur')->fetchColumn();
$totalAdmins = $pdo->query('SELECT COUNT(*) FROM utilisateur WHERE isAdmin = 1')->fetchColumn();

$citiesStmt = $pdo->query('SELECT ville, COUNT(*) AS nbr FROM utilisateur GROUP BY ville ORDER BY nbr DESC LIMIT 5');
$cities = $citiesStmt->fetchAll(PDO::FETCH_ASSOC);

$resStmt = $pdo->query('SELECT u.nom, u.Prenom, COUNT(r.Id_reservation) AS nbr FROM utilisateur u LEFT JOIN reservation r ON u.Id_utilisateur = r.Id_utilisateur GROUP BY u.Id_utilisateur ORDER BY nbr DESC LIMIT 5');
$reservers = $resStmt->fetchAll(PDO::FETCH_ASSOC);
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
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
