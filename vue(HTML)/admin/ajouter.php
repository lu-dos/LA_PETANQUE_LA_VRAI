<?php
// Restrict page access to administrators only
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

// Connexion à la base de données
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php';
$pdo = getPDO();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ville = $_POST['ville'];
    $nom_terrain = $_POST['nom_terrain'];
    $type_terrain = $_POST['type_terrain'];
    $interieur = isset($_POST['interieur']) ? 1 : 0;
    $equipements = $_POST['equipements'];
    $etat = $_POST['etat'];
    $note = $_POST['note'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $sql = "INSERT INTO terrain (ville, nom_terrain, type_terrain, interieur, equipements, etat, note, longitude, latitude)
            VALUES (:ville, :nom_terrain, :type_terrain, :interieur, :equipements, :etat, :note, :longitude, :latitude)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ville' => $ville,
        ':nom_terrain' => $nom_terrain,
        ':type_terrain' => $type_terrain,
        ':interieur' => $interieur,
        ':equipements' => $equipements,
        ':etat' => $etat,
        ':note' => $note,
        ':longitude' => $longitude,
        ':latitude' => $latitude,
    ]);

    echo "Terrain ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un terrain</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
    ?>
    <h1>Ajouter un terrain</h1>
    <form method="POST" action="">
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" required><br>

        <label for="nom_terrain">Nom du terrain :</label>
        <input type="text" id="nom_terrain" name="nom_terrain" required><br>

        <label for="type_terrain">Type de terrain :</label>
        <input type="text" id="type_terrain" name="type_terrain" required><br>

        <label for="interieur">Intérieur :</label>
        <input type="checkbox" id="interieur" name="interieur"><br>

        <label for="equipements">Équipements :</label>
        <input type="text" id="equipements" name="equipements" required><br>

        <label for="etat">État :</label>
        <input type="text" id="etat" name="etat" required><br>

        <label for="note">Note :</label>
        <input type="number" id="note" name="note" step="0.1" required><br>

        <label for="longitude">Longitude :</label>
        <input type="text" id="longitude" name="longitude" required><br>

        <label for="latitude">Latitude :</label>
        <input type="text" id="latitude" name="latitude" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
<footer>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php');
    ?>
</footer>

</html>