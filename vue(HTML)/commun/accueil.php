<!DOCTYPE html>
<html lang="fr">
<head>

        <base href="/LA_PETANQUE_LA_VRAI/">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta charset="utf-8">    
        <title>Réserve ta pétanque Lorraine</title>
    </head>
<body>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
        ?> 

<section class="hero">
    <h1>Réserve ta pétanque .com</h1>
    <a href="reservation.php" class="btn">Réserver maintenant</a>
</section>


<section class="hero-section">
    <div class="hero_slider">
        <div class="slide active">
            <img src="IMG/hero1.jpg" alt="boules sur terrain">
            <div class="slide-texte">
                <h1>Des terrains de pétanque à réserver</h1>
                <p>Réservez votre terrain</p>
            </div>
        </div>

        <div class="slide">
            <img src="images/hero2.jpg" alt="Terrain de pétanque 2">
            <div class="slide-text">
                <h1>Un concept original</h1>
            <p>Une idée fun pour animer vos soirées</p>
        </div>

           <!-- Flèches de navigation (optionnel) -->
      <div class="arrow prev">&#10094;</div>
      <div class="arrow next">&#10095;</div>
    </div>

</section>

<ul class="nav-links">
        <li><a href="#quisommesnous">Qui sommes-nous ?</a></li>
        <li><a href="#temoignages">Ils parlent de nous</a></li>
        <li><a href="#blog">Blog</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>

      <div class="social-links">
        <a href="#" class="linkedin">LinkedIn</a>
        <a href="#" class="instagram">Instagram</a>
      </div>





</body>

<footer>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
        ?> 
</footer>

</html>
