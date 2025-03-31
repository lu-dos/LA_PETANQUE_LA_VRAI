<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réserve ton terrain</title>
    <link rel="stylesheet" href="style.css">
    <title>Réserve ton terrain</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />

    <!-- obligé de mettre le css  -->


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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
    ?>

    <div id="macarte"></div>

    <!-- Fichier java script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="">

    </script>

    <script>
        var terrain = <?php echo (fliste_terrains($conn)); ?>;
        var tableauMarker = [];
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
            iconUrl: '/LA_PETANQUE_LA_VRAI/IMG/PIN.svg',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        })

        //mettre un point (marqueur)
        var marqueur = L.marker([48.90, 6.18], {
            icon: icone
        }).addTo(carte);

        //ajouter un popup
        marqueur.bindPopup('<b>Terrain de pétanque</b><br><img src="/LA_PETANQUE_LA_VRAI/IMG/terrain_petanque.jpg" alt="Terrain de pétanque" style="width:100px;height:auto;">');


        var marqueurs = L.markerClusterGroup();
        for (club in terrain) {
            //ajout d'un marqueur sur la carte et on lui donne un popup
            var marker = L.marker([terrain[club].lat, terrain[club].lon], {
                icon: icone
            });
            marker.bindPopup("<h1>" + club + "</h1> <a href='information_centre.php?id=" + terrain[club].id + "'>Plus d&apos;info</a>");
            marqueurs.addLayer(marker);
            tableauMarker.push(marker);

        }
        //on ajoute le groupe de marqueurs dans un groupe liflet
        var groupe = new L.featureGroup(tableauMarker);
        //on adapte le zoom au groupe
        carte.fitBounds(groupe.getBounds().pad(0.5));
        carte.addLayer(marqueurs);

        // let xmlhttp = new XMLHttpRequest();

        // xmlhttp.onreadystatechange = function() {
        //     //la transaction est terminée ?

        //     if (xmlhttp.readyState === 4) {
        //         //si la transaction est un succès 
        //         if (xmlhttp.status === 200) {
        //             //on traite les données recues
        //             console.log(xmlhttp.responseText);
        //         } else {
        //             console.log(xmlhttp.statusText);
        //         }
        //     }
        // };

        // xmlhttp.open("GET", "http://localhost/phpmyadmin/index.php");


        // xmlhttp.send(null);
    </script>



</body>
<footer>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>

</html>