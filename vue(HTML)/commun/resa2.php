<?php
// Initialise the session to check user privileges
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = 'localhost';
$dbname = 'tablepetanque';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // requete pour recup tous les terrains
    $sql = "SELECT * FROM terrain";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // recup des resultats 
    $terrains = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Terrain</title>
    <link rel="stylesheet" href="rstyle.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- #region css -->
    <style>
        #map {
            height: 600px;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            padding: 10px;
            display: flex;
            align-items: center;
            width: 100%;
            /* pour que barre de navigation prenne toute la largeur */
        }

        .navbar .links {
            display: flex;
            justify-content: center;
            /* centrer les liens dans la barre */
        }

        .navbar a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        #map {
            height: 600px;
            width: 100%;
        }
    </style>
    <!-- #endregion -->
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
    ?>
    <!-- #region Carte -->
    <!-- Carte -->
    <div id="map"></div>

    <table>
        <thead>
            <tr>
                <th>Nom du Terrain</th>
                <th>Ville</th>
                <th>Type</th>
                <th>État</th>
                <th>Note</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Réserver</th>
                <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($terrains as $terrain): ?>
                <tr>
                    <td><?= htmlspecialchars($terrain['nom_terrain']) ?></td>
                    <td><?= htmlspecialchars($terrain['ville']) ?></td>
                    <td><?= htmlspecialchars($terrain['type_terrain']) ?></td>
                    <td><?= htmlspecialchars($terrain['etat']) ?></td>
                    <td><?= htmlspecialchars($terrain['note']) ?></td>
                    <td><?= htmlspecialchars($terrain['latitude']) ?></td>
                    <td><?= htmlspecialchars($terrain['longitude']) ?></td>
                    <td><a href="reserver.php?id=<?= $terrain['Id_Terrain'] ?>">Réserver</a></td>
                    <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
                    <td>
                        <a href="modifier.php?id=<?= $terrain['Id_Terrain'] ?>">Modifier</a> |
                        <a href="supprimer.php?id=<?= $terrain['Id_Terrain'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce terrain ?')">Supprimer</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bouton Ajouter -->
    <?php if (!empty($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
    <div style="margin-top: 20px;">
        <a href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/admin/ajouter.php" style="padding: 10px 15px; background-color: green; color: white; text-decoration: none; border-radius: 5px;">Ajouter un Terrain</a>
    </div>
    <?php endif; ?>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // initialisation de la carte 
        var map = L.map('map').setView([48.6921, 6.1844], 10);

        // Ajouter la couche OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var icone = L.icon({
            iconUrl: '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/IMG/PIN.svg',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        })

        // ajout des marqueurs pour chaque terrain
        var terrains = <?= json_encode($terrains) ?>;
        terrains.forEach(function(terrain) {
            L.marker([terrain.latitude, terrain.longitude])
                .addTo(map)
                .bindPopup(terrain.nom_terrain);
        });
    </script>
    <!-- #endregion -->

</body>
<footer>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>

</html>