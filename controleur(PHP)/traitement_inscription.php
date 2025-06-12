<?php
/* ───────── Connexion BDD ───────── */
include $_SERVER['DOCUMENT_ROOT'] .
        "/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/admin/db.php";

/* ───────── Formulaire soumis ? ───────── */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* Sécurisation & nettoyage */
    $nom    = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $mail   = trim($_POST["mail"]);
    $ville  = trim($_POST["ville"]);
    $mdp    = password_hash(trim($_POST["mdp"]), PASSWORD_DEFAULT); // hachage

    /* ───── Vérifier l'unicité de l'email ───── */
    $check_mail = $connexion->prepare(
        "SELECT Id_utilisateur
           FROM utilisateur
          WHERE mail = ?"
    );
    $check_mail->bind_param("s", $mail);
    $check_mail->execute();
    $result = $check_mail->get_result();

    if ($result->num_rows > 0) {
        /* Mail déjà pris → retour accueil */
        echo "<script>
                alert('Adresse e-mail déjà utilisée !');
                window.location.href =
                    '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php';
              </script>";
        exit;
    }

    /* ───── Insertion du nouvel utilisateur ───── */
    $stmt = $connexion->prepare(
        "INSERT INTO utilisateur
             (nom, prenom, mail, ville, isAdmin, mot_de_passe)
         VALUES (?,?,?,?,?,?)"
    );

    $isAdmin = 0;                 // 0 = simple utilisateur, 1 = admin
    $stmt->bind_param(
        "ssssis",
        $nom, $prenom, $mail, $ville, $isAdmin, $mdp
    );

    if ($stmt->execute()) {
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

    $stmt->close();
    $check_mail->close();
}

$connexion->close();
?>
