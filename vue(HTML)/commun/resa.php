<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réserve ton terrain</title>
    <link rel="stylesheet" href="style.css">

    <title>Réserve ton terrain</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />


    <style>
        #macarte {
            height: 400px;
        }

        footer {
            background-color: rgb(121, 127, 132);
            text-align: center;
            padding: 20px;
        }
    </style>

</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
    ?>

    <div id="macarte"></div>

    </script>


    <script>
        //initialiser la carte
        var carte = L.map('macarte').setView([48.90, 6.18], 8);

        //chaRger la carte
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

            //source de la carte
            attribution: '©️ OpenStreetMap contributors',

            //parametre zoom de la carte
            minZoom: 1,
            maxZoom: 20
        }).addTo(carte);

        //personnaliser le marqueur
        var icone = L.icon({
            iconUrl: '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/IMG/PIN.svg',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        })

        //mettre un point (marqueur)
        var marqueur = L.marker([48.90, 6.18], {
            icon: icone
        }).addTo(carte);

        //ajouter un popup
        marqueur.bindPopup('<b>Terrain de pétanque</b><br><img src="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/IMG/terrain_petanque.jpg" alt="Terrain de pétanque" style="width:100px;height:auto;">');
    </script>
    <!-- fichiers javascript de leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
</body>
<footer>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>

</html>