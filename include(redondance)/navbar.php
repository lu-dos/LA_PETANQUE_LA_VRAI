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
        <?php if (!empty($_SESSION['Id_utilisateur']) && empty($_SESSION['isAdmin'])): ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/profil.php">Mon Profil</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/historique.php">Mes Réservations</a>
        <?php endif; ?>
        <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/utilisateurs.php">Gérer les utilisateurs</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/reservations.php">Gérer les réservations</a>
        <?php endif; ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/quisommesnous.php">Qui sommes-nous ?</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/contact.php">Contacter le Créateur</a>

    </div>
    <div>
    
<?php if (isset($_SESSION['Id_utilisateur'])): ?>
    <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/logout.php" class="logout-button">Se Déconnecter</a>
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