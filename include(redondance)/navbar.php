<?php
// Ensure a session is started so that authentication
// information like `Id_utilisateur` and `isAdmin` is
// available to all views including this navbar.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/mail.php';
$pdo = getPDO();
$unreadCount = 0;
if (!empty($_SESSION['Id_utilisateur'])) {
    $unreadCount = getUnreadCount($pdo, (int)$_SESSION['Id_utilisateur']);
}
?>
<div class="navbar">
    <div class="links">
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php">Accueil</a>
        

        <?php if (!empty($_SESSION['Id_utilisateur']) && empty($_SESSION['isAdmin'])): ?>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/resa2.php">Réserver un Terrain</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/historique.php">Mes Réservations</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/mailbox.php" class="message-link">Mes Messages<?php if ($unreadCount > 0): ?><span class="notif-badge"><?= $unreadCount ?></span><?php endif; ?></a>
        <?php endif; ?>

<?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
        <div class="dropdown">
            <a href="javascript:void(0)" class="dropbtn" id="siteManagerBtn">Gérer le site</a>
            <div class="dropdown-content" id="siteManagerMenu">
                <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/resa2.php">Gérer les terrains</a>
                <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/utilisateurs.php">Gérer les utilisateurs</a>
                <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/reservations.php">Gérer les réservations</a>
                <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/mails.php">Gérer les mails</a>
                <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/avis.php">Gérer les avis</a>
            </div>
        </div>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/statistiques.php">Statistiques</a>
<?php endif; ?>

        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/quisommesnous.php">Qui sommes-nous ?</a>
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/avis.php">Donner votre avis</a>
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

    .message-link {
        position: relative;
    }

    .notif-badge {
        position: absolute;
        top: -8px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
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

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #333;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        flex-direction: column;
    }

    .dropdown-content a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #555;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
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
