<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = (int)($_POST['note'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    $name = '';
    if (!empty($_SESSION['Prenom']) || !empty($_SESSION['nom'])) {
        $name = trim(($_SESSION['Prenom'] ?? '') . ' ' . ($_SESSION['nom'] ?? ''));
    } else {
        $name = 'Visiteur';
    }

    $to = 'ludorouge7@gmail.com';
    $subject = 'Nouvel avis sur le site';
    $message = "Utilisateur: $name\n";
    $message .= "Note: $note/5\n\n";
    $message .= $comment;
    $headers = "From: noreply@example.com\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Merci pour votre avis !'); window.location.href='/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php';</script>";
    } else {
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logMessage = date('c') . " | $name ($note/5) : " . str_replace("\n", ' ', $comment) . PHP_EOL;
        file_put_contents($logDir . '/avis.log', $logMessage, FILE_APPEND);
        echo "<script>alert('Erreur lors de l\'envoi de l\'avis. Votre avis a été enregistré.'); window.history.back();</script>";
    }
}
?>
