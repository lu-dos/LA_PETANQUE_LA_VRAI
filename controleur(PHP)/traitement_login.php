<?php
// Start or resume the session so we can store the
// authenticated user information.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/include(redondance)/init.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST["mail"] ?? '';
    $mdp  = $_POST["mdp"]  ?? '';
}

// Retrieve user info by email only. We'll verify the password manually so that
// both hashed and legacy plain text passwords are supported.
$stmt = $pdo->prepare(
    "SELECT Id_utilisateur, nom, Prenom, mot_de_passe, isAdmin
     FROM utilisateur WHERE mail = ?"
);
$stmt->execute([$mail]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$authenticated = false;
if ($row) {
    // Verify using password_verify for hashed passwords. Fallback to direct
    // comparison for older accounts stored in plain text.
    if (password_verify($mdp, $row['mot_de_passe']) || $mdp === $row['mot_de_passe']) {
        $_SESSION['Id_utilisateur'] = $row['Id_utilisateur'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['Prenom'] = $row['Prenom'];
        $_SESSION['isAdmin'] = (int) $row['isAdmin'];
        $authenticated = true;
    }
}

if($authenticated){
    echo"<script>alert('Connexion réussie !');window.location.href = '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php';</script>";
}else{
    echo"<script>alert('Mail et/ou mot de passe incorrecte !');window.location.href = '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';</script>";
}

?>