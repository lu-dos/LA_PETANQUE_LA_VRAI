<?php
require_once dirname(__DIR__, 2) . '/include(redondance)/init.php';

function getDbConnection() {
    return $GLOBALS['pdo'];
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

/**
 * Retrieve all reservations for a specific terrain.
 *
 * @param PDO $pdo         Database connection
 * @param int $terrainId   Terrain identifier
 *
 * @return array           List of reservations with start and end dates
 */
function getReservationsForTerrain(PDO $pdo, $terrainId) {
    $sql = 'SELECT date_debut, date_fin FROM reservation
            WHERE Id_Terrain = :terrain
            ORDER BY date_debut ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':terrain' => $terrainId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Retrieve all reservations for a specific user.
 *
 * @param PDO $pdo       Database connection
 * @param int $userId    User identifier
 *
 * @return array         List of reservations with terrain information
 */
function getReservationsForUser(PDO $pdo, $userId) {
    $sql = 'SELECT r.*, t.nom_terrain
            FROM reservation r
            JOIN terrain t ON r.Id_Terrain = t.Id_Terrain
            WHERE r.Id_utilisateur = :user
            ORDER BY r.date_debut DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Delete a reservation belonging to a specific user.
 *
 * @param PDO    $pdo  Database connection
 * @param string $id   Reservation identifier
 * @param int    $user User identifier
 *
 * @return bool        True on success
 */
function deleteReservation(PDO $pdo, $id, $user) {
    $stmt = $pdo->prepare('DELETE FROM reservation WHERE Id_reservation = :id AND Id_utilisateur = :user');
    return $stmt->execute([':id' => $id, ':user' => $user]);
}
?>
