<?php
function getDbConnection() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'tablepetanque';
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function isTerrainAvailable(PDO $pdo, $terrainId, $startDate, $endDate) {
    $sql = 'SELECT COUNT(*) FROM reservation WHERE Id_Terrain = :terrain AND date_debut < :end AND date_fin > :start';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':terrain' => $terrainId,
        ':end' => $endDate,
        ':start' => $startDate
    ]);
    return $stmt->fetchColumn() == 0;
}

function createReservation(PDO $pdo, $terrainId, $userId, $startDate, $endDate, $nbrUtil) {
    $sql = 'INSERT INTO reservation (Id_reservation, date_debut, date_fin, nbr_util, Id_Terrain, Id_utilisateur)
            VALUES (:id, :start, :end, :nbr, :terrain, :user)';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id' => uniqid(),
        ':start' => $startDate,
        ':end' => $endDate,
        ':nbr' => $nbrUtil,
        ':terrain' => $terrainId,
        ':user' => $userId
    ]);
}
?>
