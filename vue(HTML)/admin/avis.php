<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/avis.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/utils.php';
$pdo = getPDO();

if (isset($_GET['delete'])) {
    deleteAvis($pdo, (int)$_GET['delete']);
    header('Location: avis.php');
    exit();
}

$editAvis = null;
if (isset($_GET['edit'])) {
    $editAvis = getAvisById($pdo, (int)$_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = (int)$_POST['id'];
    $note = (int)$_POST['note'];
    $comment = trim($_POST['comment']);
    updateAvis($pdo, $id, $note, $comment);
    header('Location: avis.php');
    exit();
}

$avisList = getAvis($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des avis</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
    <h1>Gestion des avis</h1>
    <?php if ($editAvis): ?>
    <h2>Modifier un avis</h2>
    <div class="card">
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= htmlspecialchars($editAvis['id_avis']) ?>">
            <label>Note</label>
            <select name="note" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= $editAvis['note'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select><br>
            <label>Avis</label>
            <textarea name="comment" rows="4" required><?= htmlspecialchars($editAvis['avis']) ?></textarea><br>
            <button class="button" type="submit">Mettre à jour</button>
        </form>
    </div>
    <?php endif; ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Note</th>
                    <th>Avis</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avisList as $a): ?>
                <tr>
                    <td><?= htmlspecialchars(trim(($a['Prenom'] ?? '') . ' ' . ($a['nom'] ?? 'Visiteur'))) ?></td>
                    <td><?= (int)$a['note'] ?>/5</td>
                    <td><?= htmlspecialchars($a['avis']) ?></td>
                    <td><?= htmlspecialchars(formatDatetimeFr($a['created_at'])) ?></td>
                    <td>
                        <a class="button" href="vue(HTML)/admin/avis.php?delete=<?= $a['id_avis'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
                        |
                        <a class="button" href="vue(HTML)/admin/avis.php?edit=<?= $a['id_avis'] ?>">Modifier</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
