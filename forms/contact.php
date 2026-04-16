<?php
include("fonction.php"); 

// Connexion à la base de données
$cnx = connect_bd('portfolio');

if ($cnx) {
    // Préparation de la requête (une seule fois)
    $result = $cnx->prepare('INSERT INTO contact (name, email, subject, message) 
                             VALUES (:name, :email, :subject, :message)'); 

    // Récupération et nettoyage des données du formulaire
    $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
    $subject = trim(filter_input(INPUT_POST, "subject", FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
    $message = trim(filter_input(INPUT_POST, "message", FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 

    // Vérifier si le sujet est vide, et si oui, le mettre à NULL ou à "Non précisé"
    if (empty($subject)) {
        $subject = NULL;  // Ou vous pouvez utiliser "Non précisé" si vous préférez
    }

    // Déboguer les valeurs récupérées
    var_dump($name, $email, $subject, $message); // Cela vous montrera les valeurs récupérées

    // Vérification que toutes les données sont présentes et non vides
    if (!empty($name) && !empty($email) && !empty($message)) {
        // On lie chaque marqueur à une variable
        $result->bindParam(':name', $name, PDO::PARAM_STR); 
        $result->bindParam(':email', $email, PDO::PARAM_STR); 
        $result->bindParam(':subject', $subject, PDO::PARAM_STR); 
        $result->bindParam(':message', $message, PDO::PARAM_STR); 

        // Exécution de la requête
        if ($result->execute()) {
            // Envoi du message et redirection après succès
            echo '<p>' . $result->rowCount() . ' Votre message a été envoyé. ID : ' . $cnx->lastInsertId() . '</p>';
            header('Location: ../index.html');
            exit();
        } else {
            // Si l'exécution échoue, afficher une erreur
            echo '<p>Erreur lors de l\'envoi du message.</p>';
        }
    } else {
        // Si des données sont manquantes ou vides
        echo '<p>Tous les champs doivent être remplis.</p>';
    }
} else {
    // Erreur si la connexion échoue
    echo '<p>Échec de la connexion à la base de données.</p>';
}

// Déconnexion de la base de données
deconnect_bd('portfolio');
?>
