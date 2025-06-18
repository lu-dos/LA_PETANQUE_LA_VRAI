<?php
require_once dirname(__DIR__, 2) . '/include(redondance)/init.php';

/**
 * Récupère le nombre d'utilisateurs inscrits.
 */
function fetchTotalUsers(PDO $pdo): int {
    return (int) $pdo->query('SELECT COUNT(*) FROM utilisateur')->fetchColumn();
}

function fetchTotalAdmins(PDO $pdo): int {
    return (int) $pdo->query('SELECT COUNT(*) FROM utilisateur WHERE isAdmin = 1')->fetchColumn();
}

function fetchTotalTerrains(PDO $pdo): int {
    return (int) $pdo->query('SELECT COUNT(*) FROM terrain')->fetchColumn();
}

function fetchReservedTerrains(PDO $pdo): int {
    return (int) $pdo->query('SELECT COUNT(DISTINCT Id_Terrain) FROM reservation')->fetchColumn();
}

/**
 * Calcule le taux d'occupation des terrains.
 *
 * @return float Ratio des terrains réservés sur le total des terrains
 */
function tauxOccupationTerrain(PDO $pdo): float {
    $total    = fetchTotalTerrains($pdo);
    if ($total === 0) {
        return 0.0;
    }
    $reserved = fetchReservedTerrains($pdo);
    return $reserved / $total;
}

/**
 *
 * @param PDO $pdo       
 * @param int $limit     
 *
 * @return array{ville:string,nbr:int}[]
 */
function fetchTopCities(PDO $pdo, int $limit = 5): array {
    $stmt = $pdo->query('SELECT ville, COUNT(*) AS nbr FROM utilisateur GROUP BY ville ORDER BY nbr DESC LIMIT ' . (int) $limit);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * @param PDO $pdo  
 * @param int $limit 
 */

function fetchTopReservers(PDO $pdo, int $limit = 5): array {
    $sql = 'SELECT u.nom, u.Prenom, COUNT(r.Id_reservation) AS nbr
            FROM utilisateur u
            LEFT JOIN reservation r ON u.Id_utilisateur = r.Id_utilisateur
            GROUP BY u.Id_utilisateur
            ORDER BY nbr DESC
            LIMIT ' . (int) $limit;
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
