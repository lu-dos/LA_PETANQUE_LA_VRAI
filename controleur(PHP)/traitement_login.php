<?php

include $_SERVER['DOCUMENT_ROOT'] . "/LA_PETANQUE_LA_VRAI/modele(SQL)/admin/db.php" ;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
}

$check_all = $connexion -> prepare ("SELECT * FROM utilisateur WHERE mail = ? AND mot_de_passe = ?");
$check_all->bind_param ("ss" , $mail, $mdp);
$check_all->execute();
$result = $check_all->get_result();





if($result->num_rows > 0 ){
    echo"<script>alert('Connexion réussie !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php';</script>";
}else{
    echo"<script>alert('Mail et/ou mot de passe incorrecte !');window.location.href = '/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php';</script>";
}

?>