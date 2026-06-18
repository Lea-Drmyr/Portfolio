<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $sujet = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Adresse qui recevra les messages
    $destinataire = "durrmeyer.lea@gmail.com";

    $contenu = "
    Nom : $nom

    Email : $email

    Message :
    $message
    ";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if(mail($destinataire, $sujet, $contenu, $headers)){
        echo "OK";
    } else {
        echo "Erreur lors de l'envoi.";
    }
}
?>