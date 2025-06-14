<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Se Connecter</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
    ?>

    <form action="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/controleur(PHP)/traitement_login.php" method="POST">
        <fieldset>

            <legend>Connexion</legend>

            <label>Mail</label><input type="email" name="mail" placeholder="Votre Mail ici" /> <br>
            <label>Mot de passe</label><input type="password" name="mdp" placeholder="Votre prénom ici" /> <br>
            <input type="submit" value="Valider">

        </fieldset>

    </form>




</body>

<footer>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>

</html>