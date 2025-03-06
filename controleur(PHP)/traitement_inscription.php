<?php


include $_SERVER['DOCUMENT_ROOT'] . "/LA_PETANQUE_LA_VRAI/modele(SQL)/admin/db.php" ;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $mail = trim($_POST["mail"]);
    $ville = trim($_POST["ville"]);
    $mdp = trim($_POST["mdp"]);

    //trim : eviter les errreures à cause des espaces 



    $check_mail = $connexion -> prepare ("SELECT Id_utilisateur FROM utilisateur WHERE mail = ?");
    $check_mail->bind_param ("s" , $mail);
    $check_mail->execute();
    $result = $check_mail->get_result();


    if($result->num_rows > 0){
        echo"<script>alert('Mail deja existant !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php';</script>";
    }else{
        $stmt=$connexion->prepare("INSERT INTO utilisateur (nom,prenom,mail,ville,mot_de_passe) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$nom,$prenom,$mail,$ville,$mdp);
    
    if($stmt->execute()){
        echo"<script>alert('Inscrition réussie, vous pouvez maintenant vous connecter !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';</script>";
    }
    else{
        echo"<script>alert('Inscription échouée !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php';</script>";
    }

    $stmt->close();

    }

    $check_mail->close();
}

$connexion->close();


?>