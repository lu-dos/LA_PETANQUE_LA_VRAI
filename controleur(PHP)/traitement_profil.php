<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['Id_utilisateur'])) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php';
$pdo = getPDO();

$userId = (int) $_SESSION['Id_utilisateur'];

// Retrieve current password hash
$stmt = $pdo->prepare('SELECT mot_de_passe FROM utilisateur WHERE Id_utilisateur = ?');
$stmt->execute([$userId]);
$currentData = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$currentData) {
    echo "<script>alert('Utilisateur introuvable'); window.location.href='/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';</script>";
    exit();
}

$nom    = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$mail   = trim($_POST['mail'] ?? '');
$currentPassword = $_POST['current_password'] ?? '';
$newPassword     = $_POST['new_password'] ?? '';

// Update basic info
$stmt = $pdo->prepare('UPDATE utilisateur SET nom = ?, Prenom = ?, mail = ? WHERE Id_utilisateur = ?');
$stmt->execute([$nom, $prenom, $mail, $userId]);

// Update session values
$_SESSION['nom'] = $nom;
$_SESSION['Prenom'] = $prenom;

// Handle password change when new password provided
if ($newPassword !== '') {
    // Verify current password
    $valid = password_verify($currentPassword, $currentData['mot_de_passe']) || $currentPassword === $currentData['mot_de_passe'];
    if (!$valid) {
        echo "<script>alert('Mot de passe actuel incorrect'); window.history.back();</script>";
        exit();
    }
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE utilisateur SET mot_de_passe = ? WHERE Id_utilisateur = ?');
    $stmt->execute([$hash, $userId]);
}

echo "<script>alert('Profil mis à jour'); window.location.href='/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/profil.php';</script>";
?>
