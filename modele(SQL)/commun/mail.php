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
