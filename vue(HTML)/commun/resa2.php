<?php
// Initialise the session to check user privileges
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php';

try {
    $conn = getPDO();

    // Récupération des filtres éventuels
    $villeFilter = $_GET['ville'] ?? '';
    $typeFilter  = $_GET['type'] ?? '';

    $sql = "SELECT * FROM terrain WHERE 1";
    $params = [];
    if ($villeFilter !== '') {
        $sql .= " AND ville LIKE :ville";
        $params[':ville'] = "%{$villeFilter}%";
    }
    if ($typeFilter !== '') {
        $sql .= " AND type_terrain = :type";
        $params[':type'] = $typeFilter;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // recup des resultats
    $terrains = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Liste des types pour le filtre
    $typeStmt = $conn->query("SELECT DISTINCT type_terrain FROM terrain");
    $types = $typeStmt->fetchAll(PDO::FETCH_COLUMN);
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

        .filters {
            margin: 15px 0;
        }

        .filters form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
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

    <div class="filters">
        <form method="GET">
            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($villeFilter) ?>">
            <label for="type">Type:</label>
            <select id="type" name="type">
                <option value="">Tous</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= htmlspecialchars($type) ?>" <?= $type === $typeFilter ? 'selected' : '' ?>><?= htmlspecialchars($type) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrer</button>
        </form>
    </div>

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
        var map = L.map('map').setView([46.651562, 1.966979], 5);

        

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
            var popupContent = '<b>' + terrain.nom_terrain + '</b><br>' +
                'Ville: ' + terrain.ville + '<br>' +
                'Type: ' + terrain.type_terrain + '<br>' +
                '<a href="reserver.php?id=' + terrain.Id_Terrain + '">Réserver</a>';
            L.marker([terrain.latitude, terrain.longitude], {icon: icone})
                .addTo(map)
                .bindPopup(popupContent);
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