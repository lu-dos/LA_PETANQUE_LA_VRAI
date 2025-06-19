<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php');

/**
 * Enregistre un avis utilisateur en base.
 *
 * @param PDO $pdo          Connexion PDO
 * @param int $utilisateur  Identifiant de l'utilisateur (0 si visiteur)
 * @param int $note         Note de 1 a 5
 * @param string $comment   Texte de l'avis
 *
 * @return bool             Succès de l'insertion
 */
function addAvis(PDO $pdo, int $utilisateur, int $note, string $comment): bool {
    $stmt = $pdo->prepare('INSERT INTO avis (utilisateur_id, note, avis) VALUES (?, ?, ?)');
    return $stmt->execute([$utilisateur, $note, $comment]);
}

/**
 * Récupère les avis stockés par ordre chronologique décroissant.
 *
 * @param PDO $pdo  Connexion PDO
 * @return array    Liste des avis avec informations utilisateur
 */
function getAvis(PDO $pdo): array {
    $sql = 'SELECT a.*, u.Prenom, u.nom FROM avis a LEFT JOIN utilisateur u ON a.utilisateur_id = u.Id_utilisateur ORDER BY a.created_at DESC';
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère un avis par son identifiant.
 *
 * @param PDO $pdo  Connexion PDO
 * @param int $id   Identifiant de l'avis
 *
 * @return array|false Les données de l'avis ou false si introuvable
 */
function getAvisById(PDO $pdo, int $id) {
    $stmt = $pdo->prepare('SELECT a.*, u.Prenom, u.nom FROM avis a LEFT JOIN utilisateur u ON a.utilisateur_id = u.Id_utilisateur WHERE id_avis = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Met à jour un avis existant.
 *
 * @param PDO    $pdo     Connexion PDO
 * @param int    $id      Identifiant de l'avis
 * @param int    $note    Nouvelle note
 * @param string $comment Nouveau texte de l'avis
 *
 * @return bool  Succès de la mise à jour
 */
function updateAvis(PDO $pdo, int $id, int $note, string $comment): bool {
    $stmt = $pdo->prepare('UPDATE avis SET note = ?, avis = ? WHERE id_avis = ?');
    return $stmt->execute([$note, $comment, $id]);
}

/**
 * Supprime un avis.
 *
 * @param PDO $pdo Connexion PDO
 * @param int $id  Identifiant de l'avis
 *
 * @return bool    Succès de la suppression
 */
function deleteAvis(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare('DELETE FROM avis WHERE id_avis = ?');
    return $stmt->execute([$id]);
}
?>
