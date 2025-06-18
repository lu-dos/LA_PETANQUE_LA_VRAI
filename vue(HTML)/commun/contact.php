<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacter le Créateur</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
    <div class="container">
        <div class="card">
        <h1>Contacter le Créateur</h1>
        <p>N'hésitez pas à nous laisser un message pour toute question ou suggestion ou demande d'ajout de terrain.</p>
        <form action="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/controleur(PHP)/traitement_contact.php" method="POST" enctype="multipart/form-data">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button class="button" type="submit">Envoyer</button>
        </form>
        </div>
    </div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>