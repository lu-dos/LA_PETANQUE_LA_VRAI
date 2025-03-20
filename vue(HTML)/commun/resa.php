<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Footer</title>
    <link rel="stylesheet" href="style.css"> 
    <title>Réserve ton terrain</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <!-- obligé de mettre le css  -->
<style>
#macarte{
height: 400px;
}

footer {
    background-color:rgb(121, 127, 132);
    text-align: center;
    padding: 20px;
  }
</style>

</head>
<body>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
        ?> 

<div id="macarte"></div>

<!-- Fichier java script -->    
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

     <script>
        var carte = L.map('macarte').setView([48.90, 6.18], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '©️ OpenStreetMap contributors',
            minZoom: 1,
            maxZoom: 20
        }).addTo(carte);
    </script>
    

</body>
<footer>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>
</html>