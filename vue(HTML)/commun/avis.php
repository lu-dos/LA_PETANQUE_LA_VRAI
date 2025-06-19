<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laisser un avis</title>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/modele(SQL)/commun/avis.php');
$pdo = getPDO();
$avisList = getAvis($pdo);
?>
<div class="container">
    <h1>Laisser un avis</h1>
    <div class="card">
        <form action="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/controleur(PHP)/traitement_avis.php" method="POST">
            <label for="note">Note</label>
            <select id="note" name="note" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5" selected>5</option>
            </select>
            <label for="comment">Votre avis</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
            <input type="submit" value="Envoyer">
        </form>
    </div>

    <?php if (!empty($avisList)): ?>
    <h2>Derniers avis</h2>
    <?php foreach ($avisList as $avis): ?>
        <div class="avis-item">
            <strong><?= htmlspecialchars(trim(($avis['Prenom'] ?? '') . ' ' . ($avis['nom'] ?? 'Visiteur'))) ?></strong>
            <span>(<?= (int)$avis['note'] ?>/5)</span>
            <p><?= htmlspecialchars($avis['avis']) ?></p>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</body>
</html>
