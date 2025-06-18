<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $to = 'ludorouge7@gmail.com';
    $subject = 'Nouveau message depuis le formulaire de contact';

    $boundary = md5(uniqid(time()));

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
    $body .= "Nom: $name\n";
    $body .= "Email: $email\n\n";
    $body .= $message . "\n";

    if (!empty($_FILES['attachment']['name'][0])) {
        foreach ($_FILES['attachment']['tmp_name'] as $i => $tmpName) {
            if (is_uploaded_file($tmpName)) {
                $fileName = basename($_FILES['attachment']['name'][$i]);
                $fileType = mime_content_type($tmpName);
                $fileData = chunk_split(base64_encode(file_get_contents($tmpName)));
                $body .= "--$boundary\r\n";
                $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
                $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $body .= $fileData . "\r\n";
            }
        }
    }

    $body .= "--$boundary--";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Message envoyé !'); window.location.href='/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/vue(HTML)/commun/accueil.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'envoi du message.'); window.history.back();</script>";
    }
}
?>
