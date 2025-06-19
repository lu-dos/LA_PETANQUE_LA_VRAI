<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/mail.php';
$pdo = getPDO();
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/utils.php';

if (isset($_GET['delete'])) {
    deleteMessage($pdo, (int)$_GET['delete']);
    header('Location: mails.php');
    exit();
}

$mails = getAllMessages($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des mails</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Gestion des mails</h1>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Expéditeur</th>
                    <th>Destinataire</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Lu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mails as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['Id_mail']) ?></td>
                    <td><?= htmlspecialchars($m['expediteur_prenom'] . ' ' . $m['expediteur_nom']) ?></td>
                    <td><?= htmlspecialchars($m['destinataire_prenom'] . ' ' . $m['destinataire_nom']) ?></td>
                    <td><?= htmlspecialchars($m['sujet'] ?? '') ?></td>
                    <td><?= htmlspecialchars(formatDatetimeFr($m['date_envoi'])) ?></td>
                    <td><?= $m['lu'] ? 'Oui' : 'Non' ?></td>
                    <td>
                        <a class="button" href="vue(HTML)/admin/mails.php?delete=<?= $m['Id_mail'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="7"><?= nl2br(htmlspecialchars($m['corps'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
