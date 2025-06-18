<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Restrict access to logged in non-admin users
// if (empty($_SESSION['Id_utilisateur']) || (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) {
//     header('Location: login.php');
//     exit();
// }

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/reservation.php';
$pdo = getDbConnection();

$stmt = $pdo->prepare('SELECT nom, Prenom, mail FROM utilisateur WHERE Id_utilisateur = ?');
$stmt->execute([$_SESSION['Id_utilisateur']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo 'Utilisateur introuvable';
    exit();
}
?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Mon Profil</h1>
    <div class="card">
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['Prenom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['mail']) ?></p>


    </div>
</div>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
