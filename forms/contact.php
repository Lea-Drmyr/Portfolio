<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['name'];
    $email = $_POST['email'];
    $sujet = $_POST['subject'];
    $message = $_POST['message'];

    // $server = "localhost";      // ou NOM_PC\SQLEXPRESS
    // $database = "Portfolio";
    // $username = "Lea";
    // $password = "Fraise0712";
    $server = "LAPTOP-QOA5EODC";      
    $database = "Portfolio";
    $username = "";
    $password = "";

    try {

        $pdo = new PDO(
            "sqlsrv:Server=$server;Database=$database",
            $username,
            $password
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Messages (nom, email, sujet, message)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$nom, $email, $sujet, $message]);

        echo "OK";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}