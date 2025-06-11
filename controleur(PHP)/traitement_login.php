<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/LA_PETANQUE_LA_VRAI/modele(SQL)/admin/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = trim($_POST["mail"]);
    $mdp  = trim($_POST["mdp"]);

    $check_all = $connexion->prepare(
        "SELECT Id_utilisateur FROM utilisateur WHERE mail = ? AND mot_de_passe = ?"
    );
    $check_all->bind_param("ss", $mail, $mdp);
    $check_all->execute();
    $result = $check_all->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['Id_utilisateur'] = $row['Id_utilisateur'];
        echo "<script>alert('Connexion réussie !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php';</script>";
    } else {
        echo "<script>alert('Mail et/ou mot de passe incorrect !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';</script>";
    }

    $check_all->close();
    $connexion->close();
} else {
    header('Location: /LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}
?>
