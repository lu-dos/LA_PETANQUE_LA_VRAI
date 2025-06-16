<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php');

function getDbConnection() {
    return getPDO();
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
