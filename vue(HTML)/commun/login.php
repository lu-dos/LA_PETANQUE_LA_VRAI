<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Inscription</title>
        <base href="/LA_PETANQUE_LA_VRAI/">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <meta charset="utf-8">

<style>



</style>

    </head>

    <body>

        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
        ?> 
        
        <form action="/LA_PETANQUE_LA_VRAI/controleur(PHP)/traitement_login.php" method="POST">
            <fieldset>

            <legend>Connexion</legend>

            <label>Mail</label><input type="email" name="mail" placeholder="Votre Mail ici"/> <br>
            <label>Mot de passe</label><input type="password" name="mdp" placeholder="Votre prénom ici"/> <br>
            <input type="submit" value="Valider">
            
            </fieldset>

        </form>




    </body>

    <footer>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
        ?> 
</footer>

</html>