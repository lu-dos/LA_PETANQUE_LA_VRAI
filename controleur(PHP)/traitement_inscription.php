<?php
/* ───────── Connexion BDD ───────── */
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php';
$pdo = getPDO();

/* ───────── Formulaire soumis ? ───────── */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* Sécurisation & nettoyage */
    $nom    = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $mail   = trim($_POST["mail"]);
    $ville  = trim($_POST["ville"]);
    $mdp    = password_hash(trim($_POST["mdp"]), PASSWORD_DEFAULT); // hachage

    /* ───── Vérifier l'unicité de l'email ───── */
    $check_mail = $pdo->prepare(
        "SELECT Id_utilisateur FROM utilisateur WHERE mail = ?"
    );
    $check_mail->execute([$mail]);
    $result = $check_mail->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        /* Mail déjà pris → retour accueil */
        echo "<script>
                alert('Adresse e-mail déjà utilisée !');
                window.location.href =
                    '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php';
              </script>";
        exit;
    }

    /* ───── Insertion du nouvel utilisateur ───── */
    $stmt = $pdo->prepare(
        "INSERT INTO utilisateur (nom, prenom, mail, ville, isAdmin, mot_de_passe) VALUES (?,?,?,?,?,?)"
    );

    $isAdmin = 0; // 0 = simple utilisateur, 1 = admin

    if ($stmt->execute([$nom, $prenom, $mail, $ville, $isAdmin, $mdp])) {
        echo "<script>
                alert('Inscription réussie, vous pouvez maintenant vous connecter !');
                window.location.href =
                    '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';
              </script>";
    } else {
        echo "<script>
                alert('Inscription échouée !');
                window.location.href =
                    '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php';
              </script>";
    }

    $check_mail = null;
    $stmt = null;
}
$pdo = null;
?>
