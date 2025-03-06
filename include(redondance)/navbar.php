<div class="navbar">
    <div class="links">
        <a href="/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php">Accueil</a>
            <a href="reservation.php">Réserver un Terrain</a>
            <a href="contact.php">Contacter le Créateur</a>
    </div>
    <div>
            <a href="/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php" class="btn-connexion">Se Connecter</a>
            <a href="/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/index.php" class="btn-inscription">S'inscrire</a>
    </div>
</div>

<style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    .navbar {
        background-color: #333;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        box-sizing: border-box;
    }
    .navbar .links {
        display: flex;
    }
    .navbar a, .logout-button {
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
    .navbar .links a:hover, .logout-button:hover {
        background-color: #555;
        border-radius: 5px;
    }
</style>
