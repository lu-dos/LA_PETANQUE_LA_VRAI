<?php
// Restrict page access to administrators only
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header('Location: /E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/login.php');
    exit();
}

// Database connection
require_once dirname(__DIR__, 2) . '/include(redondance)/init.php';

// Delete user
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM utilisateur WHERE Id_utilisateur = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: utilisateurs.php');
    exit();
}

$editUser = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE Id_utilisateur = ?');
    $stmt->execute([$_GET['edit']]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['Prenom']);
    $mail   = trim($_POST['mail']);
    $ville  = trim($_POST['ville']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    if ($_POST['action'] === 'add') {
        $mdp = password_hash(trim($_POST['mdp']), PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, Prenom, mail, ville, mot_de_passe, isAdmin) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$nom, $prenom, $mail, $ville, $mdp, $isAdmin]);
    } elseif ($_POST['action'] === 'update' && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $fields = ['nom' => $nom, 'Prenom' => $prenom, 'mail' => $mail, 'ville' => $ville, 'isAdmin' => $isAdmin];
        $sql = 'UPDATE utilisateur SET nom=:nom, Prenom=:Prenom, mail=:mail, ville=:ville, isAdmin=:isAdmin';
        if (!empty($_POST['mdp'])) {
            $fields['mot_de_passe'] = password_hash(trim($_POST['mdp']), PASSWORD_DEFAULT);
            $sql .= ', mot_de_passe=:mot_de_passe';
        }
        $sql .= ' WHERE Id_utilisateur=:id';
        $fields['id'] = $id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($fields);
    }
    header('Location: utilisateurs.php');
    exit();
}

// Fetch all users
$stmt = $pdo->query('SELECT Id_utilisateur, nom, Prenom, mail, ville, isAdmin FROM utilisateur');
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'); ?>
<div class="container">
<h1>Gestion des Utilisateurs</h1>

<h2><?php echo $editUser ? 'Modifier un utilisateur' : 'Ajouter un utilisateur'; ?></h2>
<div class="card">
<form method="POST" action="">
    <input type="hidden" name="action" value="<?php echo $editUser ? 'update' : 'add'; ?>">
    <?php if ($editUser): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($editUser['Id_utilisateur']); ?>">
    <?php endif; ?>
    <label>Nom</label>
    <input type="text" name="nom" value="<?php echo $editUser ? htmlspecialchars($editUser['nom']) : ''; ?>" required><br>
    <label>Prénom</label>
    <input type="text" name="Prenom" value="<?php echo $editUser ? htmlspecialchars($editUser['Prenom']) : ''; ?>" required><br>
    <label>Mail</label>
    <input type="email" name="mail" value="<?php echo $editUser ? htmlspecialchars($editUser['mail']) : ''; ?>" required><br>
    <label>Ville</label>
    <input type="text" name="ville" value="<?php echo $editUser ? htmlspecialchars($editUser['ville']) : ''; ?>" required><br>
    <label>Mot de passe<?php if (!$editUser) echo ' (obligatoire)'; ?></label>
    <input type="password" name="mdp" <?php echo $editUser ? '' : 'required'; ?>><br>
    <label>Admin</label>
    <input type="checkbox" name="isAdmin" value="1" <?php if ($editUser && $editUser['isAdmin']) echo 'checked'; ?>><br>
    <input type="submit" value="<?php echo $editUser ? 'Mettre à jour' : 'Ajouter'; ?>">
</form>
</div>

<h2>Liste des utilisateurs</h2>
<div class="card">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Ville</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $u): ?>
        <tr>
            <td><?php echo htmlspecialchars($u['Id_utilisateur']); ?></td>
            <td><?php echo htmlspecialchars($u['nom']); ?></td>
            <td><?php echo htmlspecialchars($u['Prenom']); ?></td>
            <td><?php echo htmlspecialchars($u['mail']); ?></td>
            <td><?php echo htmlspecialchars($u['ville']); ?></td>
            <td><?php echo $u['isAdmin'] ? 'Oui' : 'Non'; ?></td>
            <td>
                <a class="button" href="vue(HTML)/admin/utilisateurs.php?edit=<?php echo $u['Id_utilisateur']; ?>">Modifier</a>
                |
                <a class="button" href="vue(HTML)/admin/utilisateurs.php?delete=<?php echo $u['Id_utilisateur']; ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<p style="text-align:center;">Nombre d'utilisateurs : <?php echo count($utilisateurs); ?>.</p>
<p style="text-align:center;">Pour toute question, <a href="vue(HTML)/commun/contact.php">contactez le créateur</a>.</p>
</div>
</body>
<footer>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'); ?>
</footer>
</html>
