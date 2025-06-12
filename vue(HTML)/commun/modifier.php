<?php
// Restrict page access to administrators only
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

if (empty($_GET['id'])) {
    echo 'Aucun identifiant de terrain fourni.';
    exit();
}

$terrainId = $_GET['id'];

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tablepetanque';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Handle form submission
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

    $sql = "UPDATE terrain SET ville=:ville, nom_terrain=:nom_terrain, type_terrain=:type_terrain, interieur=:interieur, equipements=:equipements, etat=:etat, note=:note, longitude=:longitude, latitude=:latitude WHERE Id_Terrain=:id";
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
        ':id' => $terrainId,
    ]);

    header('Location: resa2.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM terrain WHERE Id_Terrain = ?');
$stmt->execute([$terrainId]);
$terrain = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$terrain) {
    echo 'Terrain non trouvé';
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le terrain</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
<h1>Modifier le terrain</h1>
<form method="POST" action="">
    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($terrain['ville']) ?>" required><br>

    <label for="nom_terrain">Nom du terrain :</label>
    <input type="text" id="nom_terrain" name="nom_terrain" value="<?= htmlspecialchars($terrain['nom_terrain']) ?>" required><br>

    <label for="type_terrain">Type de terrain :</label>
    <input type="text" id="type_terrain" name="type_terrain" value="<?= htmlspecialchars($terrain['type_terrain']) ?>" required><br>

    <label for="interieur">Intérieur :</label>
    <input type="checkbox" id="interieur" name="interieur" <?php if ($terrain['interieur']) echo 'checked'; ?>><br>

    <label for="equipements">Équipements :</label>
    <input type="text" id="equipements" name="equipements" value="<?= htmlspecialchars($terrain['equipements']) ?>" required><br>

    <label for="etat">État :</label>
    <input type="text" id="etat" name="etat" value="<?= htmlspecialchars($terrain['etat']) ?>" required><br>

    <label for="note">Note :</label>
    <input type="number" id="note" name="note" step="0.1" value="<?= htmlspecialchars($terrain['note']) ?>" required><br>

    <label for="longitude">Longitude :</label>
    <input type="text" id="longitude" name="longitude" value="<?= htmlspecialchars($terrain['longitude']) ?>" required><br>

    <label for="latitude">Latitude :</label>
    <input type="text" id="latitude" name="latitude" value="<?= htmlspecialchars($terrain['latitude']) ?>" required><br>

    <button class="button" type="submit">Mettre à jour</button>
</form>
</div>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
