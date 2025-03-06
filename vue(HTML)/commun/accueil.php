<!DOCTYPE html>
<html lang="fr">
<head>

        <base href="/LA_PETANQUE_LA_VRAI/">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <meta charset="utf-8">    
        <title>La Pétanque en Lorraine</title>
    </head>
<body>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
        ?> 

<section class="hero">
    <h1>Réserve ta pétanque .com</h1>
    <a href="reservation.php" class="btn">Réserver maintenant</a>
</section>

<section class="terrains">
    <h2>Terrains disponibles</h2>
    <div id="map"></div> <!-- Carte interactive -->
</section>

<footer>
    <p>© 2024 Réserve ta Pétanque. Tous droits réservés.</p>
</footer>

</body>
</html>
