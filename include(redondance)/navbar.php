<?php
// Ensure a session is started so that authentication
// information like `Id_utilisateur` and `isAdmin` is
// available to all views including this navbar.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="navbar">
    <div class="links">
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php">Accueil</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/resa2.php">Réserver un Terrain</a>
        <a href="quisommesnous.php">Qui sommes-nous ?</a>
        <a href="contact.php">Contacter le Créateur</a>

    </div>
    <div>
    
<?php if (isset($_SESSION['Id_utilisateur'])): ?>
    <!-- Affiche un simple lien de d\xE9connexion lorsque l'utilisateur est connect\xE9 -->
    <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/logout.php" class="logout-button">Se D\xE9connecter</a>
<?php else: ?>
    <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php" class="btn-connexion">Se Connecter</a>
    <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/inscription.php" class="btn-inscription">S'inscrire</a>
<?php endif; ?>
       

    </div>

</div>

<style>
    body,
    html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .navbar {
        background-color: #333;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        box-sizing: border-box;
    }

    .navbar .links {
        display: flex;
    }

    .navbar a,
    .logout-button {
        color: white;
        margin: 0 15px;
        text-decoration: none;
        font-size: 17px;
    }

    .logout-button {
        background: none;
        border: none;
        cursor: pointer;
        color: white;
    }

    .navbar .links a:hover,
    .logout-button:hover {
        background-color: #555;
        border-radius: 5px;
    }
</style>