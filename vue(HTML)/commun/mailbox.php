<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['Id_utilisateur'])) {
    header('Location: login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/mail.php';
$pdo = getPDO();
$userId = (int)$_SESSION['Id_utilisateur'];

// Mark as read
if (isset($_GET['read'])) {
    markMessageRead($pdo, (int)$_GET['read'], $userId);
    header('Location: mailbox.php');
    exit();
}

if (isset($_GET['delete'])) {
    deleteReceivedMessage($pdo, (int)$_GET['delete'], $userId);
    header('Location: mailbox.php');
    exit();
}

// Send message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dest = (int)($_POST['destinataire'] ?? 0);
    $sujet = trim($_POST['sujet'] ?? '');
    $corps = trim($_POST['corps'] ?? '');
    if ($dest && $corps !== '') {
        sendMessage($pdo, $userId, $dest, $sujet, $corps);
    }
    header('Location: mailbox.php');
    exit();
}

$messages = getReceivedMessages($pdo, $userId);
$users = getAllUsers($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte de Réception</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Boîte de Réception</h1>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>De</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Lu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['Prenom'] . ' ' . $m['nom']) ?></td>
                    <td><?= htmlspecialchars($m['sujet'] ?? '') ?></td>
                    <td><?= htmlspecialchars($m['date_envoi']) ?></td>
                    <td>
                        <?= $m['lu'] ? 'Oui' : 'Non' ?>
                        <?php if (!$m['lu']): ?>
                            <a href="vue(HTML)/commun/mailbox.php?read=<?= $m['Id_mail'] ?>">Marquer comme lu</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="vue(HTML)/commun/mailbox.php?delete=<?= $m['Id_mail'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><?= nl2br(htmlspecialchars($m['corps'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2>Envoyer un message</h2>
    <div class="card">
        <form method="POST" action="vue(HTML)/commun/mailbox.php">
            <label>Destinataire</label>
            <select name="destinataire" required>
                <?php foreach ($users as $u): if ($u['Id_utilisateur'] != $userId): ?>
                    <option value="<?= $u['Id_utilisateur'] ?>">
                        <?= htmlspecialchars($u['Prenom'] . ' ' . $u['nom']) ?>
                    </option>
                <?php endif; endforeach; ?>
            </select><br>
            <label>Sujet</label>
            <input type="text" name="sujet"><br>
            <label>Message</label>
            <textarea name="corps" rows="4" required></textarea><br>
            <button class="button" type="submit">Envoyer</button>
        </form>
    </div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
