<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/db.php');

function sendMessage(PDO $pdo, int $expediteur, int $destinataire, string $sujet, string $corps): bool {
    $stmt = $pdo->prepare('INSERT INTO mail (expediteur_id, destinataire_id, sujet, corps) VALUES (?, ?, ?, ?)');
    return $stmt->execute([$expediteur, $destinataire, $sujet, $corps]);
}

function getReceivedMessages(PDO $pdo, int $userId): array {
    $sql = 'SELECT m.*, u.Prenom, u.nom
            FROM mail m
            JOIN utilisateur u ON m.expediteur_id = u.Id_utilisateur
            WHERE m.destinataire_id = ?
            ORDER BY m.date_envoi DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllUsers(PDO $pdo): array {
    return $pdo->query('SELECT Id_utilisateur, Prenom, nom FROM utilisateur')->fetchAll(PDO::FETCH_ASSOC);
}

function markMessageRead(PDO $pdo, int $messageId, int $userId): void {
    $stmt = $pdo->prepare('UPDATE mail SET lu = 1 WHERE Id_mail = ? AND destinataire_id = ?');
    $stmt->execute([$messageId, $userId]);
}

function deleteMessage(PDO $pdo, int $messageId): void {
    $stmt = $pdo->prepare('DELETE FROM mail WHERE Id_mail = ?');
    $stmt->execute([$messageId]);
}

function deleteReceivedMessage(PDO $pdo, int $messageId, int $userId): void {
    $stmt = $pdo->prepare('DELETE FROM mail WHERE Id_mail = ? AND destinataire_id = ?');
    $stmt->execute([$messageId, $userId]);
}

function getAllMessages(PDO $pdo): array {
    $sql = 'SELECT m.*, 
                   exp.Prenom AS expediteur_prenom, exp.nom AS expediteur_nom, 
                   dest.Prenom AS destinataire_prenom, dest.nom AS destinataire_nom
            FROM mail m
            JOIN utilisateur exp ON m.expediteur_id = exp.Id_utilisateur
            JOIN utilisateur dest ON m.destinataire_id = dest.Id_utilisateur
            ORDER BY m.date_envoi DESC';
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getUnreadCount(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM mail WHERE destinataire_id = ? AND lu = 0');
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}
