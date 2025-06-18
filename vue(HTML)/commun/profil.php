<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect visitors who are not logged in
if (empty($_SESSION['Id_utilisateur'])) {
    header('Location: login.php');
    exit();
}

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
        <form method="POST" action="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/controleur(PHP)/traitement_profil.php">
            <label>Nom</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required><br>
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($user['Prenom']) ?>" required><br>
            <label>Mail</label>
            <input type="email" name="mail" value="<?= htmlspecialchars($user['mail']) ?>" required><br>
            <hr>
            <label>Mot de passe actuel</label>
            <input type="password" name="current_password"><br>
            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password"><br>
            <input type="submit" value="Mettre à jour">
        </form>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
