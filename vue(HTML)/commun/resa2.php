<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Interactive</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- <link rel="stylesheet" type="text/css" href="css/index.css"> -->

    <!-- <style>
        #map {
            height: 600px;
            width: 100%;
        }
        .navbar, .footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style> -->
</head>
<body>
    <div class="navbar">
        <h1>Navbar</h1>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Carte</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div id="map"></div>

    <div class="footer">
        <p>&copy; 2023 La Pétanque La Vraie. Tous droits réservés.</p>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            .openPopup();
    </script>
</body>
<footer>
        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
        ?> 
</footer>
</html>
</script>
</div>
</head>