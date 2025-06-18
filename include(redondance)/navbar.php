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
        

        <?php if (!empty($_SESSION['Id_utilisateur']) && empty($_SESSION['isAdmin'])): ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/resa2.php">Réserver un Terrain</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/historique.php">Mes Réservations</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/contact.php">Contacter le Créateur</a>
        <?php endif; ?>

        <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/resa2.php">Gérer les terrains</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/utilisateurs.php">Gérer les utilisateurs</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/reservations.php">Gérer les réservations</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/statistiques.php">Statistiques</a>
        <?php endif; ?>

        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/quisommesnous.php">Qui sommes-nous ?</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/profil.php">Mon Profil</a>

    </div>
    <div>

<?php if (isset($_SESSION['Id_utilisateur'])): ?>
    <span class="user-info">
        <?= htmlspecialchars(($_SESSION['Prenom'] ?? '') . ' ' . ($_SESSION['nom'] ?? '')) ?>
        (<?= ($_SESSION['isAdmin'] ?? 0) == 1 ? 'Admin' : 'Utilisateur' ?>)
    </span>
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
    .logout-button,
    .user-info {
        color: white;
        margin: 0 15px;
        text-decoration: none;
        font-size: 17px;
        display: inline-block;
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

    @media (max-width: 600px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar .links {
            flex-direction: column;
            width: 100%;
        }

        .navbar a,
        .logout-button {
            margin: 10px 0;
        }
    }
</style>